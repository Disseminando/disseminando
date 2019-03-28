<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Disseminando - Curriculo</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
		<div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
			<form class="login100-form validate-form" method="post">
				<span class="login100-form-title p-b-37">
					Dados Pessoais
				</span>

				<div class="wrap-input100 validate-input m-b-20">
					<input class="input100" type="text" name="dados-data" value="<?php  
																				   $date = date('d/m/Y');
																				   echo $date;
																				?>" size="10" readonly="readonly"
                    >
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-20" data-validate="digite seu nome">
					<input class="input100" type="text" name="dados-nome" placeholder="digite seu nome">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-25" data-validate = "digite seu endereço">
					<input class="input100" type="password" name="dados-ende" placeholder="digite seu endereço">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite seu bairro">
					<input class="input100" type="password" name="dados-bairro" placeholder="digite seu bairro">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite sua cidade">
					<input class="input100" type="password" name="dados-cidade" placeholder="digite sua cidade">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite seu estado">
					<input class="input100" type="password" name="dados-uf" placeholder="digite seu estado">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite sua senha">
					<input class="input100" type="password" name="usu-senha" placeholder="digite sua senha">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite sua senha">
					<input class="input100" type="password" name="usu-senha" placeholder="digite sua senha">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite sua senha">
					<input class="input100" type="password" name="usu-senha" placeholder="digite sua senha">
					<span class="focus-input100"></span>
				</div>
                
                <div class="wrap-input100 validate-input m-b-25" data-validate = "digite sua senha">
					<input class="input100" type="password" name="usu-senha" placeholder="digite sua senha">
					<span class="focus-input100"></span>
				</div>

				<div class="container-login100-form-btn">
					<button class="login100-form-btn">Cadastrar</button>
				</div>
                <br>
                     <br>							
			</form>			
		</div>
	</div>
	
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>