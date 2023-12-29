<?php
	session_start();
	if(!@$_SESSION["autoriser"]){
		header("location:login.php");
		exit("Vous n'avez le droit de voir cette page!");
	}

	$jour=array(
		"Dimanche",
		"Lundi",
		"Mardi",
		"Mercredi",
		"Jeudi",
		"Vendredi",
		"Samedi"
	);
	$mois=array(
		"",
		"janvier",
		"février",
		"mars",
		"avril",
		"mai",
		"juin",
		"juillet",
		"août",
		"septembre",
		"octobre",
		"novembre",
		"décembre"
	);

	$dauj=$jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");

	if(@$_FILES["photo"]["size"]>0){
		if(preg_match("#jpe?g$|png$#",$_FILES["photo"]["type"])){
			move_uploaded_file($_FILES["photo"]["tmp_name"],"uploads/".$_SESSION["login"].".jpg");
			header("location:session.php");
		}
	}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="css/style2.css?t=<?=time()?>" />
	</head>
	<body>

		<section id="container">
			<form name="fo" method="post" action="" id="myform" enctype="multipart/form-data">
				<input type="file" name="photo" id="input_file" onChange="this.form.submit()" />
				<label for="input_file" id="photo_profil" style="background-image:url('uploads/<?=$_SESSION["login"]?>.jpg?t=<?=time()?>')">
					
				</label>

				<div>
					<h1 class="h1title">
						
							<?=date("H")<18?"Bonjour":"Bonsoir" ?> 
							<?=$_SESSION["nomPrenom"]?>
						<div id="date_aujourdhui">
							<?=$dauj?>
						</div>
					</h1>
					
					<div class="label">Vous êtes désormais connectés à votre espace personnel</div>
					<a class="back" href="deconnexion.php">Quitter la session</a>
				</div>
			</form>
		</section>


		<label id="hamb" for="mycheck"></label>
		<input type="checkbox" id="mycheck" />
		<nav id="main">
			<a href="changerPass.php">Changer le mot de passe</a>
			<a href="deconnexion.php">Quitter la session</a>
		</nav>
		
	</body>
</html>