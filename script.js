// Fetch data from the server using AJAX
// https://www.chartjs.org/docs/latest/charts/line.html
fetch('data.php')
    .then(response => response.json())
    .then(giot_db => {
        const timestamps = giot_db.map(entry => entry.Timestamp);
        const temperatures = giot_db.map(entry => entry.Temperature);
      
        // Create a chart
        const ctx = document.getElementById('sensorChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            
            data: {
                labels: timestamps,
                datasets: [
                    {
                        label: 'Temperature ',
                      // data: [65, 59, 80, 81, 56, 55, 40],
                        data: temperatures,
                        fill: false,
                        borderColor: 'rgba(255, 0, 255,1)',
                        yAxisID: 'y-axis-1',
                        tension: 0.1
                    }
                ],
            },
            options: {
                scales: {
                    yAxes: [
                        {
                            
                            id: 'y-axis-1',
                            type: 'linear',
                            position: 'left',
                        },

                    ],
                },
            },
        });
    })
    .catch(error => console.error('Error fetching data:', error));
