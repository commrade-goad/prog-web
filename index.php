<?php
session_start();
if (!isset($_SESSION["start"])) {
    echo "<script>window.location=\"login/\"</script>";
} else {
    echo "<script>window.location=\"dashboard/\"</script>";
}
?>
