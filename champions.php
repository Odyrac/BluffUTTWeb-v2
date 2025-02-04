<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'champions';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <?php
          $semesters = getSemesters();
          $currentSemester = getSemester();
          $playerWins = [];
          $bestMoney = array('firstname' => '', 'lastname' => '', 'money' => 0, 'semester' => '');
          $bestPoints = array('firstname' => '', 'lastname' => '', 'points' => 0, 'semester' => '');

          foreach ($semesters as $semester) {
            if ($semester == $currentSemester) {
              continue;
            }

            $players = getPlayers(null, $semester);
            $players = sortPlayersByPointsAndMoney($players);

            if (!empty($players)) {
              $winner = $players[0];
              $id = strtolower($winner['firstname'] . $winner['lastname']);

              if (!isset($playerWins[$id])) {
                $playerWins[$id]['firstname'] = $winner['firstname'];
                $playerWins[$id]['lastname'] = $winner['lastname'];
                $playerWins[$id]['wins'] = [$semester];
              } else {
                $playerWins[$id]['wins'] = array_merge($playerWins[$id]['wins'], [$semester]);
              }

              foreach ($players as $player) {
                if ($player['money'] > $bestMoney['money']) {
                  $bestMoney['firstname'] = $player['firstname'];
                  $bestMoney['lastname'] = $player['lastname'];
                  $bestMoney['money'] = $player['money'];
                  $bestMoney['semester'] = $semester;
                }

                if ($player['points'] > $bestPoints['points']) {
                  $bestPoints['firstname'] = $player['firstname'];
                  $bestPoints['lastname'] = $player['lastname'];
                  $bestPoints['points'] = $player['points'];
                  $bestPoints['semester'] = $semester;
                }
              }
            }
          }

          $greatChampion = null;
          foreach ($playerWins as $player) {
            if ($greatChampion == null || count($player['wins']) > count($greatChampion['wins'])) {
              $greatChampion = $player;
            }
          }

          $lastChampion = null;
          $lastSemester = $semesters[count($semesters) - 2];
          foreach ($playerWins as $player) {
            if (in_array($lastSemester, $player['wins'])) {
              $lastChampion = $player;
              break;
            }
          }

          ?>

          <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4 text-center">
                <img src="./assets/images/others/winner.png" style="width: 70px; height: 70px;">
                <h5 class="card-title fw-semibold mb-3 mt-3">Champion en titre : <?php echo getName($lastChampion['firstname'], $lastChampion['lastname']); ?></h5>
                <p class="card-text">Semestre <?php echo $lastSemester; ?></p>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4 text-center">
                <img src="./assets/images/others/laurel.png" style="width: 70px; height: 70px;">
                <h5 class="card-title fw-semibold mb-3 mt-3">Grand Champion : <?php echo getName($greatChampion['firstname'], $greatChampion['lastname']); ?></h5>
                <p class="card-text">Vainqueur des semestres <?php echo implode(', ', $greatChampion['wins']); ?></p>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4 text-center">
                <img src="./assets/images/others/dollar.png" style="width: 70px; height: 70px;">
                <h5 class="card-title fw-semibold mb-3 mt-3">Record compte fictif : <?php echo getMoney($bestMoney['money']); ?></h5>
                <p class="card-text">Détenu par <?php echo getName($bestMoney['firstname'], $bestMoney['lastname']); ?> (<?php echo $bestMoney['semester']; ?>)</p>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4 text-center">
                <img src="./assets/images/others/motivation.png" style="width: 70px; height: 70px;">
                <h5 class="card-title fw-semibold mb-3 mt-3">Record points : <?php echo $bestPoints['points']; ?></h5>
                <p class="card-text">Détenu par <?php echo getName($bestPoints['firstname'], $bestPoints['lastname']); ?> (<?php echo $bestPoints['semester']; ?>)</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php include('./components/scripts.php'); ?>

</body>

</html>