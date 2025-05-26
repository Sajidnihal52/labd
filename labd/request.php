<?php
session_start();
$bgColor = $_SESSION['color'] ?? '#f4f4f4';
$username = $_SESSION['username'] ?? 'Guest';

$conn = new mysqli("localhost", "root", "", "labd");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM aqi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/x-icon" href="www.png">
    <title>Request</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: <?= htmlspecialchars($bgColor) ?>;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            box-sizing: border-box;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 95vh;
            overflow-y: auto;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .avatar {
            height: 40px;
            width: 40px;
            border-radius: 50%;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: bold;
        }

        .user-info a {
            color: #1a79b8;
            text-decoration: none;
            font-size: 14px;
        }

        .user-info a:hover {
            text-decoration: underline;
        }

        h2 {
            margin: 0;
            flex: 1;
            text-align: center;
        }

        h3 {
            text-align: center;
            margin-top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #1a79b8;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        input[type="submit"]:hover {
            background-color: #155d8b;
        }
    </style>
    <script>
    function limitCheckboxes() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const checked = document.querySelectorAll('input[type="checkbox"]:checked').length;
                if (checked > 10) {
                    alert("You can select a maximum of 10 rows.");
                    cb.checked = false;
                }
            });
        });
    }
    window.onload = limitCheckboxes;
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="download.jpg" alt="Avatar" class="avatar">
            <h2>Please select cities or Countries (Max 10)</h2>
            <div class="user-info">
                <span><?= htmlspecialchars($username) ?></span>
                <a href="logoutprocess.php">Logout</a>
            </div>
        </div>

        <h3>Air Quality Index (AQI) Data</h3>
        <form action="showaqi.php" method="post">
            <table>
                <tr>
                    <th>Select</th>
                    <th>No</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>AQI</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td><input type='checkbox' name='selected[]' value='{$row['No']}'></td>
                                <td>{$row['No']}</td>
                                <td>{$row['City']}</td>
                                <td>{$row['Country']}</td>
                                <td>{$row['AQI']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No data found</td></tr>";
                }
                $conn->close();
                ?>
            </table>
            <input type="submit" value="Show Selected">
        </form>
    </div>
</body>
</html>
