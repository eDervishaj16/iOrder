<?php
$connection = mysqli_connect("localhost", "edervishaj16", "ed632haj", "web18_edervishaj16");
$id = $_POST["id"];
mysqli_query($connection,"DELETE FROM users WHERE ID='$id'");

?>