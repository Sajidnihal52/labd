<?php
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
    <title>Select AQI Data</title>
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
    <h2>Select up to 10 AQI rows</h2>

    <form action="showaqi.php" method="post">
        <table border="1" cellpadding="8">
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
        <br>
        <input type="submit" value="Show Selected">
    </form>
</body>
</html>
