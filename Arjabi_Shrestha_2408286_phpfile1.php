<?php
// Student Name: Arjabi Shrestha
// Student id: 2408286

// The following php is for fetching the data from api, inserting it into the database's(Weather_App) table and return the data  as a json format

// allows requests from any domain
header('Access-Control-Allow-Origin: *');

// text/html lai json format ma convert garcha
header("Content-type:application/json");

$host = 'localhost';
$username = 'root';
$password = '';

//establishes a connection with the database
$mysqli = mysqli_connect($host, $username, $password); 

// Check connection.
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

// If a database does not exist creats a database "Weather_App"
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS Weather_App";

// selects the created database "Weather_App"
mysqli_select_db($mysqli, "Weather_App");

// Creating a table "past_data" in the "Weather_App"
$sqlCreateTable = "
CREATE TABLE IF NOT EXISTS past_data (
        city_id INT AUTO_INCREMENT PRIMARY KEY,
        city VARCHAR(50),
        day_and_date VARCHAR(50),
        weather_condition VARCHAR(50),
        weather_icon VARCHAR(50),
        temp INT,
        pressure INT,
        wind_speed DECIMAL(5, 2),
        humidity INT
)";

// close the database connection
mysqli_close($mysqli);

 
// fetch_data_from_api() is a function that fetches the data of a particular city from the API
function fetch_data_from_api($city){
    try{
        $apiKey = "cbff425b743ae1c8ca5d20dc363724e2";   
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}";


        $response = file_get_contents($apiUrl);

        $data = json_decode($response, true);
    
        return $data; 
    }
    // if any exception is caught is throws a detailed error message
    catch(exception $th){
        error_log("Error: " . $th->getMessage());
    }
}

// connect_database() is a function that establishes connection with a particular database
function connect_database($server, $username, $password, $db){
    try{
        // Creates a new mysqli object with the provided connection parameters
        $connection = new mysqli($server, $username, $password, $db);

        // Checks if there are any errors in the connection
        if($connection->connect_errno){
            echo '{"error":"Database connection failed"}';
        }
        return $connection;
    }
    // if any exception is caught is throws a detailed error message
    catch(Exception $th){
        echo("Error: " . $th->getMessage());
    }
}

//  get_past_data() is a function that fetches past data of a particular city from the database
function get_past_data($connection, $city){
    try {
        // executes a SELECT query to retrieve all data of a city from the table "past_data" 
        $result = $connection->query("SELECT * FROM past_data WHERE city = '$city';");
        if($result){
            // Fetches all rows as an associative array
            $data = $result->fetch_all(MYSQLI_ASSOC);
            return $data;
        }
        else{
            // if there is no data it returns null
            return null;
        }
    
    }
    // if any exception is caught is throws a detailed error message} 
    catch (Exception $th) {
        echo("Error: " . $th->getMessage());
    }
}

// insert_past_data() is a function that inserst past weather data into the table: past_data
function insert_past_data($connection,$city, $day_and_date, $weather_condition, $weather_icon, $temp, $pressure, $wind_speed, $humidity) {
    try {
        //executes an INSERT query to insert data into database
        $query = "INSERT INTO past_data
                      (city, day_and_date, weather_condition, weather_icon, temp, pressure, wind_speed, humidity) 
                    VALUES 
                      ('$city', '$day_and_date', '$weather_condition', '$weather_icon', $temp, $pressure, $wind_speed, $humidity)";

            //executing the query
            $connection->query($query);
       
    } 
    // if any exception is caught is throws a detailed error message} 
    catch (Exception $th) {
        echo '{"Error":"' . $th->getMessage() . '"}';
    }
}


// Check if city name is set entered in the url
if (isset($_GET["city"])){
    // If the city is provided, assigns the value(city's name) to the variable $city
    $city = $_GET["city"];
}else{
    // If not, echo a JSON response indicating that no city was provided
    echo '{"error":"no city provided"}';
}

// Calling the function fetch_data_from_api() to retrive current weather data from the api of the city entered
$new_data = fetch_data_from_api($city);

if ($new_data !== null) {
    // connecion with the database
    $connection = connect_database($host, $username, $password, "Weather_App");

    // Extracting information from the API response and storing it in respective variables
    $city = $new_data['name'];
    $day_and_date = $new_data['dt'];   
    $weather_condition = $new_data['weather'][0]['main'];   
    $weather_icon = $new_data['weather'][0]['icon'];        
    $temp_in_kelvin = $new_data['main']['temp'];            
    $temp = convertKelvinToCelsius($temp_in_kelvin);
    $pressure = $new_data['main']['pressure'];
    $wind_speed = $new_data['wind']['speed'];
    $humidity = $new_data['main']['humidity'];

    // calling the function insert_past_data() and sending the data as arguments to be inserted into the databale table
    insert_past_data($connection,$city, $day_and_date, $weather_condition, $weather_icon, $temp, $pressure, $wind_speed, $humidity);
    
    //closing the database connection
    mysqli_close($connection);
    }else {
    echo 'Failed to fetch weather data from OpenWeatherMap API';
}

function convertKelvinToCelsius($kelvin) {
    return round($kelvin - 273.15);
}


// establishes connecion with the database by calling dunction connect_database()
$mysqli = connect_database($host, $username, $password, "Weather_App");

// executes a SELECT query to retrieve all data from the table "past_data" 
$alldata = "SELECT * FROM past_data";

// Performs query using the MySQLi connection object $mysqli
$result = mysqli_query($mysqli, $alldata);

if (!$result) {
    // displays an error if there is no data in the database
    echo "Error: " . mysqli_error($mysqli);
} else {
    $data = array();

    // Loops through each row of the result and stores it in the $data array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Checks if there is any data in the $data array
    if (count($data) == 0) {
        $currentData = null;

    } else {
        // Gets the last row from the database, i.e., the data of the city searched
        $lastIndex = count($data) - 1;
        $currentData = $data[$lastIndex];
    }
    
    // Converts the fetched data to JSON format
    $currentDataJson = json_encode($currentData);
    echo($currentDataJson);
}

// Close the database connection
mysqli_close($mysqli);
?>

