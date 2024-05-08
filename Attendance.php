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
    $regno = $_REQUEST['regno'];
    $sql = "SELECT Course, Regno, date, status FROM attendance WHERE Regno='$regno'";
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

    // Fetch unique courses for the given registration number
    $sqlCourses = "SELECT DISTINCT Course FROM attendance WHERE Regno='$regno'";
    $resultCourses = mysqli_query($conn, $sqlCourses);

    // Display course-wise attendance percentage
    echo '<h2 style="text-align: center;">Course-wise Attendance Percentage</h2>';
    echo "<table>";
    echo "<tr><th> Course </th><th> Attendance Percentage </th></tr>";

    while ($rowCourse = mysqli_fetch_assoc($resultCourses)) {
        $course = $rowCourse['Course'];

        // Fetch attendance records for each course
        $sqlAttendance = "SELECT COUNT(*) as total, SUM(CASE WHEN status='Present' THEN 1 ELSE 0 END) as present FROM attendance WHERE Regno='$regno' AND Course='$course'";
        $resultAttendance = mysqli_query($conn, $sqlAttendance);
        $rowAttendance = mysqli_fetch_assoc($resultAttendance);

        $totalClasses = $rowAttendance['total'];
        $presentClasses = $rowAttendance['present'];

        // Calculate attendance percentage
        $attendancePercentage = ($presentClasses / $totalClasses) * 100;

        // Display course-wise attendance percentage
        echo "<tr>";
        echo "<td>$course</td>";
        echo "<td>$attendancePercentage%</td>";
        echo "</tr>";
    }

    echo "</table>";

    // Close database connection
    mysqli_close($conn);
    ?>

    <form action="studentdashboard.html">
        <button type="submit" class="btn-u pull-right">BACK</button>
    </form>

</body>

</html>
