<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JobConnect | Home</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
      background: linear-gradient(to bottom right, #e0f7fa, #ffffff);
    }

    .header {
      width: 100%;
      background-color: #4361ee;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .nav-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto 10px;
    }

    .nav-top a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-weight: bold;
    }

    .hero {
      height: calc(100vh - 200px);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
    }

    .hero h2 {
      font-size: 32px;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 18px;
      margin-bottom: 40px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

.box {
  background-color: #ffffff;
  padding: 30px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
  text-align: center;
  width: 200px;
}


    .box:hover {
      transform: scale(1.05);
    }

.btn {
  display: inline-block;
  background-color: #12af75;
  color: white;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 6px;
  font-size: 16px;
  font-weight: bold;
  transition: background-color 0.3s ease;
  max-width: 100%;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  box-sizing: border-box;
}

.btn:hover {
  background-color: #0d8f60;
}

  </style>
</head>
<body>

  <div class="header">
    <div class="nav-top">
      <div style="font-weight: bold; font-size: 20px;">Job Portal</div>
      <div>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
      </div>
    </div>
    <h1>JobConnect</h1>
    <p>Find Your Dream Job Today</p>
  </div>

  <div class="hero">
    <h2>Welcome to the Job Portal</h2>
    <p>Connecting talented job seekers with top employers</p>

    <div class="container">
      <div class="box">
        <div class="btn">
          <h3><a href="register.php">Register</a></h3>
        </div>
      </div>
      <div class="box">
        <div class="btn">
          <h3><a href="login.html">Login</a></h3>
        </div>
      </div>
      <div class="box">
        <div class="btn">
          <h3><a href="jobs.php">Job</a></h3>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
