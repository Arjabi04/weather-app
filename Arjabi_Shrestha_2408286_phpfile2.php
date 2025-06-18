<?php
// Student Name: Arjabi Shrestha
// Student id: 2408286

// The following php is for fetching the existing data from database "Weather_App" and return it as a json format


// allows requests from any domain
header('Access-Control-Allow-Origin: *');

// text/html lai json format ma convert garcha
header("Content-type:application/json");

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'Weather_App';

//establishes a connection with the database
$mysqli = mysqli_connect($host, $username, $password, $database);

// displays a message if connection is failed
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

// checks if theres a city parameter is in URL.
if (isset($_GET["city"])){
    // if there is a city parameter, gets city name entered in the input box and stores it into the variable  ity
    $city = $_GET["city"];
}else{
    // if not, throws an error message
    echo '{"error":"no city provided"}';
}


// Fetches all the data from the database whose city name matches the city entered in the input box
$sqlSelectData = "SELECT * FROM past_data WHERE city = '$city'";

// Performs query against a database and stores it in result
$result = mysqli_query($mysqli, $sqlSelectData);

// Checks if the query was successful
if ($result) {
    // If successful, fetche each row and store it in an associative array
    while ($row = mysqli_fetch_assoc($result)){
        // Store each row in the $data array
        $data[] = $row;
    }

    // Encode the data as JSON
    $jsonData = json_encode($data);

    // Output the JSON data
    echo $jsonData;

} else {
    // if the query fails, displays error message
    echo "Error: " . mysqli_error($mysqli);
}

// Close the database connection
mysqli_close($mysqli);

?>