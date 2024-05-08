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
    $examType = $_POST['cat'];

    // Check if 'marks' is set in the POST data
    if (isset($_POST['marks']) && is_array($_POST['marks'])) {
        $marks = $_POST['marks'];
    } else {
        die("Error: Marks data not found or not in the correct format.");
    }

    // Insert marks and regno based on exam type
    switch ($examType) {
        case 'cat1':
            $insertSql = "INSERT INTO marks_cat1 (cat1, regno) VALUES (?, ?)";
            break;
        case 'cat2':
            $insertSql = "INSERT INTO marks_cat2 (cat2, regno) VALUES (?, ?)";
            break;
        case 'fat':
            $insertSql = "INSERT INTO marks_fat (fat, regno) VALUES (?, ?)";
            break;
        default:
            // Handle other cases or show an error
            die("Invalid exam type");
    }

    // Prepare and execute the insert query for each course
    foreach ($marks as $course => $marksValue) {
        // Prepare and execute the insert query
        $stmtInsert = $conn->prepare($insertSql);
        if (!$stmtInsert) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmtInsert->bind_param("ss", $marksValue, $regno);
        $stmtInsert->execute();
        if ($stmtInsert->error) {
            die("Error executing statement: " . $stmtInsert->error);
        }
        $stmtInsert->close();
    }

    echo "Marks updated successfully!";

    // Close the database connection
    $conn->close();
}
?>
