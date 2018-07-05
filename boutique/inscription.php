<?php
require_once("inc/init.inc.php");

if($_POST) {
    //debug($_POST);
    $erreur = '';
    if (strlen($_POST['pseudo']) < 3 ||
    strlen($_POST['pseudo']) > 20) {
      $erreur .= '<div class="alert alert-danger" role="alert">Erreur sur la taille du pseudo</div>';
    }

    if(!preg_match('#^[a-zA-Z0-9.-_]+$#',
      $_POST['pseudo'])) {
          $erreur .= '<div class="alert
          alert-danger" role="alert">Erreur sur la taille du pseudo</div>';

    }
    $r = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $r->execute(array(':pseudo' => $_POST['pseudo'
    ]));

    if($r->rowCount() >= 1) {
        $erreur .= '<div class="alert alert-danger" role="alert">Le pseudo' . $_POST['pseudo'] . 'existe déjà</div>';
    }

    foreach($_POST as $indice => $valeur) {
        $_POST[$indice] = addslashes($valeur);
    }
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    if(empty($erreur)) {
      $r = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES (:pseudo, :mdp, :nom, prenom, :email, :civilite, :ville, :code_postal, :adresse)");
      $r->execute(array(
        ':pseudo'      => $_POST['pseudo'],
        ':mdp'         => $_POST['mdp'],
        ':nom'         => $_POST['nom'],
        ':prenom'      => $_POST['prenom'],
        ':email'       => $_POST['email'],
        ':civilite'    => $_POST['civilite'],
        ':ville'       => $_POST['ville'],
        ':code_postal' => $_POST['cp'],
        ':adresse'     => $_POST['adresse']
      ));
      $content .= '<div class="alert alert-success" role="alert">Inscription validée !</div>';
    }

    $content .= $erreur;
}
?>
<?php
require_once("inc/haut.inc.php");
?>
<?= $content; ?>
<!-- Formulaire HTML
- pseudo - input type="text"
- mdp - input type="password"
- prénom - input type="text"
- email - input type="email"
- civilité - input type="radio"
- ville - input type="text"
- code postal - input type="text"
- adresse - textarea
-->
<form class=""  method="post">
  <label for="pseudo">Pseudo :</label>
  <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo" name="pseudo" maxlength="20" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_" required><br><br>

  <label for="mdp">Password :</label>
  <input type="password" class="form-control" placeholder="Votre password" id="mdp" name="mdp" maxlength="20" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_" required><br><br>

  <label for="nom">Nom :</label>
  <input type="text" class="form-control" placeholder="Votre nom" id="Nom" name="nom" required><br><br>

  <label for="prenom">Prénom :</label>
  <input type="text" class="form-control" placeholder="Votre prénom" id="prenom" name="prenom" required><br><br>

  <label for="email">Email :</label>
  <input type="email" class="form-control" placeholder="Votre email" id="email" name="email" required><br><br>

  <label for="civilite">Civilité :</label><br><br>
  <input type="radio" class="form-control" placeholder="Votre civilité" id="civilite" name="civilite" value="m" checked>Homme<br><br>
  <input type="radio" class="form-control" p placeholder="Votre civilité" id="civilite2" name="civilite" value="f" >Femme<br><br>

  <label for="ville">Ville :</label>
  <input type="text" class="form-control" placeholder="Votre ville" id="ville" name="ville" maxlength="20" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_"><br><br>

  <label for="cp">code_postal : </label>
  <input type="text" class="form-control" placeholder="Votre code postal" id="cp" name="cp" maxlength="5" pattern="[a-zA-Z0-9.-_]{5,5}" title="Caractères acceptés : a-z A-Z 0-9 .-_"><br><br>

  <label for="adresse">Adresse :</label>
  <textarea name="adresse" class="form-control" placeholder="Votre adresse" id="adresse" maxlength="50" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_"></textarea><br><br>

  <button type="submit" name="button">S'inscrire</button>

</form>

<?php
require_once("inc/bas.inc.php");
?>
