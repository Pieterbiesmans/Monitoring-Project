import fcntl
import json
import os
import requests
import socket
import struct


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

data = {'ipAddr':ipAddr}
url = 'http://joerihermans.com/~wok/restserver/nodes/online'
headers = {'Content-type': 'application/json'}
requests.post(url, data=json.dumps(data), headers=headers)
