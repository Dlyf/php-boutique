<?php
function debug($var, $mode = 1) {
  $trace = debug_backtrace();
  $trace = array_shift($trace);
  echo "<strong>Debug demandé dans le fichier
  : $trace[file] à la ligne : $trace[line]</strong>";
  if($mode == 1) {
      print '<pre>'; print_r($var); print '</pre>';
  } else
    var_dump($var);
}

function internauteEstConnecte() {
  // si ce n'est pas défini = isset
  if(!isset($_SESSION['membre']))
  return false;
  else return true;
}

function internauteEstConnecteEtEstAdmin() {
  // si ce n'est pas défini = isset
  if(internauteEstConnecte() &&
  $_SESSION['membre']['statut'] == 1)
    return true;
  else return false;
}
