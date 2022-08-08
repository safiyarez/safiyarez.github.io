<meta charset="utf-8" />
<?php
    
    $email_address = $_POST["email"];
    if (!preg_match(
    "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", //on s'assure qu'un @ est présent dans le form "email"
    $email_address))
    {
        echo "Error: Invalid email address";
    }
    elseif(htmlspecialchars($_POST["pass"]) != htmlspecialchars($_POST["confpass"])){
        echo "erreur, les mots de passe ne correspondent pas";} // on s'assure que les mdp correspondent
    elseif(!isset($_POST["nom"]) || !isset($_POST["prenom"]) || !isset($_POST["email"]) || !isset($_POST["pass"])){     //isset permet de vérifier que tous les champs sont remplis
        echo "erreur, tous les champs n'ont pas été remplie";}
    else {
    // Acces a la base de donnees
    try { 
	
		// Connexion a la BDD fac
		$pdo = new PDO("mysql:host=localhost;dbname=achatenligne","root",""); 

		// Requete INSERT en mode prepare
		$ins = $pdo->prepare("insert into connexions (nom,prenom,email,pass) values (?,?,?,?)");
		$ins->execute (array (htmlspecialchars($_POST["nom"]), htmlspecialchars($_POST["prenom"]), htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["pass"])));

        header('location:enregistrement2.html'); // envoie automatiquement à la page enregistrement2
	}
	catch(PDOException $e) { 
		echo $e->getMessage("erreur brother"); 
	}
    }
?>