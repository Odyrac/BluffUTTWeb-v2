<?php

include('./../components/env.php');
include ('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

$firstname = html_entity_decode(strtolower($_POST['firstname']), ENT_QUOTES, 'UTF-8');
$lastname = html_entity_decode(strtolower($_POST['lastname']), ENT_QUOTES, 'UTF-8');

$money = 10000;
$points = 0;
$isPlaying = false;
$presenceCount = 0;
$lastGain = 0;

$hasAlreadyPlayed = false;
$rebuyCount = 0;

$isPlayingString = '';

if (isset($_POST['checkbox'])) {
    $money = 9000;
    $isPlaying = true;
    $presenceCount = 1;
    $lastGain = -1000;
    $isPlayingString = ' (entrée en jeu)';
}

$players = getPlayers('../');

if ($firstname == "" || $lastname == "") {
    die('Please fill all the fields');
}

$newPlayer = [
    'firstname' => $firstname,
    'lastname' => $lastname,
    'money' => $money,
    'points' => $points,
    'lastGain' => $lastGain,
    'isPlaying' => $isPlaying,
    'presenceCount' => $presenceCount,
    'rebuyCount' => $rebuyCount,
    'hasAlreadyPlayed' => $hasAlreadyPlayed,
    'id' => count($players)
];

$players[] = $newPlayer;

$json = json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

writeLog('../', 'Ajout du joueur : ' . getName($firstname, $lastname) . $isPlayingString);

header('Location: ../panel.php?success=addPlayer');

?>