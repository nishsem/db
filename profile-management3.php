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

// Initialize variables
$editId = null; // Initialize editId to avoid 'undefined variable' errors
$ic = $name = $sex = $address = $hobby = $state = $height = $weight = "";
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
        $ic = $_POST['ic'];
        $name = $_POST['name'];
        $sex = $_POST['sex'];
        $address = $_POST['address'];
        $hobby = $_POST['hobby'];
        $state = $_POST['state'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];

        if ($_POST['action'] == 'insert') {
            // Insert new profile
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
        body {
            font-family: Arial, sans-serif;
            background: url('pic.jpg') no-repeat center center fixed; /* Change the URL here */
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }
        .form-container {
            backdrop-filter: blur(10px); /* Glass effect */
            background: rgba(255, 255, 255, 0.3); /* Semi-transparent white */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            margin: 20px auto;
        }
        h1, h2 {
            text-align: center;
            color: #fff;
        }
        input[type="text"], input[type="submit"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="radio"] {
            margin-right: 10px;
        }
        label {
            color: #fff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            color: #fff;
        }
        th {
            background-color: rgba(255, 255, 255, 0.2);
        }
        td a {
            color: #00f;
        }
    </style>
</head>
<body>
    <h1>Profile Management</h1>

    <?php if (!empty($message)) echo "<p style='color:white; text-align:center;'>$message</p>"; ?>

    <div class="form-container">
        <h2><?php echo $editId ? "Edit Profile" : "Insert New Profile"; ?></h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="action" value="<?php echo $editId ? 'update' : 'insert'; ?>">
            <?php if ($editId): ?>
                <input type="hidden" name="id" value="<?php echo $editId; ?>">
            <?php endif; ?>
            
            <label for="ic">IC:</label>
            <input type="text" id="ic" name="ic" value="<?php echo $ic; ?>" required><br>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required><br>
            
            <label>Sex:</label><br>
            <input type="radio" id="male" name="sex" value="M" <?php echo ($sex == 'M') ? 'checked' : ''; ?> required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="sex" value="F" <?php echo ($sex == 'F') ? 'checked' : ''; ?> required>
            <label for="female">Female</label><br><br>
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>
            
            <label for="hobby">Hobby:</label>
            <input type="text" id="hobby" name="hobby" value="<?php echo $hobby; ?>" required><br>
            
            <label for="state">State:</label>
            <select id="state" name="state" required>
                <?php foreach ($states as $stateOption): ?>
                    <option value="<?php echo $stateOption; ?>" <?php echo ($state == $stateOption) ? 'selected' : ''; ?>>
                        <?php echo $stateOption; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            
            <label for="height">Height:</label>
            <input type="text" id="height" name="height" value="<?php echo $height; ?>" required><br>
            
            <label for="weight">Weight:</label>
            <input type="text" id="weight" name="weight" value="<?php echo $weight; ?>" required><br><br>
            
            <input type="submit" value="<?php echo $editId ? 'Update Profile' : 'Insert Profile'; ?>">
            <?php if ($editId): ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" style="color: white;">Insert New</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="profile-list">
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
                        <td>{$row['id']}</td>
                        <td>{$row['ic']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['sex']}</td>
                        <td>{$row['address']}</td>
                        <td>{$row['hobby']}</td>
                        <td>{$row['state']}</td>
                        <td>{$row['height']}</td>
                        <td>{$row['weight']}</td>
                        <td>
                            <a href='?edit={$row['id']}'>Edit</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No profiles found.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
