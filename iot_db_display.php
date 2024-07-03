<!DOCTYPE html>
<html>

<head>
  <title>IOT Page</title>
</head>

<body>
  <?php
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
  // Query to retrieve data from the database
  $sql = "SELECT * FROM SensorReadings
              JOIN Sensors ON SensorReadings.SensorID = Sensors.SensorID
              JOIN Devices ON Sensors.DeviceID = Devices.DeviceID
              JOIN Locations ON Devices.LocationID = Locations.LocationID
              JOIN Users ON Devices.UserID = Users.UserID
              ORDER BY SensorReadings.Timestamp DESC";

  $result = $conn->query($sql);

  if ($result === false) {
    die("Query failed: " . $conn->error);
  }
  if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
              <th>Timestamp</th>
              <th>User</th>
              <th>Location</th>
              <th>Device</th>
              <th>Sensor</th>
              <th>Value</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["Timestamp"] . "</td>";
      echo "<td>" . $row["Username"] . "</td>";
      echo "<td>" . $row["LocationName"] . "</td>";
      echo "<td>" . $row["DeviceName"] . "</td>";
      echo "<td>" . $row["SensorName"] . "</td>";
      echo "<td>" . $row["Value"] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
  } else {
    echo "No data found.";
  }
  // Close the database connection
  $conn->close();
  ?>
</body>

</html>