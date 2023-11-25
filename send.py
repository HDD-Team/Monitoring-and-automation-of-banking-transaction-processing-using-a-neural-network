import json

import requests

# Пример новых данных
new_data = 'output.json'
# Отправка HTTP-запроса
response = requests.post('http://localhost:5000/predict', json=new_data)

# Получение предсказаний
# predic_status = json.loads(response.text)['status']
print(response.json())