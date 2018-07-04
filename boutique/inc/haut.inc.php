<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo URL; ?>../boutique/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  
  </head>
  <body>
    <header>
      <div class="container">
          <div>
              <a href="" title="Mon Sie">Monsite.com</a>
          </div>
          <nav>
            <ul>
              <li><a href="<?= URL; ?>index.php">Accueil</a></li>
              <?php if(internauteEstConnecteEtEstAdmin()): ?>
              <li><a href="<?= URL; ?>admin/gestion-des-produits.php">Gestion des produits</a></li>
              <?php endif; ?>
              <?php if(internauteEstConnecte()): ?>
              <li><a href="<?= URL; ?>panier.php">Panier</a></li>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <ul>
                            <li class="dropdown-item"><a href="<?= URL; ?>profil.php">Profil</a></li>
                            <li class="dropdown-item">
                                <a href="<?= URL; ?>connexion.php?action=deconnexion">Déconnexion</a></li>
                        </ul>
                    </li>
                </div>
                </div>
                <?php else: ?>
                <li><a href="<?= URL; ?>panier.php">Panier</a></li>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membre</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <ul>
                                <li class="dropdown-item"><a href="<?= URL; ?>inscription.php">Inscription</a></li>
                                <li class="dropdown-item"><a href="<?= URL; ?>connexion.php">Connexion</a></li>
                            </ul>
                        </li>
                    </div>
                </div>
                <?php endif; ?>
                </nav>
    </header>
      <section class="container">
