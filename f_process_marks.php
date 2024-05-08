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
    $course = $_POST['course'];
    $assignmentTitle = $_POST['assignmentTitle'];

    // Retrieve data from the assignments table
    $selectSql = "SELECT * FROM assignments WHERE course = ? AND assignment_title = ?";
    $stmtSelect = $conn->prepare($selectSql);
    $stmtSelect->bind_param("ss", $course, $assignmentTitle);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    // Display assignment files in a table
    echo "<html><head><style>
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
    </style></head><body>";

    if ($result->num_rows > 0) {
        echo "<h3>Assignment Details</h3>";
        echo "<table>";
        echo "<thead><tr><th>Reg No</th><th>Course</th><th>Assignment Title</th><th>File Status</th></tr></thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            $regNo = $row['regno'];
            $course = $row['course'];
            $assignmentTitle = $row['assignment_title'];
            $filePath = $row['file'];

            echo "<tr><td>$regNo</td><td>$course</td><td>$assignmentTitle</td>";

            // Check if a file is submitted
            if (!empty($filePath)) {
                echo "<td>Submitted - <a href='$filePath' target='_blank'>View File</a></td></tr>";
            } else {
                echo "<td>Not Submitted</td></tr>";
            }
        }

        echo "</tbody></table>";
    } else {
        echo "No assignments found for the provided course and assignment title.";
    }
    echo "</body></html>";

    $stmtSelect->close();
    // Close the database connection
    $conn->close();
}
?>

<html>
<head>
    <!-- Include Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Include Bootstrap CSS if not already included -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 90px;
            height: 80px;
        }

        form {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            height: 260px;
            border-radius: 80px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
            height: 50px;
        }

        .form-control {
            width: calc(100% - 32px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 80px;
        }

        .row {
            margin-top: 20px;
        }

        .col-md-6 {
            width: 100%;
            /* Change width to 100% to prevent overlapping */
            float: left;
            margin-bottom: 10px;
            /* Add margin-bottom to separate the buttons */
        }

        .btn-u {
            width: 100%;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            margin-left: -10px;
            border-radius: 80px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-u:hover {
            background-color: hsl(123, 40%, 45%);
        }

        h1 {
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }
    </style>
    <script>
        function openPdf(filePath) {
            window.open(filePath, '_blank');
        }
    </script>
</head>

<body>
    <div class="container">
        <form method="post" action="f_process_marks1.php">
            <input type="hidden" name="course" value="<?php echo $course; ?>">
            <input type="hidden" name="assignmentTitle" value="<?php echo $assignmentTitle; ?>">

            <div class="form-group">
                <label for="regno" >Reg No</label>
                <input type="text" class="form-control" id="regno" name="regno" required>
            </div>
            <div class="form-group">
                <label for="marks">Marks</label>
                <input type="text" class="form-control" id="marks" name="marks" required>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <button type="submit" class="btn-u">SUBMIT</button>
                </div>
                <div class="col-md-6">
                    <a href="FacultyDashboar.html" class="btn-u">BACK</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
