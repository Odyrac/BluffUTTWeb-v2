<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'statistics';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <?php

      $semester = getSemester();
      if (isset($_GET['semester']) && isValidSemester($_GET['semester'], 'withArchives')) {
        $semester = $_GET['semester'];
      }
      $players = getPlayers(null, $semester);

      $allStatisticsType = getStatisticsType();
      $statisticsType = $allStatisticsType[0];
      if (isset($_GET['statisticsType']) && isValidStatisticsType($_GET['statisticsType'])) {
        foreach ($allStatisticsType as $type) {
          if ($type['type'] === $_GET['statisticsType']) {
            $statisticsType = $type;
            break;
          }
        }
      }

      ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <div class="d-flex justify-content-between align-items-start">
                  <h5 class="card-title fw-semibold">Statistiques</h5>

                  <div class="d-flex flex-column gap-0 align-items-end">

                    <div class="dropdown">
                      <button class="btn btn-link text-decoration-none text-muted dropdown-toggle-split d-flex align-items-center gap-1 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Semestre <?php echo $semester; ?>
                        <i class="ti ti-chevron-down"></i>
                      </button>

                      <ul class="dropdown-menu pt-0 pb-0">
                        <?php
                        $semesters = getSemesters(null, 'withArchives');
                        $semesters = array_reverse($semesters);

                        foreach ($semesters as $sem) {
                          $isCurrentSemester = ($sem === $semester);
                          echo '<li><a class="dropdown-item" href="?semester=' . $sem . '&statisticsType=' . $statisticsType['type'] . '">' . ($isCurrentSemester ? '<i class="ti ti-check me-2"></i>' : '') . 'Semestre ' . $sem . '</a></li>';
                        }
                        ?>
                      </ul>
                    </div>

                    <div class="dropdown">
                      <button class="btn btn-link text-decoration-none text-muted dropdown-toggle-split d-flex align-items-center gap-1 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $statisticsType['name']; ?>
                        <i class="ti ti-chevron-down"></i>
                      </button>

                      <ul class="dropdown-menu pt-0 pb-0">
                        <?php
                        foreach ($allStatisticsType as $type) {
                          $isCurrentType = ($type['type'] === $statisticsType['type']);
                          echo '<li><a class="dropdown-item" href="?semester=' . $semester . '&statisticsType=' . $type['type'] . '">' . ($isCurrentType ? '<i class="ti ti-check me-2"></i>' : '') . $type['name'] . '</a></li>';
                        }
                        ?>
                      </ul>
                    </div>

                  </div>
                </div>

                <div style="height: 600px;" class="mt-3">
                  <canvas id='<?php echo $statisticsType['type']; ?>'></canvas>
                  <p id='noData' class='text-center text-muted' style='display: none;'>Aucune donnée disponible avec les paramètres actuels.</p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include('./components/scripts.php'); ?>

  <?php
  $directory = './bdd/semesters/' . $semester . '/archives/';
  $files = glob($directory . '*.json');
  ?>

  <script>
    var ctx = document.getElementById('<?php echo $statisticsType['type']; ?>');
    var data = {
      labels: [],
      datasets: []
    };

    <?php
    // Créer un tableau pour stocker les données brutes
    $rawData = [];

    foreach ($files as $file) {
      $json = file_get_contents($file);
      $data = json_decode($json, true);
      $date = basename($file, '.json');
      $date = DateTime::createFromFormat('d-m', $date);
      $rawData[$date->format('Ymd')] = $data;
    }

    // Trier le tableau par clé (date)
    ksort($rawData);

    $labels = [];
    $datasets = [];

    // Créer un tableau pour stocker les données de chaque joueur
    $playerData = [];

    foreach ($rawData as $date => $data) {
      $date = DateTime::createFromFormat('Ymd', $date);
      $labels[] = $date->format('d/m');

      foreach ($data as $player) {
        $id = $player['firstname'] . $player['lastname'];
        $name = getName($player['firstname'], $player['lastname']);
        $money = $player['money'];
        $points = $player['points'];
        $color = getRandomColor();
        $presenceCount = $player['presenceCount'];

        if (!isset($playerData[$id])) {
          $playerData[$id] = [
            'label' => $name,
            'data' => [],
            'backgroundColor' => $color,
            'borderColor' => $color,
            'fill' => false,
          ];

          if ($statisticsType['type'] == $allStatisticsType[2]['type'] || $statisticsType['type'] == $allStatisticsType[3]['type']) {
            $playerData[$id]['showLine'] = false;
            $playerData[$id]['pointRadius'] = 7;
          }
        }

        // On met à jour le presenceCount
        if ($playerData[$id]['presenceCount'] < $presenceCount || $playerData[$id]['presenceCount'] == null) {
          $playerData[$id]['presenceCount'] = $presenceCount;
        }

        if ($statisticsType['type'] == $allStatisticsType[0]['type']) {

          // Remplir les valeurs manquantes avec 10000
          while (count($playerData[$id]['data']) < count($labels) - 1) {
            $playerData[$id]['data'][] = 10000;
          }

          $playerData[$id]['data'][] = $money;
        } else if ($statisticsType['type'] == $allStatisticsType[1]['type']) {

          // Remplir les valeurs manquantes avec 0
          while (count($playerData[$id]['data']) < count($labels) - 1) {
            $playerData[$id]['data'][] = 0;
          }

          $playerData[$id]['data'][] = $points;
        } else if ($statisticsType['type'] == $allStatisticsType[2]['type']) {

          // Remplir les valeurs manquantes avec 0
          while (count($playerData[$id]['data']) < count($labels) - 1) {
            $playerData[$id]['data'][] = 0;
          }

          $lastGain = $playerData[$id]['lastGain'] ?? 10000;
          $moneyWin = $money - $lastGain;
          $playerData[$id]['data'][] = $moneyWin;
          $playerData[$id]['lastGain'] = $money;
        } else if ($statisticsType['type'] == $allStatisticsType[3]['type']) {

          // Remplir les valeurs manquantes avec 0
          while (count($playerData[$id]['data']) < count($labels) - 1) {
            $playerData[$id]['data'][] = 0;
          }

          $lastGain = $playerData[$id]['lastGain'] ?? 0;
          $pointsWin = $points - $lastGain;
          $playerData[$id]['data'][] = $pointsWin;
          $playerData[$id]['lastGain'] = $points;
        }
      }
    }

    // On enlève les joueurs qui ont un presenceCount < 2
    foreach ($playerData as $id => $player) {
      if ($player['presenceCount'] < 2) {
        unset($playerData[$id]);
      }
    }

    if ($statisticsType['type'] == $allStatisticsType[1]['type'] || $statisticsType['type'] == $allStatisticsType[3]['type']) {
      // On enlève les joueurs qui n'ont que des points à 0
      foreach ($playerData as $id => $player) {
        if (array_sum($playerData[$id]['data']) == 0) {
          unset($playerData[$id]);
        }
      }
    }

    $datasets = array_values($playerData);

    ?>

    data.labels = <?php echo json_encode($labels); ?>;
    data.datasets = <?php echo json_encode($datasets); ?>;

    if (data.datasets.length === 0 || data.labels.length === 0) {
      document.getElementById('noData').style.display = 'block';
      ctx.style.display = 'none';
    }

    var myChart = new Chart(ctx, {
      type: 'line',
      data: data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        elements: {
          line: {
            tension: 0.4
          },
          point: {
            radius: 4
          }
        },
        scales: {
          y: {
            beginAtZero: false
          }
        },
        plugins: {
          legend: {
            labels: {
              usePointStyle: true,
              pointStyle: 'circle'
            }
          }
        }
      }
    });
  </script>

</body>

</html>