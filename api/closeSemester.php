<?php

include('./../components/env.php');
include('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

$newSemester = $_POST['newSemester'];

if (!isset($newSemester)) {
    die('No newSemester');
}

$players = getPlayers('../');

if (isPartyInProgress($players)) {
    die('Party in progress');
}

$newSemesterPath = '../bdd/semesters/' . $newSemester;

if (!file_exists($newSemesterPath)) {
    mkdir($newSemesterPath, 0777, true);
    file_put_contents($newSemesterPath . '/global.json', json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

$currentData = json_decode(file_get_contents('../bdd/current.json'), true);
$currentData['currentSemester'] = $newSemester;
file_put_contents('../bdd/current.json', json_encode($currentData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

writeLog('../', 'Fermeture du semestre, ouverture du semestre ' . $newSemester);

header('Location: ../panel.php?success=closeSemester');