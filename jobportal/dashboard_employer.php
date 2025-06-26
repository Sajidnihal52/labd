<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'employer') {
    header("Location: login.html");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "EmployerUser";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Employer Dashboard</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f8faff;
    }

    .header-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 30px;
      background-color: #4361ee;
      color: white;
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

    .user-name {
      font-weight: bold;
    }

    .logout-btn {
      background-color: #12af75;
      border: none;
      padding: 6px 12px;
      color: white;
      cursor: pointer;
      border-radius: 4px;
      font-size: 14px;
      text-decoration: none;
    }

    .logout-btn:hover {
      background-color: #0d8f60;
    }

    .container {
      min-height: calc(100vh - 60px);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 20px;
    }

    h2 {
      margin-bottom: 10px;
    }

    .form-grid {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      max-width: 700px;
      width: 100%;
    }

    .form-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      justify-content: center;
      width: 100%;
    }

    input[type="text"],
    textarea {
      width: 300px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    textarea {
      height: 80px;
      resize: vertical;
    }

    button {
      background-color: #12af75;
      border: none;
      padding: 10px 20px;
      color: white;
      cursor: pointer;
      border-radius: 4px;
      font-size: 16px;
    }

    button:hover {
      background-color: #0d8f60;
    }
  </style>
</head>
<body>

  <div class="header-bar">
    <img src="employer.avif" alt="Admin Avatar" class="avatar" />

    <div class="user-info">
      <div class="user-name"><?= htmlspecialchars($username) ?></div>
      <a href="process_logout.php" class="logout-btn">Logout</a>

    </div>
  </div>

  <div class="container">
    <h2>Employer Dashboard</h2>
    <p>Welcome, Employer! You can post new jobs here.</p>

    <form method="post" action="post_job.php" class="form-grid">
      <div class="form-row">
        <input type="text" name="job_title" placeholder="Job Title" required />
        <input type="text" name="company_name" placeholder="Company Name" required />
      </div>
      <div class="form-row">
        <input type="text" name="location" placeholder="Location" required />
        <textarea name="job_description" placeholder="Job Description" required></textarea>
      </div>
      <button type="submit">Post Job</button>
    </form>
  </div>

</body>
</html>
