<?php
$servername = "localhost";
$username = "Chandu";
$password = "Chandu@7079";
$dbname = "studentmanagement";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the table
$regno = $_REQUEST['regno'];
$selectSql = "SELECT semster, courses, Date FROM courseregistration WHERE Regno='$regno'";
$stmtSelect = $conn->prepare($selectSql);
$stmtSelect->execute();
$result = $stmtSelect->get_result();
$stmtSelect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... your head content ... -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Courses</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            height:400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 80px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        button {
            background-color: #3498db;
            color: #fff;
            padding: 25px;
            border: none;
            width:200px;
            cursor: pointer;
            align-items: center;
            font-size: 16px; /* Set the font size if needed */
            border-radius: 80px;
        }

        button:hover {
            background-color: #45a049;
        }
        #viewButton {
        width: 200px; /* Set the desired width */
        height: 60px; /* Set the desired height */
        font-size: 16px; /* Set the font size if needed */
        display: inline-block;
        float:right;
        /* Add any other styling as per your design */
        padding:10px;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Registered Courses</h2>
        <table>
            <!-- ... your table headers ... -->
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Registered Courses</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['semster']}</td>
                                <td>{$row['courses']}</td>
                                <td>{$row['Date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No registered courses yet. Please register for courses.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="studentdashboard.html">
            <button type="button" id="viewButton">BACK</button>
        </a>
    </div>
</body>
</html>
