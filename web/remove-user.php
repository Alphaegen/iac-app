<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ip_server = $_SERVER['SERVER_ADDR'];
$ip_client = $_SERVER['REMOTE_ADDR'];

echo "Currently on server: {$ip_server}", PHP_EOL;
echo "", PHP_EOL;
echo "Your ip: {$ip_client}", PHP_EOL;
echo "", PHP_EOL;

if (!key_exists('user_id', $_POST)) {
    die("No user id was set");
}

$servername = "mysql_live";
$username = "your_database_user";
$password = "your_database_password";
$database = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Create Guest
$sql = "DELETE FROM users WHERE id = {$_POST['user_id']}";

try {
    $conn->query($sql);
    echo "User deleted successfully", PHP_EOL;
} catch (Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

header("Location: /index.php");
exit();