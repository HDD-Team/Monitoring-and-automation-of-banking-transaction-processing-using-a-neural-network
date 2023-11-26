import joblib
import pandas as pd
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split
from sklearn.neural_network import MLPClassifier
from sklearn.preprocessing import StandardScaler
from sklearn.pipeline import Pipeline

# Загрузка данных
loadet_data = pd.read_excel("fraud_dataset_1.xlsx")

# Предобработка данных
loadet_data['category'] = pd.Categorical(loadet_data['category']).codes
loadet_data['customer'] = loadet_data['customer'].str[1:]
loadet_data['merchant'] = loadet_data['merchant'].str[1:]

X = loadet_data[['customer', 'merchant', 'category', 'amount']].to_numpy()
y = loadet_data['fraud']

# Разделение данных на обучающую и тестовую выборки
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Создание пайплайна
pipeline = Pipeline([
    ('scaler', StandardScaler()),
    ('model', MLPClassifier(hidden_layer_sizes=(100,), activation='relu', solver='adam'))
])

# Обучение модели
pipeline.fit(X_train, y_train)

# Предсказание меток для тестовых данных
y_pred = pipeline.predict(X_test)

# Вычисление точности
accuracy = accuracy_score(y_test, y_pred)
print("Accuracy:", accuracy)

# Сохранение обученной модели
joblib.dump(pipeline, 'model_pipeline.pkl')