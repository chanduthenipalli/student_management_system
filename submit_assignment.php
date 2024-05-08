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
    $assignmentTitle = $_POST['assignmentTitle'];

    // File handling
    $file = $_FILES['assignmentFile'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];

    // Move the uploaded file to a specific directory (adjust the path as needed)
    $uploadDirectory = "D:/Xamp/htdocs/Chandu/Student_Management_System/PDF/";
    $filePath = $uploadDirectory . $fileName;

    if (move_uploaded_file($fileTmpName, $filePath)) {
        // File moved successfully, now insert data into the database
        $insertSql = "INSERT INTO assignments (regno, course, assignment_title, file) VALUES (?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param("ssss", $regno, $course, $assignmentTitle, $filePath);

        if ($stmtInsert->execute()) {
            echo '<script>alert("Assignment submitted successfully!");</script>';
        } else {
            echo '<script>alert("Error submitting assignment: ' . $stmtInsert->error . '");</script>';
        }

        $stmtInsert->close();
    } else {
        echo '<script>alert("Error uploading file.");</script>';
    }

    // Close the database connection
    $conn->close();
}
?>
