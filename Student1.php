<!DOCTYPE html>
<html>

<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        form {
            margin-top: 20px;
        }

        .row {
            margin-bottom: 10px;
        }

        .col-md-6 {
            width: 50%;
            float: left;
        }

        .btn-u {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-u.pull-right {
            float: right;
        }
    </style>
</head>
<body>

    <?php
    $servername = "localhost";
    $username = "Chandu";
    $password = "Chandu@7079";
    $dbname = "studentmanagement";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $Course = $_REQUEST['course'];
    $Regno = $_REQUEST['regno'];
    $Date = date("Y-m-d H:i:s");

    // Define the SQL query before validating the secret code
    $sql = "INSERT INTO attendance VALUES ('$Course', '$Regno', '$Date', ";

    session_start();

    // Validate the secret code
    $user_entered_secret_code = isset($_REQUEST['secretCode']) ? $_REQUEST['secretCode'] : "";
    $correct_secret_code = isset($_SESSION['secret_code']) ? $_SESSION['secret_code'] : "";

    if (isset($_SESSION['secret_code'])) {
        $current_time = time();
        $expiry_time = $_SESSION['expiry_time'];

        if ($current_time > $expiry_time) {
            unset($_SESSION['secret_code']);
            unset($_SESSION['expiry_time']);
            echo "<h1>Attendance code has expired. Please try again.</h1>";
        } else {
            if ($user_entered_secret_code != $correct_secret_code) {
                echo "<h1>Invalid attendance code. You're marked as Absent.</h1>";
                $sql .= "'Absent')";
            } else {
                echo "<h1>You're marked as Present.</h1>";
                $sql .= "'Present')";
            }

            // Execute the SQL query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result === TRUE) {
                echo "";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    // Close database connection
    $conn->close();
    ?>
    <form action="student.html">
        <div class="row">
            <div class="col-md-6">
                <button class="btn-u pull-right">BACK</button>
            </div>
        </div>
    </form>
</body>

</html>
