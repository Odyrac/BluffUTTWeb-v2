# Bluff'UTT Web v2

## Introduction

Ce projet est une refonte de l'ancien site Bluff'UTT assurant la gestion du classement semestriel.

### Nouveautés

Le modèle de données a été repensé (et la totalité des anciennes data converties) afin de respecter :
```json
{
    "firstname": "john",
    "lastname": "smith",
    "money": 12300,
    "points": 23,
    "lastGain": 0,
    "isPlaying": false,
    "presenceCount": 5,
    "rebuyCount": 0,
    "hasAlreadyPlayed": false,
    "id": 0
}
```

De même, les classements historiques du club (avant sur des Sheets) y ont été intégrés.

Les statistiques sont aussi dorénavant disponibles pour les anciens semestres.

Le panel admin a été refondu.

## Site Web

Consultez le site ici : [https://bluffutt.hlly.fr/](https://bluffutt.hlly.fr/)

## Mot de passe

Pour utiliser le projet, ajoutez un fichier "./components/env.php".

```php
<?php
$passwordGlobal = "monmdp";
?>
```