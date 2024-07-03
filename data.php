<?php
// Establish a database connection (replace with your actual database credentials)
$servername = "localhost";
  $username = "root";
  $password = "";
  $database = "iot_db";

  // Establish a database connection (replace with your actual database credentials)
  $conn = new mysqli($servername, $username, $password, $database);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

// Query to retrieve temperature and humidity data
// $sql = "SELECT Timestamp, Value FROM SensorReadings WHERE iot_db.sensors.SensorName = 'Temperature' LIMIT 0, 25;";

$sql = "SELECT Timestamp, Value FROM SensorReadings
JOIN Sensors ON SensorReadings.SensorID = Sensors.SensorID
JOIN Devices ON Sensors.DeviceID = Devices.DeviceID
JOIN Locations ON Devices.LocationID = Locations.LocationID
JOIN Users ON Devices.UserID = Users.UserID WHERE Sensors.SensorId = 4
ORDER BY SensorReadings.Timestamp ASC;";


$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'Timestamp' => $row['Timestamp'],
            'Temperature' => (float) $row['Value']
        ];
    }
}

// Close the database connection
$conn->close();

// Send data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
