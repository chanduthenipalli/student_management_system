<?php
// fetch_courses.php

$servername = "localhost";
$username = "Chandu";
$password = "Chandu@7079";
$dbname = "studentmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$regNo = $_GET['regNo'];

$sql = "SELECT  courses FROM courseregistration WHERE regno = '$regNo'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courses = array();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row['courses'];
    }
    echo json_encode($courses);
} else {
    echo json_encode(array('message' => 'No courses found for the given registration number'));
}

$conn->close();
?>
