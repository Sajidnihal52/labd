<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'jobseeker') {
    header("Location: login.html");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "JobSeekerUser";

$host = "localhost";
$dbname = "jobseeker";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search term from GET, sanitize it
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare SQL with or without search
if ($search !== '') {
    $search_param = "%".$search."%";
    $stmt = $conn->prepare("SELECT id, title, company_name, location FROM jobs WHERE status = 'accepted' AND (title LIKE ? OR company_name LIKE ? OR location LIKE ?) ORDER BY created_at DESC");
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT id, title, company_name, location FROM jobs WHERE status = 'accepted' ORDER BY created_at DESC";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Job Seeker Dashboard</title>
<style>
  body, html {
    height: 100%;
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
  }
  .header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 30px;
    background-color: #4361ee;
    color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    font-size: 16px;
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
    transition: background-color 0.3s ease;
  }
  .logout-btn:hover {
    background-color: #0d8f60;
  }
  .container {
    min-height: calc(100vh - 60px);
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    text-align: center;
    padding: 30px 20px;
    max-width: 900px;
    margin: 0 auto;
  }
  h2 {
    color: #333;
    margin-bottom: 10px;
  }
  p {
    color: #555;
    margin-bottom: 30px;
    font-size: 16px;
  }
  form input[type="text"] {
    width: 320px;
    padding: 10px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 15px;
    transition: border-color 0.3s ease;
  }
  form input[type="text"]:focus {
    border-color: #4361ee;
    outline: none;
  }
  form button {
    background-color: #12af75;
    border: none;
    padding: 10px 25px;
    color: white;
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  form button:hover {
    background-color: #0d8f60;
  }
  table {
    border-collapse: collapse;
    margin-top: 20px;
    width: 100%;
    max-width: 900px;
    background: white;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
  }
  th, td {
    border: 1px solid #96D4D4;
    padding: 14px 20px;
    text-align: center;
    font-size: 15px;
    color: #333;
  }
  th {
    background-color: #4361ee;
    color: white;
  }
  tr:nth-child(even) {
    background-color: #f3f9f9;
  }
  tr:hover {
    background-color: #d4eaff;
  }
  td form button {
    padding: 8px 18px;
    font-size: 14px;
  }
</style>
</head>
<body>

  <div class="header-bar">
   <img src="jobseeker.avif" alt="Admin Avatar" class="avatar" />

    <div class="user-info">
      <div class="user-name"><?= htmlspecialchars($username) ?></div>
      <a href="process_logout.php" class="logout-btn">Logout</a>

    </div>
  </div>

  <div class="container">
    <h2>Job Seeker Dashboard</h2>
    <p>Welcome, Job Seeker! You can search and apply for jobs below.</p>

    <form method="get" action="">
      <input type="text" name="search" placeholder="Search jobs by title, company, location..." value="<?= htmlspecialchars($search) ?>" />
      <button type="submit">Search</button>
    </form>

    <h3>Available Jobs</h3>
    <table>
      <tr><th>Job Title</th><th>Company</th><th>Location</th><th>Apply</th></tr>
      <?php if ($result && $result->num_rows > 0): ?>
          <?php while($job = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($job['title']) ?></td>
            <td><?= htmlspecialchars($job['company_name']) ?></td>
            <td><?= htmlspecialchars($job['location']) ?></td>
            <td>
              <form method="post" action="apply_job.php">
                <input type="hidden" name="job_id" value="<?= $job['id'] ?>" />
                <button type="submit">Apply</button>
              </form>
            </td>
          </tr>
          <?php endwhile; ?>
      <?php else: ?>
          <tr><td colspan="4">No jobs found matching your search.</td></tr>
      <?php endif; ?>
    </table>
  </div>

</body>
</html>
<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
