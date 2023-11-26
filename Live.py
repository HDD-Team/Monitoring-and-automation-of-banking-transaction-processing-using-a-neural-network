import joblib
import pandas as pd
from sklearn.preprocessing import StandardScaler
from flask import Flask, request, jsonify, render_template
import subprocess as sp
import os
from sklearn.pipeline import Pipeline

app = Flask(__name__)

# Загрузите вашу модель при запуске сервера
model = joblib.load('model_pipeline.pkl')
print(os.path.join(os.path.dirname(__file__), 'templates', 'index.php'))
@app.route('/', methods = ['GET','POST'])
def index():
    index_php_path = os.path.join(os.path.dirname(__file__), 'templates', 'index.php')
    out = sp.run(["php", index_php_path], stdout=sp.PIPE)
    return out.stdout
@app.route('/predict', methods=['POST'])
def predict():
    try:
        # Получите данные из запроса
        new_data = request.get_json(force=True)
        # Преобразуйте данные в массив NumPy (или Pandas DataFrame), если это необходимо
        data = pd.DataFrame(new_data)

        data['customer'] = data['customer'].astype(str)
        data['merchant'] = data['merchant'].astype(str)

        a = {'es_transportation': 1, 'es_health': 2, 'es_otherservices': 3, 'es_food': 4, 'es_hotelservices': 5,
             'es_barsandrestaurants': 6,
             'es_tech': 7, 'es_sportsandtoys': 8, 'es_wellnessandbeauty': 9, 'es_hyper': 10, 'es_fashion': 11,
             'es_home': 12,
             'es_contents': 13, 'es_travel': 14, 'es_leisure': 15}
        data['category'] = data['category'].replace(a)

        X = data[['customer', 'merchant', 'category', 'amount']].to_numpy()

        # Применение scaler пайплайна к данным
        scaler = model.named_steps['scaler']
        X_scaled = scaler.transform(X)

        # Прогнозирование меток вероятности
        new_y_pred_proba = model.predict_proba(X_scaled)
        # Make predictions on the new dataset
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
        print(status)
        # Отправьте результат обратно
        return jsonify({'status': status, 'prediction': prediction})
    except Exception as e:
        return jsonify({'error': str(e)})


if __name__ == '__main__':
    app.run(debug=True, port=5000)
