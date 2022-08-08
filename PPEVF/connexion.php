<meta charset="utf-8" />
<?php
// Acces a la base de donnees

    if(!isset($_POST["email"]) || !isset($_POST["pass"])){
        echo "erreur, tous les champs n'ont pas été remplie";}
    else {
    try { 
	
		// Connexion a la BDD fac
		$pdo = new PDO("mysql:host=localhost;dbname=achatenligne","root",""); 

		// Requete INSERT en mode prepare
		$sel = $pdo->prepare("select email, pass from connexions where email=? and pass=?");
        $sel->execute(array(htmlspecialchars($_POST["email"]), htmlspecialchars($_POST["pass"]))); //vérifie que "email" et "pass" correspondent à ce qui est présent dans la bdd

            if($ligne = $sel->fetch()) {
                header('Location: boutique.html'); // envoie automatiquement à la page boutique
            }
            else{
                echo "rater";
            }
	}
	catch(PDOException $e) { 
		echo $e->getMessage("erreur brother"); 
	}
}
?>