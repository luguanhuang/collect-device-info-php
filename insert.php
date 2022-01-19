<?php
$mysqli = new mysqli('localhost', 'root', 'root1', 'cloud');

$username = $_POST['username'];
$password = $_POST['password'];

mysqli_query($mysqli, "INSERT INTO users (username,password) VALUES ('$username','$password')");
?>
<form method="POST">
    <input type="text" name="username" />
    <input type="password" name="password" />
    <input type="submit" />
</form>