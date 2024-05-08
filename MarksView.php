<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        form {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 80px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        #catSelect {
            background-color: white;
            color: #000000;
            padding: 10px;
            border: none;
            border-radius: 80PX;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group-addon {
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 80PX;
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
    padding: 8px;
    border: 1px solid black;
    text-align: left;
}

    </style>
    <h1>Enter Marks<i class="fas fa-arrow-down"></i></h1>
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

// Initialize an array to store courses
$coursesArray = array();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regno = $_POST['regno'];
    $examType = $_POST['cat'];
    
    // Select courses from the database
    $selectSql = "SELECT courses FROM courseregistration WHERE regno='$regno'";
    $stmtSelect = $conn->prepare($selectSql);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    // Store courses in the array
    while ($row = $result->fetch_assoc()) {
        $coursesArray[] = $row['courses'];
    }
    
    $stmtSelect->close();
    }
    ?>

<form method="post" action="<?php echo isset($result) ? 'Marks1.php?courses=' . urlencode(json_encode($coursesArray)) : 'Marks.php'; ?>">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input type="text" name="regno" placeholder="Registration Number" class="form-control" required="">
    </div>

    <div class="input-group">
        <label for="catSelect">Select Exam:</label>
        <select id="catSelect" name="cat" class="form-control">
            <option value="cat1">Cat 1</option>
            <option value="cat2">Cat 2</option>
            <option value="fat">Final Assessment Test (FAT)</option>
        </select>
    </div>

    <?php
    if (isset($result) && $result->num_rows > 0) {
        echo '<div class="row">
            <div class="col-md-12">
                <table>
                    <thead>
                        <tr>
                            <th>Courses</th>
                            <th>' . $examType . '</th>
                        </tr>
                    </thead>
                    <tbody>';
        // Output the courses from the array
        foreach ($coursesArray as $course) {
            echo "<tr>
                    <td>{$course}</td>
                    <td><input type='number' name='marks[]' required></td>
                </tr>";
        }
        echo '</tbody>
            </table>
        </div>
    </div>';
    }
    ?>

    <div class="row">
        <div class="col-md-6">
            <button type="submit" class="btn-u">SUBMIT</button>
        </div>
        <div class="col-md-6">
            <a href="FacultyDashboar.html" class="btn-u">BACK</a>
        </div>
    </div>
</form>