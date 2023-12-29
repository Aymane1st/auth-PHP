<?php
	session_start();

	include("connexion.php");

	$notif="";
	if(empty($input)) $input="nom";
	if(isset($_POST["valider"])){

		foreach($_POST as $key=>$value)
			${$key}=$value;

		if(!preg_match("#^[A-Za-z \-]+$#",trim($nom))){
			$notif="<div class='error'>Nom invalide!</div>";
			$input="nom";
		}
		elseif(!preg_match("#^[A-Za-z \-]+$#",trim($prenom))){
			$notif="<div class='error'>Prénom invalide!</div>";
			$input="prenom";
		}
		elseif(!preg_match("#^[A-Za-z0-9]{4,20}$#",trim($login))){
			$notif="<div class='error'>Login invalide!</div>";
			$input="login";
		}
		elseif(preg_match("#[A-Z]+#",trim($pass))+preg_match("#[a-z]+#",trim($pass))+preg_match("#[0-9]+#",trim($pass))!=3){
			$notif="<div class='error'>Mot de passe invalide!</div>";
			$input="pass";
		}
		elseif($pass!=$repass){
			$notif="<div class='error'>Les mots de passes ne sont pas identiques!</div>";
			$input="pass";
		}
		else{
			$sel=$pdo->prepare("select count(id) as cpt from users where login=?");
			$sel->setFetchMode(PDO::FETCH_ASSOC);
			$sel->execute(array($login));
			$tab=$sel->fetchAll();
			if($tab[0]["cpt"]>0){
				$notif="<div class='error'>Login existe déjà!</div>";
				$input="login";
			}
			else{
				$ins=$pdo->prepare("insert into users(date,nom,prenom,login,pass) values(now(),?,?,?,?)");
				$ins->execute(array($nom,$prenom,$login,md5($pass)));
				header("location:login.php");
			}
		}
		
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="css/style2.css" />
	</head>
	<body onLoad="document.fo.<?=$input?>.focus()">
		<section id="container">
			<form name="fo" method="post" action="" id="myform">
				<h1 class="h1title">Nouvel utilisateur? Inscrivez-vous <a href="login.php" class="lien">J'ai déjà un compte</a></h1>
				<div id="notif"><?=$notif?></div>
				<input type="text" name="nom" class="inputtext" placeholder="Nom" value="<?=@$nom?>" />
				<input type="text" name="prenom" class="inputtext" placeholder="Prénom" value="<?=@$prenom?>" />
				<input type="text" name="login" class="inputtext" placeholder="Login" value="<?=@$login?>" />
				<input type="password" name="pass" class="inputtext" placeholder="Mot de passe" />
				<input type="password" name="repass" class="inputtext" placeholder="Confirmation du mot de passe" />
				
				<input type="submit" name="valider" class="inputtext inputsubmit" value="S'inscrire" />
				
			</form>
		</section>
		
	</body>
</html>