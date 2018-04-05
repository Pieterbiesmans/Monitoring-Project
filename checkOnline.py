import requests

url = 'http://joerihermans.com/~wok/restserver/check'
headers = {'Content-type': 'application/json'}
requests.post(url, headers=headers)
