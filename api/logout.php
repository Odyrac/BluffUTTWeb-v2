<?php

include('./../components/env.php');
include('./../components/functions.php');

setcookie('password', 'null', time() + 365 * 24 * 3600, '/');

writeLog('../', 'Déconnexion');

header('Location: ../panel.php');