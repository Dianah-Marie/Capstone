<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <h2>Tardy Records by Section (Line Chart)</h2>
  <canvas id="tardyChart" width="600" height="400"></canvas>

  <script>
    fetch("tardy_data.php") // gets JSON from PHP
      .then(response => response.json())
      .then(result => {
        const ctx = document.getElementById('tardyChart').getContext('2d');
        new Chart(ctx, {
          type: 'line', // ✅ changed to line chart
          data: {
            labels: result.labels, // Sections on X-axis
            datasets: [{
              label: 'Tardy Count',
              data: result.data,
              borderColor: 'rgba(255, 99, 132, 1)',
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              fill: true,   // fill under the line
              tension: 0.3, // smooth curve
              pointRadius: 5,
              pointBackgroundColor: 'rgba(255, 99, 132, 1)'
            }]
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Tardy Count by Section'
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                title: { display: true, text: 'Number of Tardy Learners' }
              },
              x: {
                title: { display: true, text: 'Sections' }
              }
            }
          }
        });
      });
  </script>
</body>
</html>
