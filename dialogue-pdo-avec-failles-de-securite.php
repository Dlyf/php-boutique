<?php
/* Exercice : Espace de dialogue (tchat, livre d'or, module de commentaires à la YT ou FB)
Etapes :
1. Modélisation et création de la BDD dialogue :
    Table : commentaire
            id_commentaire //
            INT(3) PK - AI
            pseudo // VARCHAR(20
            message // TEXT
            date_enregistrement // DATETIME
            )
2. Connexion à la bdd

3. Création d'un formulaire HTML
(pour l'ajout de message )
4. Récupération et affichage des saisies PHP (POST)
5. Requête SQL d'enregistrement (INSERT et gestion apostrophe)
6. Affichage des messages (date au format Français)
7. Attaques : XSS + INJECTION SQL
8. Etude et moyen de contre
9. ordonner et mettre les derniers messages en tête de liste
10. Afficher le nombre de messages11.
11. Effectuer un retour visuel de meilleure qualité (CSS)


 */
// Connexion à la BDD
 $pdo = new PDO('mysql:host=localhost; dbname=dialogue', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

// Insertion des messages en BDD
 if($_POST) {
   $r = $pdo->prepare("INSERT INTO
   commentaire (pseudo,
   date_enregistrement, message)
   VALUES (:pseudo, NOW(), :message)");
   $r->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR); // le paramètre de la requête SQL, la valeur du paramètre, le type attendu
   $r->bindValue(':message', $_POST['message'], PDO::PARAM_STR);
   var_dump($r) . '<hr>';
   $r->execute();
 }

//************************************************************//
// Affichage
$resultat = $pdo->query("SELECT pseudo, message, DATE_FORMAT(date_enregistrement, '%d/%m/%Y') AS datefr, DATE_FORMAT(date_enregistrement, '%H:%i:%s') AS heurefr from commentaire ORDER BY date_enregistrement DESC");
echo '<legend><h2>' . $resultat->rowCount() . ' commentaire(s)</h2></legend>';
while($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)) {
    echo '<div class="message">';
    echo '<div class="titre">Par :
    ' . $commentaire['pseudo'] .
    ', le ' . $commentaire['datefr']
    . ' à ' . $commentaire['heurefr'] . '</div>';
    echo '<div class="contenu">' .
    $commentaire['message'] . '</div>';
echo '</div><hr />';
}
?>
<!-- ***********************************************************-->

<!-- **************  FORMULAIRE Html  *******************-->
<form action="" method="post">
    <fieldset>
        <legend>
          <h2>Formulaire</h2>
        </legend>

        <label for="pseudo">Pseudo : </label><br>
        <input type="text" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) print $_POST['pseudo']; ?>" size ="100"><br>


      <label for="message">
        Message :
      </label><br>
      <textarea id="message" name="message" cols="50" rows="7" value="<?php
        if(isset($_POST['message'])) print $_POST['message']; ?>"></textarea><br>

        <input type="submit">
      </fieldset>
</form>

<!--
1. Faille de sécurité XSS : Mettre une alerte à l'infi dans le corps du message :
<script type="text/javascript"
var point = true;
while(point === true)
alert("bonjour")
</script> -->

<!--
2. Injection CSS dans le corps du message :
<stryle>
  body {
    display: none;
  }
</style> -->

<!--  ok'); DELETE FROM commentaire; -->

<!-- 3. Injection SQL
ok'); DELETE FROM commentaire; -->
<!-- 4. Injection HTML balise <meta>
<meta http-equiv="refresh" content="10;url=dialogue.php"> -->
<!-- ********************** Moyens de contre *******************************-->
  <!-- - strip_tags() permet de supprimer toutes les balises HTML
  - htmlspecialchars() permet de rendre innoffensives les balises HTML
  - htmlentities() permet de convertir les balises HTML.
  - prepare + execute permettent d'empécher les injections -->
