<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JobConnect | Contact Us</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Just Back Button override for color */
    .back-btn {
      background-color: #888;
      color: white;
      border: none;
      padding: 10px;
      margin-top: 10px;
      cursor: pointer;
    }

    .back-btn:hover {
      background-color: #666;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>Contact Us</h1>
    <p>We'd love to hear from you!</p>
  </div>

  <div class="container">
    <div class="box" style="width: 90%; max-width: 600px;">
      <form id="contactForm">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject">

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5" style="width: 100%; padding: 8px; margin-bottom: 10px;"></textarea>

        <input type="submit" value="Send Message" class="btn">
        <button type="button" onclick="goBack()" class="back-btn">Back</button>
      </form>
    </div>
  </div>

  <script>
    document.getElementById("contactForm").addEventListener("submit", function(event) {
      event.preventDefault();

      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const subject = document.getElementById("subject").value.trim();
      const message = document.getElementById("message").value.trim();

      if (!name || !email || !subject || !message) {
        alert("Please fill in all fields.");
        return;
      }

      alert("Message sent successfully!");
      window.location.href = "index.php";
    });

    function goBack() {
      window.location.href = "index.php";
    }
  </script>

</body>
</html>
