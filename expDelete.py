import requests

url = 'http://joerihermans.com/~wok/restserver/experiments/delete'
headers = {'Content-type': 'application/json'}
requests.post(url, headers=headers)
