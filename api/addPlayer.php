<?php

include('./../components/env.php');
include ('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

$firstname = strtolower($_POST['firstname']);
$lastname = strtolower($_POST['lastname']);

$money = 10000;
$points = 0;
$isPlaying = false;
$presenceCount = 0;
$lastGain = 0;

$hasAlreadyPlayed = false;
$rebuyCount = 0;

if (isset($_POST['checkbox'])) {
    $money = 9000;
    $isPlaying = true;
    $presenceCount = 1;
    $lastGain = -1000;
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

$json = json_encode($players, JSON_PRETTY_PRINT);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

header('Location: ../panel.php?success=addPlayer');

?>