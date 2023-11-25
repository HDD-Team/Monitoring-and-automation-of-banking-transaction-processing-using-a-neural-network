import joblib
import pandas as pd
from sklearn.metrics import accuracy_score
from sklearn.model_selection import train_test_split
from sklearn.neural_network import MLPClassifier
from sklearn.preprocessing import StandardScaler

# Step 1: Prepare your data
# loadet_data = pd.read_csv("fraud_dataset.csv", sep=';')
loadet_data = pd.read_excel("fraud_dataset_1.xlsx")
# Preprocess your data as needed

# formatting data
a = {'es_transportation': 1, 'es_health': 2, 'es_otherservices': 3, 'es_food': 4, 'es_hotelservices': 5,
     'es_barsandrestaurants': 6,
     'es_tech': 7, 'es_sportsandtoys': 8, 'es_wellnessandbeauty': 9, 'es_hyper': 10, 'es_fashion': 11, 'es_home': 12,
     'es_contents': 13, 'es_travel': 14, 'es_leisure': 15}
loadet_data['category'] = loadet_data['category'].replace(a)
loadet_data['customer'] = loadet_data['customer'].str[1:]
loadet_data['merchant'] = loadet_data['merchant'].str[1:]

X = loadet_data.drop(['age', 'gender'], axis=1)

# X = loadet_data.drop(columns=['customer', 'merchant', 'category', 'amount'])
X = X.to_numpy()[:, (1, 2, 4, 6, 7)]

y = loadet_data['fraud']

X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Step 3: Import necessary modules

# Step 4: Create an instance of the neural network model
model = MLPClassifier(hidden_layer_sizes=(100,), activation='relu', solver='adam')

# Step 5: Train the model
print(X_train)
scaler = StandardScaler()
X_train_scaled = scaler.fit_transform(X_train)
model.fit(X_train_scaled, y_train)

# Step 6: Evaluate the model
X_test_scaled = scaler.transform(X_test)
y_pred = model.predict(X_test_scaled)

# Step 7: Save the model
scaler = joblib.dump(scaler, 'scaler.pkl')
model = joblib.dump(model, 'model.pkl')

# Step 8: Evaluate the performance using appropriate metric
accuracy = accuracy_score(y_test, y_pred)
print("Accuracy:", accuracy)
# print(y_means, proba_means)

# Evaluate the performance using appropriate metriccs
