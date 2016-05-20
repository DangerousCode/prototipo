<?php
session_start();
require('conecta.php');
$con=Conectar();
$id=$_POST["id"];
$usuario=$_SESSION["usuario"];
$sql1="UPDATE data SET cant_bicis=cant_bicis-1 WHERE id=$id";
$sql2="UPDATE users SET reserva=1 WHERE user=$usuario";
mysqli_query($con,$sql1);
mysqli_query($con,$sql2);
echo ("Reserva realizada correctamente.");
?>