<?php
$user= $_POST["user"];
$pass= $_POST["pass"];

$_SESSION["user"]=$user;

require('conecta.php');

		$con=Conectar();
		$sql="SELECT usuario FROM users WHERE usuario=$user";

		$res=mysqli_query($con,$sql);
		if($res!=null){
			header ("Location: test.php");
		}