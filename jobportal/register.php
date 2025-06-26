<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>JobConnect | Register</title>
  <link rel="stylesheet" href="styles.css" />
  <style>
    body, html {
      height: 100%;
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f5f7fb;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .box {
      background-color: white;
      padding: 30px;
      border: 2px solid #ccc;
      width: 350px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 8px;
      text-align: center;
    }
    .logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin: 0 auto 20px auto;
      display: block;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-top: 6px;
      margin-bottom: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }
    label {
      font-weight: 600;
      display: block;
      text-align: left;
      margin-top: 10px;
    }
    input[type="checkbox"] {
      margin-right: 8px;
      transform: scale(1.1);
      vertical-align: middle;
    }
    .btn {
      width: 100%;
      background-color: #12af75;
      color: white;
      border: none;
      padding: 12px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      margin-top: 15px;
    }
    .btn:hover {
      background-color: #0d8f60;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-bottom: 10px;
      text-align: left;
    }
    .back-btn {
      width: 100%;
      background-color: #888;
      color: white;
      border: none;
      padding: 10px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 6px;
      margin-top: 10px;
    }
    .back-btn:hover {
      background-color: #666;
    }
  </style>
  <script>
    function clearErrors() {
      document.querySelectorAll(".error").forEach(el => el.textContent = "");
    }

    function calculateAge(dob) {
      const birthDate = new Date(dob);
      const today = new Date();
      let age = today.getFullYear() - birthDate.getFullYear();
      const m = today.getMonth() - birthDate.getMonth();
      if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    }

    function validateForm() {
      clearErrors();
      let isValid = true;

      const name = document.getElementById("fullname").value.trim();
      const email = document.getElementById("email").value.trim();
      const password = document.getElementById("password").value.trim();
      const dob = document.getElementById("dob").value;
      const country = document.getElementById("country").value;
      const gender = document.getElementById("gender").value;
      const terms = document.querySelector('input[name="terms"]').checked;

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const passwordRegex = /^(?=.*[a-zA-Z])(?=.*[0-9]).{8,}$/;

      if (name === "") {
        document.getElementById("nameError").textContent = "Full Name is required.";
        isValid = false;
      }

      if (!emailRegex.test(email)) {
        document.getElementById("emailError").textContent = "Enter a valid email address.";
        isValid = false;
      }

      if (!passwordRegex.test(password)) {
        document.getElementById("passwordError").textContent = "Password must be at least 8 characters and alphanumeric.";
        isValid = false;
      }

      if (!dob) {
        document.getElementById("dobError").textContent = "Please select your Date of Birth.";
        isValid = false;
      } else {
        const age = calculateAge(dob);
        if (age < 18) {
          alert("You must be at least 18 years old to register.");
          isValid = false;
        }
      }

      if (country === "") {
        document.getElementById("countryError").textContent = "Please select your country.";
        isValid = false;
      }

      if (gender === "") {
        document.getElementById("genderError").textContent = "Please select your gender.";
        isValid = false;
      }

      if (!terms) {
        document.getElementById("termsError").textContent = "You must agree to the terms and conditions.";
        isValid = false;
      }

      return isValid;
    }

    function goBack() {
      window.location.href = "index.php";
    }
  </script>
</head>
<body>
  <div class="box">
    <!-- Logo image added here -->
    <img src="logo.avif" alt="JobConnect Logo" class="logo" />

    <h3 style="margin-bottom: 24px;">Job Seeker Registration</h3>
    <form action="process_register.php" method="post" onsubmit="return validateForm()">
      <label for="fullname">Full Name:</label>
      <input id="fullname" name="username" type="text" />
      <div id="nameError" class="error"></div>

      <label for="email">Email:</label>
      <input id="email" name="email" type="email" />
      <div id="emailError" class="error"></div>

      <label for="password">Password:</label>
      <input id="password" name="password" type="password" />
      <div id="passwordError" class="error"></div>

      <label for="dob">Date of Birth:</label>
      <input id="dob" name="dob" type="date" />
      <div id="dobError" class="error"></div>

      <label for="country">Country:</label>
      <select id="country" name="country">
        <option value="">-- Select Country --</option>
        <option>Bangladesh</option>
        <option>India</option>
        <option>Pakistan</option>
      </select>
      <div id="countryError" class="error"></div>

      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="">-- Select Gender --</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        <option value="other">Other</option>
      </select>
      <div id="genderError" class="error"></div>

      <label>
        <input type="checkbox" name="terms" />
        I agree to the <a href="terms.html" target="_blank">Terms and Conditions</a>
      </label>
      <div id="termsError" class="error"></div>

      <input type="hidden" name="user_type" value="jobseeker" />
      <input type="submit" value="Register" class="btn" />
      <button type="button" class="back-btn" onclick="goBack()">Back</button>
    </form>
  </div>
</body>
</html>
