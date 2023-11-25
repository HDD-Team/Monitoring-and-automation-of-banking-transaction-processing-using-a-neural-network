import joblib
import pandas as pd
from flask import Flask, request, jsonify

app = Flask(__name__)

# Загрузите вашу модель при запуске сервера
model = joblib.load('model.pkl')
scaler = joblib.load('scaler.pkl')


@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Получите данные из запроса
        new_data = request.get_json(force=True)
        # Преобразуйте данные в массив NumPy (или Pandas DataFrame), если это необходимо
        data = pd.read_json(new_data)

        print(data)
        data['customer'] = data['customer'].astype(str)
        data['merchant'] = data['merchant'].astype(str)

        a = {'es_transportation': 1, 'es_health': 2, 'es_otherservices': 3, 'es_food': 4, 'es_hotelservices': 5,
             'es_barsandrestaurants': 6,
             'es_tech': 7, 'es_sportsandtoys': 8, 'es_wellnessandbeauty': 9, 'es_hyper': 10, 'es_fashion': 11,
             'es_home': 12,
             'es_contents': 13, 'es_travel': 14, 'es_leisure': 15}
        data['category'] = data['category'].replace(a)
        data['customer'] = data['customer'].str[1:]
        data['merchant'] = data['merchant'].str[1:]

        new_X = data.drop(['age', 'gender'], axis=1)
        new_X = new_X.to_numpy()[:, (2, 3, 5, 7, 8)]

        new_X_scaled = scaler.transform(new_X)

        # Make predictions on the new dataset
        new_y_pred = model.predict(new_X_scaled)
        new_y_pred_proba = model.predict_proba(new_X_scaled)[:, 1]

        status = []
        prediction = []
        for row, prob in zip(data.iterrows(), new_y_pred_proba):
            prediction.append(prob)
            if new_y_pred[row[0]] == 1:
                if 0.5 <= prob <= 0.7:
                    status.append('FREEZE')
                elif prob > 0.7:
                    status.append('STOP')
            elif new_y_pred[row[0]] == 0:
                status.append('SAFE')

        # Отправьте результат обратно
        return jsonify({'status': status, 'prediction': prediction})
    except Exception as e:
        return jsonify({'error': str(e)})


if __name__ == '__main__':
    app.run(debug=True, port=5000)
