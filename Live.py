from flask import Flask, request, jsonify
import joblib
import numpy as np


app = Flask(__name__)

# Загрузите вашу модель при запуске сервера
model = joblib.load('model.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Получите данные из запроса
        data = request.get_json(force=True)
        # Преобразуйте данные в массив NumPy (или Pandas DataFrame), если это необходимо
        # features = np.array(data['features'])
        # Выполните предсказание
        prediction = model.predict(data)
        # Отправьте результат обратно
        return jsonify({'prediction': prediction.tolist()})
    except Exception as e:
        return jsonify({'error': str(e)})

if __name__ == '__main__':
    app.run(port=5000)
