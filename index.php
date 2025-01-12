<?php
if(array_key_exists('submit', $_GET)){
    //checking if input is empty
    if(!$_GET['city']) {
        $error = "Input field is empty";
    }
    if ($_GET['city']){
        $apiData = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".
            $_GET['city']."&appid=3794141fe0cac15a9225a73d70d21ce8");
        echo "$apiData";
        $weather_array =json_decode($apiData, true);
        if($weather_array['cod'] == 200) {
            //C= K - 273.15
            $tempCelsius = $weather_array['main']['temp'] - 273;


            $weather = " <b> Cloudness: </b> " . $weather_array['clouds']['all'] . "% <br>";
            date_default_timezone_set('Australia/Sydney');
            $weather .= " <b> Weather Condition: </b> " . $weather_array['weather']['0']
                ['description'] . "<br>";
            $sunrise = $weather_array['sys']['sunrise'];
            $weather .= "<b>Sunrise : </b>" . date("F j, Y, g:i a", $sunrise) . "<br>";
            $weather .= "<b>Current Time : </b>" . date("F j, Y, g:i a"). "<br>";
            $weather .= " <b> Atmosperic Pressure: </b> " . $weather_array['main']['pressure'] .
                "hPa <br>";
            $weather .= " <b> Wind Speed: </b> " . $weather_array['wind']['speed'] . "meter/sec<br>
           ";
            $weather .= "<b>" . $weather_array['name'] . "," . $weather_array['sys']['country'] . ":
         " . intval($tempCelsius) . "&deg;C</b> <br> ";


        }else{
            $error = "Could not find city";
        }


    }
}
?>
//this is a test to be pushed
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="design.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100&family=Zen+Loop:ital@1&display=swap" rel="stylesheet">
        <title>Main Page</title>
        <style>
            .temperature{
                padding-top: 80px;
                float: right;
            }
            .outcome{
                padding-left: 830px;
                float: left;
            }

        </style>
    </head>
    <body>
        <!-- navigation bar -->
        <header>
            <nav>
                <h1>Weather</h1>
                <div class="container">
                    <div class="hyperlinks">
                            <a href="index.php">Home</a>

                            <a href="#">10-Days</a>
                            <a href="#">Monthly</a>
                            <a href="#">Weather Map</a>
                            <a href="#">Feedback</a>
                    </div>
                    <div class ="dropdown">
                        <button class ="dropbtn"><span class="material-symbols-outlined">person</span></button>
                        <div class = "dropdown-content">
                            <a href="login.php">Login</a>
                            <a href="register.php">Signup</a>
                            <a href="logout.php">Log out</a>
                        </div>
                    </div>
                </div>
                <form action="" method="GET">
                    <label for="city">Enter city name</label>
                    <p><input type="text" name="city" id="city" placeholder="CityName"></p>
                    <button type="submit" name="submit" class="btn btn-success">Submit Now</button>


                    <div class="output mt-3">


                        <?php

                        if($weather) {
                            echo '<div class="alert alert-success" role="alert">
                    '. $weather.'
                </div>';
                        }
                        //                    if($error){
                        //                        echo '<div class="alert alert-danger" role="alert">
                        //                    '. $error.'
                        //                </div>';
                        //                    }
                        function tempConvert($valueConvert, $convertType)
                        {
                            if($convertType == "fahrenheit"){
                                $conversion = ((9/5) * $valueConvert) + (32);
                            }
                            else if ($convertType == "celsius"){
                                $conversion = ($valueConvert - 32) * (5/9);
                            }
                            return $conversion;
                        }

                        $valueConvert = $_POST['valueConvert'];
                        $convertType = $_POST['convertType'];
                        $conversion = tempConvert($valueConvert, $convertType);
                        if($convertType == "fahrenheit"){
                            echo "<span class='outcome'>$valueConvert celsius. In fahrenheit, that is $conversion degrees!";
                        }
                        elseif ($convertType == "celsius"){
                            echo "<span class='outcome'>$valueConvert fahrenheit. In celsius, that is $conversion degrees!";
                        }



                        ?>

