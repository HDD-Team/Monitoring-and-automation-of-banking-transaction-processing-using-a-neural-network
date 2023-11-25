import json

import requests

# Пример новых данных
new_data = '{"Unnamed: 0":0,"numbers":88,"step":0,"customer":583110837,"age":3,"gender":"M","zipcodeOri":28007,"merchant":480139044,"zipMerchant":28007,"category":"es_health","amount":150000.0,"fraud":1}'

# Отправка HTTP-запроса
response = requests.post('http://localhost:5000/predict', json=new_data)

# Получение предсказаний
predictions = json.loads(response.text)['prediction']
