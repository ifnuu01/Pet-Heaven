<?php

require 'functions/connection.php';
require 'functions/admin_function.php';


$id = $_GET['id'];
$response = get_hewan_by_id($conn, $id);
echo json_encode($response);

?>