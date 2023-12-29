<?php
	session_start();

	include("connexion.php");

	function nomPropre($arg){
		return ucfirst(strtolower(trim($arg)));
	}

	$notif="";
	if(isset($_POST["valider"])){

		foreach($_POST as $key=>$value)
			${$key}=$value;

		
		$sel=$pdo->prepare("select * from users where login=? and pass=? limit 1");
		$sel->setFetchMode(PDO::FETCH_ASSOC);
		$sel->execute(array($login,md5($pass)));
		$tab=$sel->fetchAll();
		
		if(count($tab)>0){
			$_SESSION["autoriser"]=true;
			$_SESSION["login"]=$tab[0]["login"];
			$_SESSION["nomPrenom"]=nomPropre($tab[0]["nom"])." ".nomPropre($tab[0]["prenom"]);
			header("location:session.php");
		}
		else
			$notif="<div class='error'>Mauvais login ou mot de passe!</div>";
		
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="css/style2.css" />
	</head>
	<body onLoad="document.fo.login.focus()">
		<section id="container">
			<form name="fo" method="post" action="" id="myform">
				<h1 class="h1title">Authentification requise <a href="inscription.php" class="lien">Je n'ai pas encore de compte</a></h1>
				<div id="notif"><?=$notif?></div>
				<input type="text" name="login" class="inputtext" placeholder="Login" value="<?=@$login?>" />
				<input type="password" name="pass" class="inputtext" placeholder="Mot de passe" />
				
				<input type="submit" name="valider" class="inputtext inputsubmit" value="S'authentifier" />
				
			</form>
		</section>
		
	</body>
</html>