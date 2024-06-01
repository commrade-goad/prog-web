<?php
session_start();
$nama = array();
$pass = array();
$db = new SQLite3('db/database.db');

$results = $db->query('select name, password from users;');
while ($row = $results->fetchArray()) {
    array_push($nama, $row["name"]);
    array_push($pass, $row["password"]);
}

if (isset($_POST["submit"])) {
    if ($_POST["username"] == $nama[0] && $_POST["password"] == $pass[0]) {
        $_SESSION["start"] = true;
        echo "<script>window.location=\"dashboard.php\"</script>";
    } else{
        echo "<script>alert(\"Username atau password salah!\")</script>";
        echo "<script>window.location=\"index.php\"</script>";
    }
}
?>
