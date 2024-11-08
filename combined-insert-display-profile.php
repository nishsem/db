
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



// Insert data if form is submitted

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

    

    // Execute the query

    if ($conn->query($sql) === TRUE) {

        echo "New profile inserted successfully";

    } else {

        echo "Error: " . $sql . "<br>" . $conn->error;

    }

}



?>



<!DOCTYPE html>

<html>

<head>

    <title>Profile Management</title>

</head>

<body>

    <h2>Insert New Profile</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        IC: <input type="text" name="ic" value="791023"><br><br>

        Name: <input type="text" name="name" value="Soh Chin Aun"><br><br>

        Sex: <input type="text" name="sex" value="M"><br><br>

        Address: <input type="text" name="address" value="Lot 4536, Jalan Seribu Tahun, Olak Lempit"><br><br>

        Hobby: <input type="text" name="hobby" value="Bolasepak"><br><br>

        State: <input type="text" name="state" value="Melaka"><br><br>

        Height: <input type="text" name="height" value="175"><br><br>

        Weight: <input type="text" name="weight" value="56"><br><br>

        <input type="submit" value="Insert Profile">

    </form>



    <h2>Existing Profiles</h2>

    <?php

    // SQL query to select data from profiles table

    $sql = "SELECT * FROM profiles";

    $result = $conn->query($sql);



    // Check if there are results

    if ($result->num_rows > 0) {

        // Output data of each row

        echo "<table border='1'>

                <tr>

                    <th>ID</th>

                    <th>IC</th>

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

                    <td>" . $row["ic"] . "</td>

                    <td>" . $row["name"] . "</td>

                    <td>" . $row["sex"] . "</td>

                    <td>" . $row["address"] . "</td>

                    <td>" . $row["hobby"] . "</td>

                    <td>" . $row["state"] . "</td>

                    <td>" . $row["height"] . "</td>

                    <td>" . $row["weight"] . "</td><td><a href='edit-profile.php?id=" . $row["id"] . "'>Edit</a></td>

                  </tr>";

        }

        echo "</table>";

    } else {

        echo "0 results";

    }



    // Close connection

    $conn->close();

    ?>

</body>

</html>