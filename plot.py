from flask import Flask, render_template
import pymysql
import matplotlib.pyplot as plt
from io import BytesIO
import base64

app = Flask(__name__)

# Database configuration
db = pymysql.connect(
    host="localhost",
    user="root",
    password="",
    database="iot_db"
)

@app.route('/')
def index():
    # Retrieve temperature data from the database
    cursor = db.cursor()
    cursor.execute("SELECT Timestamp, Value FROM SensorReadings "
                   "JOIN Sensors ON SensorReadings.SensorID = Sensors.SensorID "
                   "WHERE Sensors.SensorName = 'TemperatureSensor' "
                   "ORDER BY Timestamp")
    
    # Extract data for plotting
    timestamps = []
    temperatures = []
    for row in cursor.fetchall():
        timestamps.append(row[0])
        temperatures.append(float(row[1]))

    # Create a line plot
    plt.figure(figsize=(10, 6))
    plt.plot(timestamps, temperatures, marker='o', linestyle='-')
    plt.title('Temperature Data')
    plt.xlabel('Timestamp')
    plt.ylabel('Temperature (°C)')
    plt.grid(True)

    # Convert the plot to an image
    img = BytesIO()
    plt.savefig(img, format='png')
    img.seek(0)
    plot_url = base64.b64encode(img.getvalue()).decode()
    
    return render_template('index.html', plot_url=plot_url)

if __name__ == '__main__':
    app.run(debug=True)
