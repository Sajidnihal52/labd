<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'jobseeker') {
    header("Location: login.html");
    exit();
}

$jobseeker_id = $_SESSION['userId']; // Must be set during login
$username = $_SESSION['username'] ?? "JobSeekerUser";
$job_id = $_POST['job_id'] ?? null;

if (!$job_id) {
    echo "Invalid job selection.";
    exit();
}

$host = "localhost";
$dbname = "jobseeker";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$redirectAfter = false; // Flag for redirection

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['apply_now'])) {
    $cover_letter = trim($_POST['cover_letter']);
    $upload_dir = "uploads/";

    // File upload
    $file = $_FILES['cv_file'];
    $file_name = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = ['pdf', 'doc', 'docx'];

    if (!in_array($file_ext, $allowed)) {
        $error = "Only PDF, DOC, and DOCX files are allowed.";
    } else {
        $new_filename = uniqid("cv_") . "." . $file_ext;
        $destination = $upload_dir . $new_filename;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($file_tmp, $destination)) {
            // Save to database
            $stmt = $conn->prepare("INSERT INTO applications (job_id, jobseeker_id, cover_id, cover_letter, applied_at, status) VALUES (?, ?, ?, ?, NOW(), 'pending')");
            $stmt->bind_param("iiss", $job_id, $jobseeker_id, $new_filename, $cover_letter);

            if ($stmt->execute()) {
                $success = "Application submitted successfully!";
                $redirectAfter = true;
            } else {
                $error = "Failed to submit application.";
            }

            $stmt->close();
        } else {
            $error = "Failed to upload CV file.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply for Job</title>
    <?php if (isset($success) && $redirectAfter): ?>
        <meta http-equiv="refresh" content="2;url=dashboard_jobseeker.php">
    <?php endif; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background-color: #f5f5f5;
        }
        .form-box {
            max-width: 600px;
            background: white;
            padding: 25px;
            margin: auto;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h2 {
            margin-top: 0;
            text-align: center;
        }
        textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 12px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #12af75;
            color: white;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #0d8f60;
        }
        .message {
            margin-top: 15px;
            padding: 10px;
            background-color: #e0f7e9;
            color: #046f4f;
            border: 1px solid #b2e1cc;
            border-radius: 4px;
        }
        .error {
            background-color: #fdecea;
            color: #a94442;
            border: 1px solid #f5c6cb;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            background-color: #4361ee;
            color: white;
            padding: 10px 16px;
            border-radius: 4px;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #324ab2;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Apply for Job #<?= htmlspecialchars($job_id) ?></h2>

    <?php if (isset($success)): ?>
        <div class="message"><?= $success ?><br>Redirecting to dashboard...</div>
    <?php elseif (isset($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!isset($success)): ?>
    <form action="apply_job.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="job_id" value="<?= htmlspecialchars($job_id) ?>">
        
        <label for="cv_file">Upload Your CV:</label>
        <input type="file" name="cv_file" required>

        <label for="cover_letter">Cover Letter:</label>
        <textarea name="cover_letter" rows="6" placeholder="Write your cover letter..." required></textarea>

        <button type="submit" name="apply_now">Submit Application</button>
    </form>
    <?php endif; ?>

    <div style="text-align: center;">
        <a class="back-btn" href="dashboard_jobseeker.php">← Back to Dashboard</a>
    </div>
</div>
</body>
</html>
<?php
$conn->close();
?>
