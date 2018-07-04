<?php require_once('inc/init.inc.php');

/*----------------- TRAITEMENTS PHP ------------*/
if(isset($_GET['action']) && $_GET['action'] ==
'deconnexion') {
  unset($_SESSION['membre']);
}

if (internauteEstConnecte()) {
  header('location:profil.php');
  exit();
}

if ($_POST) {
  $resultat = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
  $resultat->execute(array(':pseudo' => $_POST['pseudo']));
  if($resultat->rowCount() >= 1) {
    $membre = $resultat->fetch(PDO::FETCH_ASSOC);
    if(password_verify($_POST['mdp'], $membre['mdp'])) {
      $_SESSION['membre']['id_membre'] = $membre['id_membre'];
      $_SESSION['membre']['pseudo'] = $membre['pseudo'];
      $_SESSION['membre']['nom'] = $membre['nom'];
      $_SESSION['membre']['prenom'] = $membre['prenom'];
      $_SESSION['membre']['email'] = $membre['email'];
      $_SESSION['membre']['civilite'] = $membre['civilite'];
      $_SESSION['membre']['ville'] = $membre['ville'];
      $_SESSION['membre']['code_postal'] = $membre['code_postal'];
      $_SESSION['membre']['adresse'] = $membre['adresse'];
      $_SESSION['membre']['statut'] = $membre['statut'];

      header("location:profil.php");
    } else {
      $content .= '<div class="alert alert-danger" role="alert">Erreur de mot de passe</div>';
    }
  } else {
    $content .= '<div class="alert alert-danger" role="alert">Erreur de pseudo</div>';
  }
}
 ?>


<?php require_once('inc/haut.inc.php'); ?>
<?= $content; ?>
<!-- Formulaire HTML de connexion
- pseudo - input type="text"
- mdp - input type="password"
 -->

 <form class="" action="" method="post">
   <label for="pseudo">Pseudo :</label>
   <input type="text" class="form-control" placeholder="Votre pseudo" id="pseudo" name="pseudo" maxlength="20" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_" required><br><br>

   <label for="mdp">Password :</label>
   <input type="password" class="form-control" placeholder="Votre password" id="mdp" name="mdp" maxlength="20" pattern="[a-zA-Z0-9.-_]{3, 20}" title="Caractères acceptés : a-z A-Z 0-9 .-_" required><br><br>

   <input type="submit" class="btn btn-default" name="se connecter" value="Se connecter">

 </form>

<?php require_once('inc/bas.inc.php'); ?>
