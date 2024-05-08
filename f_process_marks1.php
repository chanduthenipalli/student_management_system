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
    $regno = $_POST['regno'];
    $marks = $_POST['marks'];

    // Insert data into the assignment_marks table
    $insertSql = "INSERT INTO assignment_marks (regno, course, title, marks) VALUES (?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($insertSql);
    $stmtInsert->bind_param("ssss", $regno, $course, $assignmentTitle, $marks);

    if ($stmtInsert->execute()) {
        echo '<script>alert("Marks submitted successfully!");</script>';
    } else {
        echo "Error submitting marks: " . $stmtInsert->error;
    }

    $stmtInsert->close();
    // Close the database connection
    $conn->close();
}
?>
