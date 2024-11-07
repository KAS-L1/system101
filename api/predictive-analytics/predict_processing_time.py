from flask import Flask, request, jsonify
from sklearn.tree import DecisionTreeRegressor
import pandas as pd

app = Flask(__name__)

# Sample document processing data
def load_document_data():
    data = {
        "document_type": [1, 2, 1, 3, 2],  # Coded types
        "priority": [1, 2, 2, 3, 1],  # 1 = Low, 2 = Medium, 3 = High
        "processing_time": [2, 5, 3, 7, 4]  # Processing time in days
    }
    return pd.DataFrame(data)

data = load_document_data()
X = data[["document_type", "priority"]]
y = data["processing_time"]
model = DecisionTreeRegressor()
model.fit(X, y)

@app.route('/predict_processing_time', methods=['POST'])
def predict_processing_time():
    request_data = request.get_json()
    document_type = request_data['document_type']
    priority = request_data['priority']
    prediction = model.predict([[document_type, priority]])[0]
    return jsonify({'predicted_processing_time': prediction})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5002)
