from flask import Flask, request, jsonify
import numpy as np
import pandas as pd
from sklearn.linear_model import LinearRegression
from sklearn.naive_bayes import GaussianNB
from sklearn.tree import DecisionTreeRegressor

app = Flask(__name__)

# Demand Forecasting
def load_demand_data():
    data = {"month": range(1, 13), "quantity": [100, 120, 130, 150, 170, 200, 210, 220, 240, 250, 270, 300]}
    return pd.DataFrame(data)

def train_demand_model(data):
    model = LinearRegression()
    X = data[['month']]
    y = data['quantity']
    model.fit(X, y)
    return model

demand_data = load_demand_data()
demand_model = train_demand_model(demand_data)

@app.route('/predict_demand', methods=['POST'])
def predict_demand():
    data = request.json
    month = data.get('month')
    prediction = demand_model.predict(np.array([[month]]))
    return jsonify({"status": "success", "predicted_demand": prediction[0]})

# Non-Compliance Risk Prediction
@app.route('/predict_non_compliance_risk', methods=['POST'])
def predict_non_compliance_risk():
    # Placeholder model and example values for demonstration
    severity = request.json.get('severity')
    frequency = request.json.get('frequency')
    risk = severity * frequency  # Simplified example
    return jsonify({"status": "success", "risk": risk})

# Document Processing Time Prediction
@app.route('/predict_processing_time', methods=['POST'])
def predict_processing_time():
    document_type = request.json.get('document_type')
    priority = request.json.get('priority')
    processing_time = document_type * priority  # Simplified example
    return jsonify({"status": "success", "predicted_processing_time": processing_time})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)
