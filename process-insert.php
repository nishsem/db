<?php

// Database connection information

$servername = "localhost";

$username = "nish";

$password = "nish1234";

$dbname = "test";



// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



// Get form data (for this example, you could replace these values with real form data)

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$ic = $_POST['ic'];

$name = $_POST['name'];

$sex = $_POST['sex'];

$address = $_POST['address'];

$hobby = $_POST['hobby'];

$state = $_POST['state'];

$height = $_POST['height'];

$weight = $_POST['weight'];



// Basic SQL Insert Query

$sql = "INSERT INTO profiles (ic, name, sex, address, hobby, state, height, weight)

        VALUES ('$ic', '$name', '$sex', '$address', '$hobby', '$state', '$height', '$weight')";

echo $sql;

// Execute the query

$conn->query($sql);

}

// Close connection

$conn->close();

?>

