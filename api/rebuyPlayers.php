<?php

include('./../components/env.php');
include ('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

$playerIds = json_decode($_POST['players']);

if (!isset($playerIds)) {
    die('Please select at least one player');
}

$players = getPlayers('../');

foreach ($playerIds as $playerId) {
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

    // Modifier le joueur directement dans le tableau
    $players[$playerIndex]['money'] -= 1000;
    $players[$playerIndex]['lastGain'] -= 1000;
    $players[$playerIndex]['rebuyCount'] += 1;
}

$json = json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

header('Location: ../panel.php?success=rebuyPlayers');

?>