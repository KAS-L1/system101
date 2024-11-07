from flask import Flask, request, jsonify
import pandas as pd
from sklearn.linear_model import LinearRegression
import numpy as np

app = Flask(__name__)

# Sample data for demonstration purposes
def load_data():
    data = {
        "date": pd.date_range(start="2023-01-01", periods=12, freq="M"),
        "quantity": [100, 120, 130, 150, 170, 200, 210, 220, 240, 250, 270, 300]
    }
    df = pd.DataFrame(data)
    df['month'] = df['date'].dt.month
    df['year'] = df['date'].dt.year
    return df

data = load_data()
model = LinearRegression()
model.fit(data[['month', 'year']], data['quantity'])

@app.route('/predict_demand', methods=['POST'])
def predict_demand():
    request_data = request.get_json()
    month = request_data['month']
    year = request_data['year']
    prediction = model.predict([[month, year]])[0]
    return jsonify({'predicted_demand': prediction})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
