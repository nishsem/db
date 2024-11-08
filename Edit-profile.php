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

// initally all variable set to nothing

$id = $ic = $name = $sex = $address = $hobby = $state = $height = $weight = "";



// Check if an ID is provided in the URL

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    

    // Fetch the profile data for the given ID

    $sql = "SELECT * FROM profiles WHERE id = $id";

    $result = $conn->query($sql);

    

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        $ic = $row['ic'];

        $name = $row['name'];

        $sex = $row['sex'];

        $address = $row['address'];

        $hobby = $row['hobby'];

        $state = $row['state'];

        $height = $row['height'];

        $weight = $row['weight'];

    } else {

        echo "No profile found with that ID.";

        exit();

    }

}



// Process form submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST['id'];

    $ic = $_POST['ic'];

    $name = $_POST['name'];

    $sex = $_POST['sex'];

    $address = $_POST['address'];

    $hobby = $_POST['hobby'];

    $state = $_POST['state'];

    $height = $_POST['height'];

    $weight = $_POST['weight'];



    $sql = "UPDATE profiles SET 

            ic = '$ic', 

            name = '$name', 

            sex = '$sex', 

            address = '$address', 

            hobby = '$hobby', 

            state = '$state', 

            height = '$height', 

            weight = '$weight' 

            WHERE id = $id";

//echo $sql

    if ($conn->query($sql) === TRUE) {

        echo "Profile updated successfully";

    } else {

        echo "Error updating profile: " . $conn->error;

    }

}

?>



<!DOCTYPE html>

<html>

<head>

    <title>Edit Profile</title>

</head>

<body>

    <h2>Edit Profile</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <input type="hidden" name="id" value="<?php echo $id; ?>">

        IC: <input type="text" name="ic" value="<?php echo $ic; ?>"><br><br>

        Name: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

        Sex: <input type="text" name="sex" value="<?php echo $sex; ?>"><br><br>

        Address: <input type="text" name="address" value="<?php echo $address; ?>"><br><br>

        Hobby: <input type="text" name="hobby" value="<?php echo $hobby; ?>"><br><br>

        State: <input type="text" name="state" value="<?php echo $state; ?>"><br><br>

        Height: <input type="text" name="height" value="<?php echo $height; ?>"><br><br>

        Weight: <input type="text" name="weight" value="<?php echo $weight; ?>"><br><br>

        <input type="submit" value="Update Profile">

    </form>

</body>

</html>



<?php

// Close connection

$conn->close();

?>

