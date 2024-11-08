
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



$editId = $ic = $name = $sex = $address = $hobby = $state = $height = $weight = "";

$message = "";



// List of states

$states = [

    "Selangor", "Johor", "Pulau Pinang", "Kuala Lumpur", "Perak", "Terengganu",

    "Pahang", "Sabah", "Sarawak", "Putrajaya", "Perlis", "Kedah", "Melaka",

    "N. Sembilan", "Kelantan", "WP Labuan"

];



// Handle form submissions

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['action'])) {

        if ($_POST['action'] == 'insert') {

            // Insert new profile

            $ic = $_POST['ic'];

            $name = $_POST['name'];

            $sex = $_POST['sex'];

            $address = $_POST['address'];

            $hobby = $_POST['hobby'];

            $state = $_POST['state'];

            $height = $_POST['height'];

            $weight = $_POST['weight'];



            $sql = "INSERT INTO profiles (ic, name, sex, address, hobby, state, height, weight)

                    VALUES ('$ic', '$name', '$sex', '$address', '$hobby', '$state', '$height', '$weight')";

            

            if ($conn->query($sql) === TRUE) {

                $message = "New profile inserted successfully";

            } else {

                $message = "Error: " . $sql . "<br>" . $conn->error;

            }

        } elseif ($_POST['action'] == 'update') {

            // Update existing profile

            $editId = $_POST['id'];

            $ic = $_POST['ic'];

            $name = $_POST['name'];

            $sex = $_POST['sex'];

            $address = $_POST['address'];

            $hobby = $_POST['hobby'];

            $state = $_POST['state'];

            $height = $_POST['height'];

            $weight = $_POST['weight'];



            $sql = "UPDATE profiles SET 

                    ic = '$ic', name = '$name', sex = '$sex', address = '$address', 

                    hobby = '$hobby', state = '$state', height = '$height', weight = '$weight' 

                    WHERE id = $editId";



            if ($conn->query($sql) === TRUE) {

                $message = "Profile updated successfully";

            } else {

                $message = "Error updating profile: " . $conn->error;

            }

        }

    }

}



// Handle edit requests

if (isset($_GET['edit'])) {

    $editId = $_GET['edit'];

    $sql = "SELECT * FROM profiles WHERE id = $editId";

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

    }

}



?>



<!DOCTYPE html>

<html>

<head>

    <title>Profile Management</title>

    <style>

        table {

            border-collapse: collapse;

            width: 100%;

        }

        th, td {

            border: 1px solid black;

            padding: 8px;

            text-align: left;

        }

        th {

            background-color: #f2f2f2;

        }

    </style>

</head>

<body>

    <h1>Profile Management</h1>

    

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>



    <h2><?php echo $editId ? "Edit Profile" : "Insert New Profile"; ?></h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <input type="hidden" name="action" value="<?php echo $editId ? 'update' : 'insert'; ?>">

        <?php if ($editId): ?>

            <input type="hidden" name="id" value="<?php echo $editId; ?>">

        <?php endif; ?>

        

        IC: <input type="text" name="ic" value="<?php echo $ic; ?>"><br><br>

        Name: <input type="text" name="name" value="<?php echo $name; ?>"><br><br>

        

        Sex:

        <input type="radio" id="male" name="sex" value="M" <?php echo ($sex == 'M') ? 'checked' : ''; ?>>

        <label for="male">Male</label>

        <input type="radio" id="female" name="sex" value="F" <?php echo ($sex == 'F') ? 'checked' : ''; ?>>

        <label for="female">Female</label><br><br>

        

        Address: <input type="text" name="address" value="<?php echo $address; ?>"><br><br>

        Hobby: <input type="text" name="hobby" value="<?php echo $hobby; ?>"><br><br>

        

        State:

        <select name="state">

            <?php foreach ($states as $stateOption): ?>

                <option value="<?php echo $stateOption; ?>" <?php echo ($state == $stateOption) ? 'selected' : ''; ?>>

                    <?php echo $stateOption; ?>

                </option>

            <?php endforeach; ?>

        </select><br><br>

        

        Height: <input type="text" name="height" value="<?php echo $height; ?>"><br><br>

        Weight: <input type="text" name="weight" value="<?php echo $weight; ?>"><br><br>

        

        <input type="submit" value="<?php echo $editId ? 'Update Profile' : 'Insert Profile'; ?>">

        <?php if ($editId): ?>

            <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Insert New</a>

        <?php endif; ?>

    </form>



    <h2>Existing Profiles</h2>

    <?php

    // Display existing profiles

    $sql = "SELECT * FROM profiles";

    $result = $conn->query($sql);



    if ($result->num_rows > 0) {

        echo "<table>

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

                    <th>Action</th>

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

                    <td>" . $row["weight"] . "</td>

                    <td><a href='" . $_SERVER['PHP_SELF'] . "?edit=" . $row["id"] . "'>Edit</a></td>

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