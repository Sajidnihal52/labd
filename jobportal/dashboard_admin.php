<?php
session_start();

// Dummy session username for demo (replace with real session logic)
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'AdminUser';
}
$username = $_SESSION['username'];

// DB Connection
$host = "localhost";
$dbname = "jobseeker";
$dbuser = "root";
$dbpass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Handle Accept/Reject
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'], $_POST['action'])) {
    $jobId = $_POST['job_id'];
    $action = $_POST['action'];
    if (in_array($action, ['accepted', 'rejected'])) {
        $update = $conn->prepare("UPDATE jobs SET status = :status WHERE id = :id");
        $update->bindParam(':status', $action);
        $update->bindParam(':id', $jobId);
        if ($update->execute()) {
            $message = "Job ID $jobId has been $action successfully.";
        } else {
            $message = "Failed to update Job ID $jobId.";
        }
    }
}

// Fetch Pending Jobs
$stmt = $conn->query("SELECT * FROM jobs WHERE status = 'pending' ORDER BY created_at DESC");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f1f3f8;
    }
    .header {
      background-color: #4361ee;
      color: white;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
.avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

    .user-info {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .logout-btn {
      background-color: #12af75;
      border: none;
      padding: 6px 12px;
      color: white;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
    }
    .logout-btn:hover {
      background-color: #0d8f60;
    }
    .container {
      max-width: 1000px;
      margin: 20px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    .job {
      border-bottom: 1px solid #ddd;
      padding: 15px 0;
    }
    .job:last-child {
      border-bottom: none;
    }
    .job h3 {
      margin: 0;
    }
    .actions {
      margin-top: 10px;
    }
    .actions form {
      display: inline;
    }
    .actions button {
      padding: 6px 12px;
      margin-right: 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }
    .accept {
      background-color: #28a745;
      color: white;
    }
    .reject {
      background-color: #dc3545;
      color: white;
    }
    .message {
      background: #d4edda;
      color: #155724;
      padding: 10px;
      margin-bottom: 20px;
      border-left: 5px solid #28a745;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<div class="header">
  <img src="admin.avif" alt="Admin Avatar" class="avatar" />
  <div class="user-info">
    <span><strong><?= htmlspecialchars($username) ?></strong></span>
    <a href="process_logout.php" class="logout-btn">Logout</a>
  </div>
</div>


<div class="container">
  <h2>Pending Job Posts</h2>

  <?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <?php if (count($jobs) === 0): ?>
    <p>No pending jobs found.</p>
  <?php else: ?>
    <?php foreach ($jobs as $job): ?>
      <div class="job">
        <h3><?= htmlspecialchars($job['title']) ?></h3>
        <p><strong>Company:</strong> <?= htmlspecialchars($job['company_name']) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($job['location']) ?></p>
        <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($job['description'])) ?></p>
        <p><strong>Posted at:</strong> <?= htmlspecialchars($job['created_at']) ?></p>
        <div class="actions">
          <form method="post">
            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
            <input type="hidden" name="action" value="accepted">
            <button type="submit" class="accept">Accept</button>
          </form>
          <form method="post">
            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
            <input type="hidden" name="action" value="rejected">
            <button type="submit" class="reject">Reject</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

</body>
</html>
