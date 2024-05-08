
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
        h3 {
            text-align: center;
            font-family: Times New Roman;
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

        .btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: hsl(123, 40%, 45%);
        }

        .btn.pull-right {
            float: right;
        }
        
        .btn-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = $_POST['regno'];
    $course = $_POST['course'];

    // Retrieve data from the assignment_marks table
    $selectSql = "SELECT * FROM assignment_marks WHERE regno = ? AND course = ?";
    $stmtSelect = $conn->prepare($selectSql);
    $stmtSelect->bind_param("ss", $regno, $course);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    // Display assignment marks
    if ($result->num_rows > 0) {
        echo "<h3>Assignment Marks for Registration Number: $regno, Course: $course</h3>";
        echo "<table class='table'>";
        echo "<thead><tr><th>Assignment Title</th><th>Marks</th></tr></thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $assignmentTitle = $row['title'];
            $marks = $row['marks'];
            echo "<tr><td>$assignmentTitle</td><td>$marks</td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "No assignment marks found for the provided registration number and course.";
    }

    $stmtSelect->close();
    // Close the database connection
    $conn->close();
}
?>
 <div class="btn-container">
                    <a href="studentdashboard.html" class="btn pull-right">Back</a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>


