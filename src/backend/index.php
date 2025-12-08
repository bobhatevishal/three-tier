<?php
// HARDCODED CONTAINER NAME: 'my-db'
// This must match the --name used when running the database container
$servername = "my-db"; 
$username = "root";
$password = "secret"; 
$dbname = "classic_db";

echo "<h1>Backend Container (PHP)</h1>";

// 1. Retry Logic (Wait for DB to start)
$maxRetries = 10;
$conn = null;

for ($i = 0; $i < $maxRetries; $i++) {
    $conn = @new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        echo "Attempt " . ($i+1) . ": Waiting for Database ($servername)...<br>";
        sleep(2);
    } else {
        echo "<h3 style='color:green'>Success: Connected to Database!</h3>";
        break;
    }
}

if ($conn->connect_error) {
    die("<h3 style='color:red'>Failure: Could not connect to DB. Ensure the DB container is named 'my-db' and is on the same network.</h3>");
}

// 2. Initialize Table
$conn->query("CREATE TABLE IF NOT EXISTS logs (id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(255), time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

// 3. Insert Data
$conn->query("INSERT INTO logs (message) VALUES ('Request processed by manual container')");

// 4. Read Data
$result = $conn->query("SELECT * FROM logs ORDER BY id DESC LIMIT 5");

echo "<h4>Recent Database Logs:</h4><ul>";
while($row = $result->fetch_assoc()) {
    echo "<li>ID {$row['id']}: {$row['message']} ({$row['time']})</li>";
}
echo "</ul>";

$conn->close();
?>
