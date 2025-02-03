<?php

include('./../components/env.php');

setcookie('password', 'null', time() + 365 * 24 * 3600, '/');

header('Location: ../panel.php');