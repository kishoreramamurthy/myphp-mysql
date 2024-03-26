<!DOCTYPE html>
<html>
<head>
    <title>User Data Form</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: #4CAF50;
            margin-top: 20px;
        }

        .error {
            text-align: center;
            color: red;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Data Form</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // Database connection
        $servername = "phpnewdb.cro4tmy0fvoq.ap-southeast-1.rds.amazonaws.com";
        $username = "admin";
        $password = "admin123";
        $database = "masterdata";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['userdata'];
            $email = $_POST['email'];

            $sql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "<p>New record created successfully</p>";
            } else {
                echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }

        // Retrieve data from the database
        $result = $conn->query("SELECT * FROM users");

        if ($result->num_rows > 0) {
            echo "<h2>User Data</h2>";
            echo "<table>";
            echo "<tr><th>Username</th><th>Email</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row['username'] . "</td><td>" . $row['email'] . "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No user data available</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
