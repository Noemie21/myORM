<?php
require('Film.php');

$film = new Film();
$film->set(["Avatar","James Cameron"]);
$film->save();

var_dump($film->id);