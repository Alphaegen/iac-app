<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ip_server = $_SERVER['SERVER_ADDR'];

$servername = "mysql";
$username = "your_database_user";
$password = "your_database_password";
$database = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

try {
    $conn->query($sql);
} catch (Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$sql = "SELECT * FROM users";

$rows = [];

try {
    $results = $conn->query($sql);
} catch (Exception $e) {
    echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

?>
<html>

<head>
    <title>PHP-Test</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <p>
        Current server(container) IP: <?= $ip_server ?>
        <sub>
            Your session is kept between refreshes. Open this page in another tab in incognito to see this IP changing.
        </sub>
    </p>

    <h1>Users:</h1>
    <table>
        <tr>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th></th>
        </tr>
        <?php while ($row = $results->fetch_assoc()) { ?>
            <tr>
                <td><?= $row["firstname"] ?></td>
                <td><?= $row["lastname"] ?></td>
                <td><?= $row["email"] ?></td>
                <td>
                    <form method="post" action="remove-user.php">
                        <input name="user_id" type="hidden" value="<?= $row["id"] ?>">
                        <input type="submit" value="Delete" />
                    </form>
                </td>
            </tr>
        <?php } ?>
        <form method="post" action="add-user.php">
            <tr>
                <td><input name="firstname" type="text" required /></td>
                <td><input name="lastname" type="text" required /></td>
                <td><input name="email" type="email" required /></td>
                <td><input type="submit" value="Create" /></td>
            </tr>
        </form>
    </table>
</body>

</html>