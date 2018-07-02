<?php
  function debut($var, $mode = 1) {
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "<strong>Debug demandé dans le fichier
    : $trace[file] à la ligne : $trace
    [line]</strong>";
    if($mode == 1) {
        print '<pre>'; print_r($var); print '</pre>';
    else
        var_dump($var);
    }
  }
