<?php

include('./../components/env.php');
include('./../components/functions.php');

if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
    return header('Location: ../panel.php?error=auth');
}

if (!isset($_POST['confirm'])) {
    die('No confirmation');
}

$players = getPlayers('../');

if (!isPartyInProgress($players)) {
    die('No party in progress');
}

function compareLastGain($a, $b)
{
    if ($a['isPlaying'] == true && $b['isPlaying'] == true) {
        if ($a['lastGain'] == $b['lastGain']) {
            // Si les derniers gains sont égaux, on compare par le montant d'argent
            return $b['money'] - $a['money'];
        }
        // Sinon, on compare par les derniers gains
        return $b['lastGain'] - $a['lastGain'];
    } else if ($a['isPlaying'] == true) {
        return -1;
    } else if ($b['isPlaying'] == true) {
        return 1;
    } else {
        return 0;
    }
}

usort($players, 'compareLastGain');
$indice = 1;

foreach ($players as &$player) {
    if ($indice == 1 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 25;
    } else if ($indice == 2 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 18;
    } else if ($indice == 3 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 15;
    } else if ($indice == 4 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 12;
    } else if ($indice == 5 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 10;
    } else if ($indice == 6 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 8;
    } else if ($indice == 7 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 6;
    } else if ($indice == 8 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 4;
    } else if ($indice == 9 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 2;
    } else if ($indice == 10 && $player['isPlaying'] == true) {
        $player['points'] = $player['points'] + 1;
    }
    $player['lastGain'] = 0;
    $player['rebuyCount'] = 0;
    $player['isPlaying'] = false;
    $player['hasAlreadyPlayed'] = false;
    $indice++;
}

unset($player);

$json = json_encode($players, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$semester = getSemester('../');

file_put_contents('../bdd/semesters/' . $semester . '/global.json', $json);

$fileName = date('d-m') . '.json';

file_put_contents('../bdd/semesters/' . $semester . '/archives/' . $fileName, $json);

header('Location: ../panel.php?success=closeParty');