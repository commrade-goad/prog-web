<?php
session_start();
$nama = array();
$pass = array();
$db = new SQLite3('db/database.db');


if (isset($_POST["login"])) {
    $results = $db->query('select name, password from users;');
    while ($row = $results->fetchArray()) {
        array_push($nama, $row["name"]);
        echo $row["name"];
        array_push($pass, $row["password"]);
    }
    for ($i=0; $i < count($nama); $i++) { 
        if ($_POST["username"] == $nama[$i] && $_POST["password"] == $pass[$i]) {
            $_SESSION["start"] = true;
            echo "<script>window.location=\"dashboard.php\"</script>";
        }
    }
    echo "<script>alert(\"Username atau password salah!\")</script>";
    echo "<script>window.location=\"index.php\"</script>";
}
elseif (isset($_POST["reg"])) {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $new_str = "insert into users (email, name, password) values (\"" . $email . "\",\"" . $username . "\",\"" . $password . "\");";

    $db->query($new_str);
    echo "<script>alert(\"User baru telah teregister.\")</script>";
    header("Location: index.php");
}
else {
    header("Location: index.php");
}
?>
