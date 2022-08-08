<meta charset="utf-8" />
<?php

// Acces a la base de donnees
    $ans = $_POST["achoix"];
    
    //isset permet de vérifier que tous les champs sont remplis
    if(!isset($_POST["genre"]) || !isset($_POST["type"]) || !isset($_POST["taille"]) || !isset($_POST["couleur"]) || !isset($_POST["qte"])){
        echo "erreur, tous les champs n'ont pas été remplie";}
    elseif($ans == "consulter"){ //le code pour afficher la bdd quand consulter est choissie
        // Connexion a la BDD fac
        $pdo = new PDO("mysql:host=localhost;dbname=achatenligne","root",""); 

        // Requete INSERT en mode prepare
        $sel = $pdo->prepare("select * from stock");
        $sel->execute();
        echo '<table border="3" style="font-size:30px" td align="center">';
        echo "<tr>";
        echo '<td> <strong>' .'genre' .'</strong></td>';
        echo '<td> <strong>' .'vetement' .'</strong></td>';
        echo '<td> <strong>' .'taille' .'</strong></td>';
        echo '<td> <strong>' .'couleur' .'</strong></td>';
        echo '<td> <strong>' .'prix' .'</strong></td>';
        echo '<td> <strong>' .'quantité' .'</strong></td>';
        echo "</tr>";
        while($ligne = $sel->fetch()) {
            echo "<tr>";
            echo '<td>' .htmlspecialchars($ligne['genre']) .'</td>'; //htmlspecialchars permet de sécuriser le code en modifiant certain caractères tel que "<" 
            echo '<td>' .htmlspecialchars($ligne['typevetement']).'</td>';
            echo '<td>' .htmlspecialchars($ligne['taille']).'</td>';
            echo '<td>' .htmlspecialchars($ligne['couleur']).'</td>';
            echo '<td>' .htmlspecialchars($ligne['prix']).'</td>';
            echo '<td>' .htmlspecialchars($ligne['quantite']).'</td>';
            echo "</tr>";
        }
    }
    elseif($ans == "acheter"){ //le code pour modifier la quantité d'une ligne dans la bdd quand acheter est choissie
        $genre = htmlspecialchars($_POST["genre"]);
        $vete = htmlspecialchars($_POST["type"]);
        $taille = htmlspecialchars($_POST["taille"]);
        $couleur = htmlspecialchars($_POST["couleur"]);
        $qt = htmlspecialchars($_POST['qte']); 
        $pdo = new PDO("mysql:host=localhost;dbname=achatenligne","root","");
        $sel = $pdo->prepare("select * from stock where genre= '$genre' and typevetement= '$vete' and taille= '$taille' and couleur= '$couleur'");
        $sel->execute();
        while($ligne = $sel->fetch()) {
            $q = htmlspecialchars($ligne['quantite']);

        if($qt > $q){ // si la quantité choissie dans la boutique est inférieur à celle présente dans la bdd:
            echo "impossible de passer commande, il n'y a que " . $q . " articles correspondant à votre demande.";
        }
        else{
            $qt = $_POST['qte'] * -1; //on multiplie la quantité choissie par -1 afin d'obtenir la version négative
            $pdo = new PDO("mysql:host=localhost;dbname=achatenligne","root","");
            $sel = $pdo->prepare("select * from stock where genre= '$genre' and typevetement= '$vete' and taille= '$taille' and couleur= '$couleur'");
            while($ligne = $sel->fetch()) {
                $q = $ligne['quantite'];
            }
            $qtt = $q + $qt; //on additione la quantité actuelle avec la version négative de la quantité séléctionné afin de soustraire ce nombre dans la bdd
            $maj = $pdo->prepare("update stock set quantite=? where genre= '$genre' and typevetement= '$vete' and taille= '$taille' and couleur= '$couleur'");
            $maj->execute(array($qtt));
            header('Location: boutique2.html');
            echo "votre commande a bien été reçu";

        }
    }
}
    else {
    try { 
        echo "rater";
		
    }
        catch(PDOException $e) { 
        echo $e->getMessage("erreur brother"); 
    }
}
?>