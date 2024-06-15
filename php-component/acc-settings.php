<?php
function renderAccSettings(string $dest):void {
    echo "<h2>Settings</h2>";
    $db = new SQLite3('../db/database.db');
    $name = $_SESSION["user name"];
    echo "<form method='post' action='$dest'>";
    echo "<label for='username'>Username</label><br/>";
    echo "<input class='acc-input' type='text' name='username' value='$name' required><br/>";
    echo "<label for='password'>Password</label><br/>";
    echo "<input class='acc-input' type='password' name='password'><br/>";
    echo "<button class='table-button' type='submit' name='done-change'>&nbsp<i class='nf nf-cod-edit'></i> Change&nbsp</button>";
    echo "<button class='table-button' type='submit' name='del-acc'>&nbsp<i class='nf nf-fa-trash'></i> Delete this account&nbsp</button>";
    echo "</form>";

    if ($_SESSION["user type"] == 1) {

        echo "<br>";
        echo "<div class='table-responsive'>";
        echo "<h3>Other user settings</h3>";
        echo "<form method='post' action=$dest>";
        echo "<table class='table table-dark table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>username</th>";
        echo "<th>email</th>";
        echo "<th>type</th>";
        echo "<td></td>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $results = $db->query("select name, email, type from users;");
        while ($row= $results->fetchArray()) {
            $email = $row["email"];
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            if ($row["type"] == 1) {
                echo "<td><input style='background: none; color:white; border:none; max-width:40px;'type=number max=2 min= 1 name='type' value='" . $row["type"] . "' disabled></td>";
            } else {
                echo "<td><input style='background: none; color:white; border:none; max-width:40px;'type=number max=2 min= 1 name='type' value='" . $row["type"] . "'></td>";
            }
            echo "<td>";
            echo "<button name='edit-type' type='submit' class='btn text-white' value='$email'>&nbsp<i class='nf nf-fa-edit'></i>&nbsp</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</form>";
        echo "</div>";
    }

    // handle
    if (isset($_POST["done-change"])) {
        $pass = $_POST["password"];
        $user = $_POST["username"];
        $em = $_SESSION["user email"];
        unset($_POST);
        if ($pass == '') {
            $str = "update users set name = '$user' where email = '$em'";
        } else {
            $str = "update users set name = '$user', password = '$pass' where email = '$em'";
        }
        if ($db->query($str) == false) {
            echo "<script>alert('Gagal mengganti username dan password');</script>";
        } else {
            $_SESSION["user name"] = $user;
            echo "<script>alert('Penggantian Berhasil');</script>";
        }
    }

    if (isset($_POST["del-acc"])) {
        $em = $_SESSION["user email"];
        unset($_POST);
        $str = "delete from users where email = '$em'";
        session_destroy();
        echo "<script>window.location='index.php';</script>";
    }

    if (isset($_POST["edit-type"])) {
        $email = $_POST["edit-type"];
        $to_change = $_POST["type"];
        unset($_POST);
        $str = "update users set type = $to_change where email = '$email'";
        if ($db->query($str) == false) {
            echo "<script>alert('Gagal mengganti role');</script>";
        } else {
            echo "<script>alert('Penggantian Berhasil');</script>";
        }
    }
}

?>
