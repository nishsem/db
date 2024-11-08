<?php

$servername = "localhost";

$username = "nish"; // Replace with your user

$password = "nish1234"; // Replace with user password

$dbname = "test";



// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);



// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}



// SQL query to select data from profiles table

$sql = "SELECT * FROM profiles";

$result = $conn->query($sql);  //execute your SQL statement



// Check if there are results

if ($result->num_rows > 0) {

    // Output data of each row

    echo "<table border='1'>

            <tr>

                <th>ID</th>

                <th>Name</th>

                <th>Sex</th>

                <th>Address</th>

                <th>Hobby</th>

                <th>State</th>

                <th>Height</th>

                <th>Weight</th>

            </tr>";

    while ($row = $result->fetch_assoc()) {

        echo "<tr>

                <td>" . $row["id"] . "</td>

                <td>" . $row["name"] . "</td>

                <td>" . $row["sex"] . "</td>

                <td>" . $row["address"] . "</td>

                <td>" . $row["hobby"] . "</td>

                <td>" . $row["state"] . "</td>

                <td>" . $row["height"] . "</td>

                <td>" . $row["weight"] . "</td>

              </tr>";

    }

    echo "</table>";

} else {

    echo "0 results";

}



// Close connection

$conn->close();

?>