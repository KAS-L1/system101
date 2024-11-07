from flask import Flask, request, jsonify
from sklearn.naive_bayes import GaussianNB
import pandas as pd

app = Flask(__name__)

# Sample audit data
def load_audit_data():
    data = {
        "severity": [1, 2, 3, 1, 2],  # 1 = Low, 2 = Medium, 3 = High
        "frequency": [5, 15, 25, 10, 30],
        "risk": [0, 0, 1, 0, 1]  # 1 = High risk, 0 = Low risk
    }
    return pd.DataFrame(data)

data = load_audit_data()
X = data[["severity", "frequency"]]
y = data["risk"]
model = GaussianNB()
model.fit(X, y)

@app.route('/predict_non_compliance_risk', methods=['POST'])
def predict_non_compliance_risk():
    request_data = request.get_json()
    severity = request_data['severity']
    frequency = request_data['frequency']
    prediction = model.predict([[severity, frequency]])[0]
    return jsonify({'risk': 'High' if prediction == 1 else 'Low'})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
