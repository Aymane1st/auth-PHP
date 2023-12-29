<?php
	try{
		$pdo=new PDO(
			"mysql:host=localhost;dbname=isi2_2023",
			"root",
			""
		);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}
?>