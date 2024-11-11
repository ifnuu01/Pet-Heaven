<?php

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

include 'template/header.php';
?>


<script src="assets/js/kategori-dropdown.js"></script>
<script src="assets/js/profile-dropdown.js"></script>
</body>
</html>