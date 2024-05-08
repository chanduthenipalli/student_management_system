<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 80px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 20px;
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
        #viewButton {
        width: 200px; /* Set the desired width */
        height: 60px; /* Set the desired height */
        font-size: 16px; /* Set the font size if needed */
        display: inline-block;
        /* Add any other styling as per your design */
        padding:10px;
    }
</style>
</head>

<body>
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

    // Initialize $regNo and $semester
    $regNo = "";
    $semester = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $regNo = isset($_POST["reg_no"]) ? $_POST["reg_no"] : "";
        $semester = isset($_POST["semester"]) ? $_POST["semester"] : "";
        $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];
        $date = date("Y-m-d H:i:s");
    
        // Insert data into the table using prepared statement
        $insertSql = "INSERT INTO courseregistration (regno, courses, semster, Date) VALUES (?, ?, ?, ?)";
    
        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param("ssss", $regNo, $courses, $semester, $date);
    
        // Iterate over selectedCourses and bind each course
        foreach ($selectedCourses as $course) {
            $courses = $course;
            $stmtInsert->execute();
        }
    
        $stmtInsert->close();
    }
    // Retrieve data from the table based on regno and semester
    if (!empty($regNo) && !empty($semester)) {
        $selectSql = "SELECT semster, courses, Date FROM courseregistration WHERE regno=? AND semster=?";
        $stmtSelect = $conn->prepare($selectSql);
        $stmtSelect->bind_param("ss", $regNo, $semester);
        $stmtSelect->execute();
        $result = $stmtSelect->get_result();
        $stmtSelect->close();
    }
    ?>
    <div class="container">
    <button type="button" id="viewButton" onclick="window.location.href='Courseview.html';">VIEW COURSES</button>
<script>
    document.getElementById('viewButton').addEventListener('click', function() {
        window.location.href = 'Courseview.html';
    });
</script>
<a href="studentdashboard.html">
    <button type="button" id="viewButton">BACK</button>
</a>
        <h2 style="text-align: center;">Student Course Registration</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    

    <label for="reg_no">Registration Number:</label>
    <input type="text" name="reg_no" required>

    <label for="semester">Semester:</label>
    <select name="semester" required>
        <option value="fall">Fall</option>
        <option value="winter">Win</option>
    </select>

    <label for="course1">Course 1:</label>
    <input type="text" name="courses[]" required>

    <label for="course2">Course 2:</label>
    <input type="text" name="courses[]">

    <label for="course3">Course 3:</label>
    <input type="text" name="courses[]">

    <label for="course4">Course 4:</label>
    <input type="text" name="courses[]">

    <label for="course5">Course 5:</label>
    <input type="text" name="courses[]">

    <label for="course6">Course 6:</label>
    <input type="text" name="courses[]">

    <button type="submit">REGISTER</button>
</form>
        <h2>Registered Courses</h2>
        <table>
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Registered Courses</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['semster']}</td>
                                <td>{$row['courses']}</td>
                                <td>{$row['Date']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No registered courses yet.</td></tr>";
                }
                ?>
            </tbody>
            
        </table>
    </div>
  
</body>

</html>
