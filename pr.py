import joblib
import pandas as pd

model = joblib.load('model.pkl')
scaler = joblib.load('scaler.pkl')
# Load the new dataset
new_data = pd.read_excel('test_data.xlsx')
new_data.rename(columns={' ': 'numbers'}, inplace=True)

# Extract the features from the new dataset
a = {'es_transportation': 1, 'es_health': 2, 'es_otherservices': 3, 'es_food': 4, 'es_hotelservices': 5,
     'es_barsandrestaurants': 6,
     'es_tech': 7, 'es_sportsandtoys': 8, 'es_wellnessandbeauty': 9, 'es_hyper': 10, 'es_fashion': 11, 'es_home': 12,
     'es_contents': 13, 'es_travel': 14, 'es_leisure': 15}
new_data['category'] = new_data['category'].replace(a)
new_data['customer'] = new_data['customer'].str[1:]
new_data['merchant'] = new_data['merchant'].str[1:]

new_X = new_data.drop(['age', 'gender'], axis=1)
new_X = new_X.to_numpy()[:, (2, 3, 5, 7, 8)]

# Scale the features
new_X_scaled = scaler.transform(new_X)

# Make predictions on the new dataset
new_y_pred = model.predict(new_X_scaled)
new_y_pred_proba = model.predict_proba(new_X_scaled)[:, 1]

print(new_y_pred)
# Print the results
status = []
for row, prob in zip(new_data.iterrows(), new_y_pred_proba):
    if new_y_pred[row[0]] == 1:
        if 0.5 <= prob <= 0.7:
            status.append('FREEZE')
        elif prob > 0.7:
            status.append('STOP')
    elif new_y_pred[row[0]] == 0:
        status.append('SAFE')

new_data.index = range(len(new_data))
new_data['status'] = status

rev_a = {bufer: key for key, bufer in a.items()}
new_data['category'] = new_data['category'].replace(rev_a)
print(new_data['status'])

new_data.to_excel('output.xlsx')

df = pd.read_excel('output.xlsx')

# Convert the DataFrame to JSON
json_data = df.to_json(orient='records')

# Save the JSON data to a file
with open('templates/output.json', 'w') as f:
    f.write(json_data)
