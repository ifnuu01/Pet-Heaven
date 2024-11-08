<?php

if (isset($_POST['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

include '../src/views/admin/template/header.php';

?>

<!-- <script src="../assets/js/navbar-dropdown.js"></script> -->
</body>
</html>