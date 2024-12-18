<?php
$servername = "localhost";
$username = "root";  // Default user for MySQL on local servers
$password = "";      // Default password for 'root' on local servers (empty in XAMPP)
$mydb = "myproject";

try {
  $dbh = new PDO("mysql:host=$servername;dbname=$mydb", $username, $password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
