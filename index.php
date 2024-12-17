<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to bottom, #6baedc, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .weather-card {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .weather-icon {
            width: 50px;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="weather-card text-center">
            <h1 class="mb-4">Weather App</h1>
            <form id="weatherForm" class="mb-4" method ="POST">
                <div class="mb-3">
                    <select id="cityInput" class="form-select" name="city" required>
                        <option value="" selected disabled>Select a city</option>
                        <option value="Casablanca">Casablanca</option>
                        <option value="Rabat">Rabat</option>
                        <option value="Marrakech">Marrakech</option>
                        <option value="Tangier">Tangier</option>
                        <option value="Fes">Fes</option>
                        <option value="Agadir">Agadir</option>
                        <option value="Oujda">Oujda</option>
                        <option value="Tetouan">Tetouan</option>
                        <option value="Meknes">Meknes</option>
                        <option value="Laayoune">Laayoune</option>
                        <option value="Dakhla">Dakhla</option>
                        <option value="Essaouira">Essaouira</option>
                        <option value="Nador">Nador</option>
                        <option value="Safi">Safi</option>
                        <option value="Ouarzazate">Ouarzazate</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="Getweather">Get Weather</button>
            </form>
            <div >
                <?php 
                        if (isset($_POST['Getweather'])) {
                            $city=$_POST['city'];
                            $apikey= 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
                            $url = "https://api.openweathermap.org/data/2.5/weather?q=$city,ma&APPID=$apikey&units=metric";
                            $req=curl_init();
                            curl_setopt($req, CURLOPT_URL, $url);
                            curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
                            $response = curl_exec($req);
                            curl_close($req);
                            if ($response) {
                                $data = json_decode($response,true);
                                if (isset($data['main']['temp'])) {
                                    $temp=$data['main']['temp'];
                                    $description=$data['weather'][0]['description'];
                                    $icon=$data['weather'][0]['icon'];

                                    echo "<img id='weatherIcon' class='weather-icon' alt='Weather Icon' src='http://openweathermap.org/img/w/$icon.png'><h2 id='cityName' class='mb-2'> $city</h2><p id='temperature' class='mb-2'>  $temp °C</p><p id='weatherDescription' class='mb-0'>  $description</p>";
                                }else {
                                    echo "<p class='mb-0'>there is somthing else while getting data</p>";
                                }
                            }else {
                            echo "<p class='mb-0'>there is somthing else with the API</p>";
                            }
                        }else {
                                echo "<p class='mb-0'>there is somthing else with the API</p>";
                        }
                        ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </body>
</html>


