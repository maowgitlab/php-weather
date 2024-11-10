<?php 
    $apiKey = "API_KEY";
    $city = "TODO";
    $endpoint = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

    $weatherData = file_get_contents($endpoint);
    $weatherArray = json_decode($weatherData, true);

    if ($weatherArray['cod'] == 200) {
        $temperature = $weatherArray['main']['temp'];
        $weatherDescription = $weatherArray['weather'][0]['description'];
        $humidity = $weatherArray['main']['humidity'];

        echo "City: {$city}<br>";
        echo "Temperature: {$temperature} K<br>";
        echo "Weather Description: {$weatherDescription}<br>";
        echo "Humidity: {$humidity}%<br>";
    } else {
        echo "Error: {$weatherArray['message']}<br>";
    }