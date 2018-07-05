<?php require_once('../inc/init.inc.php');
//*-------------- TRAITEMENTS PHP -----------------------------//*
//*-------------- VÉRIFICATION ADMIN -----------------------------//*
if (!internauteEstConnecteEtEstAdmin()) {
  header("location:../connexion.php");
  exit();
}

//*-------------- ENREGISTREMENT D'UN PRODUIT -----------------------------//*
if(!empty($_POST)) {
  //debug($_POST);
  $photo_bdd = '';
  if(isset($_GET['action']) && $_GET['action'] == 'modification') {
    $photo_bdd = $_POST['photo_actuelle']; // en cas de modification, on récupère la photo actuelle.
  }

  if(!empty($_FILES['photo']['name'])) {
    // s'il y a une photo qui a été ajoutée
    $photo_bdd = URL . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // cette variable nous permettre de savegarder le chemin vers la base
    $photo_dossier = RACINE_SITE . "photo/$_POST[reference]_" . $_FILES['photo']['name']; // cette variable nous permettera de saveugarder la photo dans le dossier
    copy($_FILES['photo']['tmp_name'], $photo_dossier); // copy permet de sauvegarder une fichier sur le serveur.
  }

  $id_produit = (isset($_GET['id_produit'])) ? $_GET['id_produit'] : 'NULL'; // s'il y a un id_produit dans l'url c'est que nous sommes dans le cas d'une modification
  $produit = $pdo->prepare("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, sexe, photo, prix, stock) VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :sexe, :photo, :prix, :stock)");
  $produit->execute(array(
    ':id_produit'   => $id_produit,
    ':reference'    => $_POST['reference'],
    ':categorie'    => $_POST['categorie'],
    ':titre'        => $_POST['titre'],
    ':description'  => $_POST['description'],
    ':couleur'      => $_POST['couleur'],
    ':taille'       => $_POST['taille'],
    ':sexe'         => $_POST['sexe'],
    ':photo'        => $photo_bdd,
    ':prix'         => $_POST['prix'],
    ':stock'        => $_POST['stock']
  ));
  $content .= '<div class="alert alert-success">Le produit a bien été ajouté ;-) !</div>';
}

//*-------------- SUPPRESSION D'UN PRODUIT -----------------------------//*
if(isset($_GET['action']) && $_GET['action'] == 'suppression') {
  $resultat = $pdo->prepare("DELETE FROM produit WHERE id_produit = :id_produit");
  $resultat->execute(array(':id_produit' => $_GET['id_produit']));
}
//*-------------- LIENS PRODUITS -----------------------------//*
$content .= '<a class="btn btn-primary btn-sm" href="?action=affichage">Affichage des produits</a><br>'; // Lien d'ajout
$content .= '<a class="btn btn-primary btn-sm" href="?action=ajout">Ajout d\'un produit</a><br><br><hr><br>'; // Lien d'ajout

//*-------------- AFFICHAGE DES PRODUITS -----------------------------//*
if(isset($_GET['action']) && $_GET['action'] == "affichage") {
	$resultat = $pdo->prepare('SELECT * FROM produit');
	$resultat->execute();
	$content .= '<h2>Affichage des produits</h2>';
	$content .= 'Nombre de produit(s) dans la boutique : ' . $resultat->rowCount();
	$content .= '<table class="table table-bordered table-striped"><tr>';
	for($i = 0; $i < $resultat->columnCount(); $i++) { // boucle sur les colonnes
		$colonne = $resultat->getColumnMeta($i); // getColumnMeta récupère les informations sur les columnCount
		$content .= "<th>$colonne[name]</th>";
	}
	$content .= '<th colspan="2">Actions</th>';
	$content .= '</tr>';
	while($produits = $resultat->fetch(PDO::FETCH_ASSOC)) { // boucle sur les données
		$content .= '<tr>';
		foreach($produits as $indice => $valeur) {
			if($indice == 'photo')
				$content .= "<td><img src=\"$valeur\"></td>";
			else
				$content .= "<td>$valeur</td>";
		}
		$content .= '<td><a href="?action=modification&id_produit=' . $produits['id_produit'] . '"><span class="glyphicon glyphicon-pencil"></span></a></td>'; // lien de modification
		$content .= '<td><a href="?action=suppression&id_produit=' . $produits['id_produit'] . '" onClick="return(confirm(\'En êtes vous certain ?\'))"><span class="glyphicon glyphicon-trash"></span></a></td>'; // lien de suppression
	}
	$content .= '</tr></table><br><hr><br>';
}

//*-------------- FORMULAIRE D'AJOUT D'UN PRODUIT -----------------------------//*
require_once("../inc/haut.inc.php");
if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')) {
  if(isset($_GET['id_produit'])) {
    $resultat = $pdo->prepare(
      "SELECT *
       FROM produit
       WHERE id_produit = :id_produit");
       $resultat->execute(array(':id_produit' => $_GET['id_produit']));
       $produit_actuel = $resultat->fetch(PDO::FETCH_ASSOC);
  }

$content .= 'Bonjour <br> voici la gestion des produits.<hr>';
$content .= '
  <form method="post" action="" enctype="multipart/form-data"
  <input type="hidden" id="id_produit" name="id_produit" value="">
  <div class="form-group">
    <label for="reference">Référence : </label><br>
    <input type="text" id="reference" name="reference"
    placeholder="Référence du produit" value=""><br>
  </div>
  <div class="form-group">
    <label for="categorie">catégorie : </label><br>
    <input type="text" id="categorie" name="categorie"
    placeholder="categorie du produit" value=""><br>
  </div>
  <div class="form-group">
    <label for="titre">Titre : </label><br>
    <input type="text" id="titre" name="titre"
    placeholder="Titre du produit" value=""><br>
  </div>
  <div class="form-group">
    <label for="description">Description : </label><br>
    <textarea name="description" id="description" placeholder="Description du produit"></textarea><br>
  </div>
  <div class="form-group">
    <label for="couleur">Couleur : </label><br>
    <input type="text" id="couleur" name="couleur"
    placeholder="Couleur du produit" value=""><br>
  </div>
  <div class="form-group">
  		<label for="taille">Taille : </label><br>
  		<select name="taille" id="taille">
  			<option value="S">S</option>
  			<option value="M">M</option>
  			<option value="L">L</option>
  			<option value="XL">XL</option>
  		</select><br>
  	</div>
  	<div class="form-group">
  		<label for="sexe">Sexe : </label><br>
  		<select name="sexe" id="sexe">
  			<option value="f">Femme</option>
  			<option value="m">Homme</option>
  			<option value="mixte">Mixte</option>
  		</select><br>
  	</div>
  <div class="form-group">
    <label for="photo">Photo : </label><br>
    <input type="file" id="photo" name="photo"
    placeholder="Photo du produit" value=""><br>
  </div>
  <div class="form-group">
    <label for="prix">Prix : </label><br>
    <input type="text" id="prix" name="prix"
    placeholder="Prix du produit" value=""><br>
  </div>
  <div class="form-group">
    <label for="stock">Stock : </label><br>
    <input type="text" id="stock" name="stock"
    placeholder="Stock du produit" value=""><br>
  </div>
  <div class="form-group">
    <input type="submit" value="Ajouter un produit"><br>
  </div>
</form>';
}
echo $content;
require_once("../inc/bas.inc.php");
