<?php
// Database connection
$host = "localhost";
$dbname = "jobseeker";
$username = "root"; // change if your DB user is different
$password = "";     // change if your DB has a password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get form data
$jobTitle = $_POST['job_title'] ?? '';
$companyName = $_POST['company_name'] ?? '';
$location = $_POST['location'] ?? '';
$description = $_POST['job_description'] ?? '';
$employerId = 56; // static as per your requirement
$status = 'pending';
$createdAt = date("Y-m-d H:i:s");

// Insert into database
$sql = "INSERT INTO jobs (employer_id, title, company_name, location, description, status, created_at) 
        VALUES (:employer_id, :title, :company_name, :location, :description, :status, :created_at)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':employer_id', $employerId);
$stmt->bindParam(':title', $jobTitle);
$stmt->bindParam(':company_name', $companyName);
$stmt->bindParam(':location', $location);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':created_at', $createdAt);

if ($stmt->execute()) {
    echo "<p style='text-align: center; font-family: Arial; font-size: 20px; margin-top: 50px;'>Job posted successfully! Redirecting...</p>";
    header("refresh:2;url=dashboard_employer.php");
} else {
    echo "<p style='text-align: center; font-family: Arial; font-size: 20px; margin-top: 50px;'>Failed to post job.</p>";
}
?>
