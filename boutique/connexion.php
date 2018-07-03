<?php require_once('inc/init.inc.php');

/*----------------- TRAITEMENTS PHP ------------*/
if(isset($_GET['action'] &&
if(isset($_GET['action'] ==
'deconnexion') {
  unset($_SESSION['membre'])
}
 ?>

/
<?php require_once('inc/haut.inc.php'); ?>
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
