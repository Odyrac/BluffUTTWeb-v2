<?php

// This function is used to check if a party is in progress
function isPartyInProgress($joueurs)
{
    foreach ($joueurs as $joueur) {
        if ($joueur['isPlaying'] == true) {
            return true;
        }
    }
    return false;
}

// This function is used to sort the players by their points and their money
function sortPlayersByPointsAndMoney($joueurs)
{
    usort($joueurs, function ($a, $b) {
        // Compare by points (descending)
        $pointsComparison = $b['points'] - $a['points'];

        // If points are equal, compare by money (descending)
        if ($pointsComparison === 0) {
            return $b['money'] - $a['money'];
        }

        return $pointsComparison;
    });
    return $joueurs;
}

// This function is used to sort the players by their firstname
function sortPlayersByFirstname($joueurs)
{
    usort($joueurs, function ($a, $b) {
        return strcmp($a['firstname'], $b['firstname']);
    });
    return $joueurs;
}

// This function is used to get the name of a player
function getName($firstname, $lastname)
{
    return ucfirst($firstname) . " " . strtoupper($lastname);
}

// This function is used to get the players of a semester
function getPlayers($path = null, $semester = null)
{
    if (!$path) {
        $path = './';
    }

    // If the semester is not specified, get the current semester
    if ($semester == null) {
        $semester = getSemester($path);
    }

    $json = file_get_contents($path. 'bdd/semesters/' . $semester . '/global.json');
    $json = json_decode($json, true);

    return $json;
}

// This function is used to get the current semester
function getSemester($path = null)
{
    if (!$path) {
        $path = './';
    }

    $json_current = file_get_contents($path . 'bdd/current.json');
    $json_current = json_decode($json_current, true);
    return $json_current['currentSemester'];
}