from multiprocessing import Pool
import fcntl
import json
import multiprocessing
import os
import signal
import requests
import socket
import struct
import subprocess
import time
import sys


def get_ip_address(ifname):
    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        address = socket.inet_ntoa(fcntl.ioctl(
            s.fileno(),
            0x8915,
            struct.pack('256s', str.encode(ifname[:15]))
        )[20:24])
    except BaseException:
        address = None
    return address


def get_network_interfaces():
    interfaces = os.listdir('/sys/class/net/')
    interfaces.remove('lo')
    return interfaces


network_interfaces = get_network_interfaces()
for iface in network_interfaces:
    ipAddr = get_ip_address(iface)
    if ipAddr is not None:
        break

try:
    r = requests.get("http://joerihermans.com/~wok/restserver/experiments")
    experiments = r.json()
except requests.exceptions.ConnectionError:
    print e
    sys.exit(1)

# check if experiments are available.

if len(experiments) == 0:
    exit(0)

test = experiments[0]['config']
serv = experiments[0]['server']
clie = experiments[0]['client']
id = experiments[0]['id']
rep = int(experiments[0]['repeat'])

count = 0


def single_pass_throughput(a):
    try:
        import iperf3
        client = iperf3.Client()
        client.duration = 5
        client.bind_address = clie
        client.server_hostname = serv
        client.port = 5201
        client.num_streams = 1
        result = client.run()
        data = result.received_MB_s
        print(data)
        data = {'id': id, 'key': 'throughput', 'data': data}
        url = 'http://joerihermans.com/~wok/restserver/experiments/data'
        headers = {'Content-type': 'application/json'}
        requests.post(url, data=json.dumps(data), headers=headers)
        success = True
    except BaseException:
        success = False

    return success


def single_pass_jitter(a):
    print("TestJitter")
    try:
        import iperf3
        client = iperf3.Client()
        client.duration = 5
        client.bind_address = clie
        client.server_hostname = serv
        client.port = 5201
        client.num_streams = 1
        client.protocol = 'udp'
        result = client.run()
        data = result.jitter_ms
        print(data)
        data = {'id': id, 'key': 'jitter', 'data': data}
        url = 'http://joerihermans.com/~wok/restserver/experiments/data'
        headers = {'Content-type': 'application/json'}
        requests.post(url, data=json.dumps(data), headers=headers)
        success = True
    except BaseException:
        success = False

    return success


def single_pass_server():
    import iperf3
    server = iperf3.Server()
    server.bind_address = serv
    server.port = 5201
    server.verbose = False
    server.run()


def experiment_active(id):
    url = 'http://joerihermans.com/~wok/restserver/terminate/' + id
    r = requests.get(url)
    
    return r.text == "TRUE"


def watchdog():
    while True:
        time.sleep(2)
        if not experiment_active(id):
            os.killpg(os.getpgrp(),signal.SIGTERM)
            os.kill(os.getppid(), signal.SIGTERM)
            exit(1)


if serv == ipAddr and test != 'ping':
    watchdog_process = multiprocessing.Process(target=watchdog)
    watchdog_process.start()
    while count < rep:
        print('test')
        process = multiprocessing.Process(target=single_pass_server)
        process.start()
        process.join()
        del process
        count += 1
        print(count)
        if count == rep:
            data = {'id': id, 'done': '1'}
            url = 'http://joerihermans.com/~wok/restserver/experiments/update'
            headers = {'Content-type': 'application/json'}
            r = requests.post(url, data=json.dumps(data), headers=headers)
    watchdog_process.terminate()
    watchdog_process.join()

if clie == ipAddr and test == 'throughput':
    while count < rep:
        pool = Pool(1)
        result = pool.map(single_pass_throughput, [1])[0]
        pool.close()
        time.sleep(2)
        if not result:
            sys.exit(1)
        else:
            count += 1

        print(count)
        pool.join()

if clie == ipAddr and test == 'jitter':
    while count < rep:
        pool = Pool(1)
        result = pool.map(single_pass_jitter, [1])[0]
        pool.close()
        time.sleep(2)
        if not result:
            sys.exit(1)
        else:
            count += 1

        print(count)
        pool.join()
if clie == ipAddr and test == 'ping':
    while count < rep:
        output = subprocess.check_output(
            "ping -c 4 " +
            serv +
            " | tail -n 1 | awk '{print $4}' | cut -d '/' -f 2",
            shell=True)
        output = float(output)
        data = str(output)
        print(data)
        data = {'id': id, 'key': 'ping', 'data': data}
        url = 'http://joerihermans.com/~wok/restserver/experiments/data'
        headers = {'Content-type': 'application/json'}
        r = requests.post(url, data=json.dumps(data), headers=headers)
        status = r.status_code
        if status == 200:
            count += 1
            print(count)

        if count == rep:
            data = {'id': id, 'done': '1'}
            url = 'http://joerihermans.com/~wok/restserver/experiments/update'
            headers = {'Content-type': 'application/json'}
            r = requests.post(url, data=json.dumps(data), headers=headers)
