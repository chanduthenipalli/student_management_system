<?php
// Set up database connection
$servername = "localhost";
$username = "Chandu";
$password = "Chandu@7079";
$dbname = "studentmanagement";

$conn = new mysqli($servername,$username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the submitted login form data
$regno = $_POST['regno'];
$password = $_POST['password'];
  $sql = "SELECT * FROM studentlogin WHERE regno = '$regno' AND password = '$password'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // User is a student
    header("Location: studentdashboard.html");
  } else {
    // Invalid login credentials
    echo '<script>alert("Invalid Login Credentials");</script>';
  }


// Close database connection
mysqli_close($conn);
?>
