<html>
	<head>

		<!-- Include meta tag to ensure proper rendering and touch zooming -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Include jQuery Mobile stylesheets -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">

		<!-- Include the jQuery library -->
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

		<!-- Include the jQuery Mobile library -->
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

	</head>
	<body>
		<div data-role="page">
			<div data-role="header">
				<h1>BiciMad</h1>
			</div>
			<div data-role="body">
				<h3>Login</h3>
				<form name="formulario">
					<input type="text" id="user" placeholder="User"/>
					<input type="password" id="pass" placeholder="Password"/>
					<input type="submit" value="Login" onclick="validar()">
				</form>
				<a href="signup.php"><p>Clic aquí para registrarte</p></a>
			</div>
		</div>
		
		<script>
			var user= document.getElementById("user").value;
			var pass= document.getElementById("pass").value;
			function validar(){
				$.ajax({
					url: "validar.php?user="+user+"&pass="+pass,
					type: "post"
				})
			}
		</script>
	</body>
</html>