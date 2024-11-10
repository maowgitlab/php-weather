<?php
    $apiKey = "API_KEY";
    $city = isset($_GET['city']) ? $_GET['city'] : "";
    $weatherArray = [];
    if ($city) {
        $endpoint = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        $weatherData = @file_get_contents($endpoint);
        if ($weatherData === false) {
            $weatherArray['cod'] = 404;
        } else {
            $weatherArray = json_decode($weatherData, true);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather APP</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .weather-result {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .weather-result h2 {
            margin-bottom: 10px;
        }

        .weather-result p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Weather APP with PHP</h1>
        <form action="" method="get">
            <input type="text" name="city" placeholder="Enter city name" value="<?= $city ?? ""; ?>" required>
            <button type="submit">Get Weather</button>
            <button type="button" onclick="getCurrentLocation()">By Your Location</button>
            <button type="button" onclick="window.location.href='level-2.php'">reset</button>
        </form>
        <?php if (isset($weatherArray['cod']) && $weatherArray['cod'] == 200) :
            $temperature = $weatherArray['main']['temp'];
            $weatherDescription = $weatherArray['weather'][0]['description'];
            $humidity = $weatherArray['main']['humidity']; ?>
            <div class="weather-result">
                <h2>Weather in <?= $city; ?> Today</h2>
                <p>Temperature: <?= $temperature; ?> C</p>
                <p>Weather Description: <?= $weatherDescription; ?></p>
                <p>Humidity: <?= $humidity; ?>%</p>
            </div>
        <?php elseif (isset($weatherArray['cod']) && $weatherArray['cod'] == 404) : ?>
            <script> 
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Your Location Not Listed in API', 
                    text: 'Please use another location' 
                }); 
            </script>
        <?php else : ?>
            <p>Result here</p>
        <?php endif; ?>
    </div>

    <script>
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {   
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const apiKey = "API_KEY";
            const endpoint = `https://api.openweathermap.org/geo/1.0/reverse?lat=${lat}&lon=${lon}&limit=1&appid=${apiKey}`;
            fetch(endpoint)
                .then(response => response.json())
                .then(data => {
                    const city = data[0].name;
                    document.querySelector('input[name="city"]').value = city;
                })
                .catch(error => console.error('Error:', error)
            );
        }
    </script>
</body>

</html>