<?php

include('./../components/env.php');
include('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

if (!isset($_POST)) {
    die('Please select at least one player');
}

$players = getPlayers('../');

$playersName = array();

foreach ($_POST as $key => $value) {
    if ($value !== '') {
        $playerId = intval($key);
        $money = intval($value);

        // Trouver l'index du joueur dans le tableau
        $playerIndex = array_search($playerId, array_column($players, 'id'));

        if ($playerIndex === false) {
            die('Player with ID ' . $playerId . ' does not exist');
        }

        if (!$players[$playerIndex]['isPlaying']) {
            die('Player with ID ' . $playerId . ' is not in the game');
        }

        if ($players[$playerIndex]['hasAlreadyPlayed']) {
            die('Player with ID ' . $playerId . ' has already played');
        }

        if ($money < 0) {
            die('Money cannot be negative');
        }

        // Modifier le joueur directement dans le tableau
        $players[$playerIndex]['money'] += $money;
        $players[$playerIndex]['hasAlreadyPlayed'] = true;
        $players[$playerIndex]['lastGain'] += $money;

        array_push($playersName, getName($players[$playerIndex]['firstname'], $players[$playerIndex]['lastname']) . ' (' . getMoney($money) . ')');
    }
}

$json = json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

$playersName = implode(', ', $playersName);
writeLog('../', 'Sortie des joueurs : ' . $playersName);

header('Location: ../panel.php?success=exitPlayers');