<?php

include "util.php";

session_unset();
session_destroy();

redirecionar("index.php");
exit;

?>