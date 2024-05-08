<?php
// Database connection parameters
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

// Check if registration number is posted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['regno'])) {
    $regno = $_POST['regno'];

    // Retrieve courses from the database for the given registration number
    $selectSql = "SELECT courses FROM courseregistration WHERE regno=?";
    $stmtSelect = $conn->prepare($selectSql);
    $stmtSelect->bind_param("s", $regno);
    $stmtSelect->execute();
    $result = $stmtSelect->get_result();

    // Store courses in an array
    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses = array_merge($courses, explode(", ", $row['courses']));
    }

    // Retrieve marks from the database for the given registration number
    $stmtMarksCat1 = $conn->prepare("SELECT cat1 FROM marks_cat1 WHERE regno=?");
    $stmtMarksCat1->bind_param("s", $regno);
    $stmtMarksCat1->execute();
    $resultCat1 = $stmtMarksCat1->get_result();

    $stmtMarksCat2 = $conn->prepare("SELECT cat2 FROM marks_cat2 WHERE regno=?");
    $stmtMarksCat2->bind_param("s", $regno);
    $stmtMarksCat2->execute();
    $resultCat2 = $stmtMarksCat2->get_result();

    $stmtMarksFat = $conn->prepare("SELECT fat FROM marks_fat WHERE regno=?");
    $stmtMarksFat->bind_param("s", $regno);
    $stmtMarksFat->execute();
    $resultFat = $stmtMarksFat->get_result();

    // Store all marks in arrays
    $cat1_marks = [];
    while ($row = $resultCat1->fetch_assoc()) {
        $cat1_marks[] = $row['cat1'];
    }

    $cat2_marks = [];
    while ($row = $resultCat2->fetch_assoc()) {
        $cat2_marks[] = $row['cat2'];
    }

    $fat_marks = [];
    while ($row = $resultFat->fetch_assoc()) {
        $fat_marks[] = $row['fat'];
    }

    // Determine the maximum count of marks
    $max_count = max(count($cat1_marks), count($cat2_marks), count($fat_marks), count($courses));

    // Display marks in a table
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<style>";
    echo "/* Centering the table */";
    echo "table {";
    echo "margin: 20px auto;";
    echo "}";
    echo "body {";
    echo "font-family: Arial, sans-serif;";
    echo "background-color: #f4f4f4;";
    echo "margin: 0;";
    echo "padding: 0;";
    echo "}";
    echo "table {";
    echo "border-collapse: collapse;";
    echo "width: 80%;";
    echo "}";
    echo "th, td {";
    echo "border: 1px solid #ddd;";
    echo "padding: 12px; /* Adjusted padding for better spacing */";
    echo "text-align: left;";
    echo "}";
    echo "th {";
    echo "background-color: #3498db;";
    echo "color: #fff;";
    echo "}";
    echo "h2 {";
    echo "color: #3498db;";
    echo "text-align: center; /* Centering h2 */";
    echo "}";
    echo "p {";
    echo "text-align: center; /* Centering p */";
    echo "}";
    echo ".btn-u {";
    echo "background-color: #3498db;";
    echo "color: #fff;";
    echo "padding: 10px 20px;";
    echo "border: none;";
    echo "cursor: pointer;";
    echo "border-radius: 4px;";
    echo "margin-top: 20px;";
    echo "display: inline-block; /* Ensuring button behaves like a block element */";
    echo "}";
    echo ".btn-u:hover {";
    echo "background-color: hsl(123, 40%, 45%);";
    echo "}";
    echo ".pull-right {";
    echo "float: right;";
    echo "}";
    echo "</style>";
    echo "</head>";
    echo "<body>";
    echo "<h2>View Marks</h2>";
    echo "<p>Registration Number: $regno</p>";
    echo "<table>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Courses</th>";
    echo "<th>Cat 1</th>";
    echo "<th>Cat 2</th>";
    echo "<th>FAT</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    for ($i = 0; $i < $max_count; $i++) {
        echo "<tr>";
        // Display Courses
        echo "<td>" . ($i < count($courses) ? $courses[$i] : '') . "</td>";
        // Display Cat 1 marks
        echo "<td>" . ($i < count($cat1_marks) ? $cat1_marks[$i] : '') . "</td>";
        // Display Cat 2 marks
        echo "<td>" . ($i < count($cat2_marks) ? $cat2_marks[$i] : '') . "</td>";
        // Display FAT marks
        echo "<td>" . ($i < count($fat_marks) ? $fat_marks[$i] : '') . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // Back button
    echo "<a href='javascript:history.go(-1)' class='btn-u pull-right'>Back</a>";

    echo "</body>";
    echo "</html>";
}
?>
