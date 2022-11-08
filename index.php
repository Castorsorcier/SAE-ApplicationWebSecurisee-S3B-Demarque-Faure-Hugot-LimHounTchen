<?php

session_start();

require 'vendor/autoload.php';

use \iutnc\deefy\dispatch\Dispatcher;

$show=new Dispatcher();
$show->run();
