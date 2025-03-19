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

$type = 'money';

foreach ($_POST as $key => $value) {
    if ($key === 'type') {
        if ($value === 'money' || $value === 'points') {
            $type = $value;
        }
        continue;
    }

    if ($value !== '') {
        $playerId = intval($key);
        $change = intval($value);

        // Trouver l'index du joueur dans le tableau
        $playerIndex = array_search($playerId, array_column($players, 'id'));

        if ($playerIndex === false) {
            die('Player with ID ' . $playerId . ' does not exist');
        }

        if ($type === 'points') {
            $players[$playerIndex]['points'] += $change;

            array_push($playersName, getName($players[$playerIndex]['firstname'], $players[$playerIndex]['lastname']) . ' (' . $change . ' points)');
            continue;
        } else if ($type === 'money') {
            $players[$playerIndex]['money'] += $change;

            array_push($playersName, getName($players[$playerIndex]['firstname'], $players[$playerIndex]['lastname']) . ' (' . getMoney($change) . ')');
            continue;
        }
    }
}

$json = json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

$playersName = implode(', ', $playersName);
writeLog('../', 'Altération des données : ' . $playersName);

header('Location: ../panel.php?success=alterData');
