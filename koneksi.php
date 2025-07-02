<?php
$con = mysqli_connect("localhost","root","","news");

// Check connection
if (mysqli_connect_errno()) {
  echo "Tidak mood terhubung ke MySQL: " . mysqli_connect_error();
  exit();
}
?>