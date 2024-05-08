<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        h2 {
            color: #3498db;
        }

        .btn-u {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
        }

        .btn-u.pull-right {
            float: right;
        }
        .btn-u:hover {
            background-color: hsl(123, 40%, 45%);
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
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch attendance records
    $date = $_REQUEST['date'];
    $course = $_REQUEST['course'];
    $sql = "SELECT Course, Regno, date, status FROM attendance WHERE date='$date' AND Course='$course'";
    $result = mysqli_query($conn, $sql);

    // Display attendance records in HTML table
    echo '<h2 style="text-align: center;">Your Attendance Status View</h2>';
    echo "<table>";
    echo "<tr><th> Course </th><th> Registration </th><th> Date </th><th> Status </th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Course'] . "</td>";
        echo "<td>" . $row['Regno'] . "</td>";
        echo "<td>" . $row['date'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";


    // Close database connection
    mysqli_close($conn);
    ?>

    <form action="FacultyDashboar.html">
        <button type="submit" class="btn-u pull-right">BACK</button>
    </form>

</body>

</html>
