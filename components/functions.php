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
    return mb_convert_case($firstname, MB_CASE_TITLE, 'UTF-8') . " " . mb_strtoupper($lastname, 'UTF-8');
}

// This function is used to get money of a player
function getMoney($money)
{
    return (abs($money) >= 1000 ? number_format($money, 0, ',', ',') : $money) . '$';
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

    $json = file_get_contents($path . 'bdd/semesters/' . $semester . '/global.json');
    $json = json_decode($json, true);

    if ($json === null) {
        return [];
    }

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

// This function is used to get the semesters
function getSemesters($path = null, $filter = null)
{
    if (!$path) {
        $path = './';
    }

    $semesters = array_diff(scandir($path . 'bdd/semesters'), array('..', '.'));

    // Conversion en tableau pour le tri
    $semestersArray = array_values($semesters);

    // Tri personnalisé
    usort($semestersArray, function ($a, $b) {
        // Extraire l'année et la saison (A ou P)
        $seasonA = substr($a, 0, 1); // P ou A
        $yearA = intval(substr($a, 1)); // L'année

        $seasonB = substr($b, 0, 1); // P ou A
        $yearB = intval(substr($b, 1)); // L'année

        // Si les années sont différentes
        if ($yearA !== $yearB) {
            return $yearA - $yearB;
        }

        // Si même année, P vient avant A
        if ($seasonA !== $seasonB) {
            return ($seasonA === 'P') ? -1 : 1;
        }

        return 0;
    });

    if ($filter == 'withArchives') {
        $semestersArray = array_filter($semestersArray, function ($semester) use ($path) {
            return is_dir($path . 'bdd/semesters/' . $semester . '/archives');
        });
    }

    return $semestersArray;
}

function isValidSemester($semester = null, $filter = null)
{
    $semesters = getSemesters(null, $filter);
    return in_array($semester, $semesters);
}

function getStatisticsType()
{
    $statisticsType = array(
        array('type' => 'evolAccountsParty', 'name' => 'Évolution comptes par soirée'),
        array('type' => 'evolPointsParty', 'name' => 'Évolution points par soirée'),
        array('type' => 'moneyParty', 'name' => 'Argent gagné par soirée'),
        array('type' => 'pointsParty', 'name' => 'Points gagnés par soirée')
    );
    return $statisticsType;
}

function isValidStatisticsType($type)
{
    $validTypes = array_column(getStatisticsType(), 'type');
    return in_array($type, $validTypes);
}

function getRandomColor()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

// This function is used to write a log
function writeLog($path = null, $message = null)
{
    if (!$path) {
        $path = './';
    }

    if (!$message) {
        return;
    }

    $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
    $date = $date->format('d/m/Y H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $message = '[' . $ip . ']' . ' ' . $date . ' - ' . $message . PHP_EOL;

    $maxLines = 999;

    // Read the file
    $lines = file($path . 'bdd/logs.txt');

    if (!empty($lines)) {
        // Remove the last lines if the file has more than $maxLines lines
        if (count($lines) >= $maxLines) {
            $lines = array_slice($lines, 0, $maxLines);
        }
    }

    // Write the log
    file_put_contents($path . 'bdd/logs.txt', $message . implode('', $lines));
}