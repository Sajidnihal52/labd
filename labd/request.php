<?php
session_start();
$bgColor = $_SESSION['color'] ?? '#f4f4f4'; // fallback color
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
    <title>Request</title>
    <style>
        /* Full page background with user color */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: <?= htmlspecialchars($bgColor) ?>;
            display: flex;
            justify-content: center; /* center horizontally */
            align-items: center;    /* center vertically */
            height: 100vh;           /* full viewport height */
            padding: 20px;           /* spacing on all sides */
            box-sizing: border-box;
        }
        /* Container with white background and padding */
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 900px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto; /* scroll if content too tall */
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
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
        <h2>Please select your city</h2>
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
