<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'panel';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <?php

      $players = getPlayers();

      ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100" style="margin-bottom: 120px;">
              <div class="card-body p-4">

                <h5 class="card-title fw-semibold mb-4">Liste des joueurs</h5>

                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Joueur</h6>
                        </th>

                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">
                            <?php if ($_GET['action'] == 'exitPlayers') echo 'Argent sur la table'; ?>
                            <?php if ($_GET['action'] == 'pickTables') echo 'Table'; ?>
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      if ($players) {
                        $players = sortPlayersByFirstname($players);

                        if ($_GET['action'] == 'exitPlayers' || $_GET['action'] == 'pickTables') {
                          $players = array_filter($players, function ($player) {
                            return $player['isPlaying'] && !$player['hasAlreadyPlayed'];
                          });

                          if ($_GET['action'] == 'exitPlayers') echo '<form action="./api/exitPlayers.php" method="post">';

                          if ($_GET['action'] == 'pickTables') {
                            $nbTables = ceil(count($players) / 8);
                            $currentTable = 1;
                            $nbPlayers = count($players);
                            $tables = [];

                            for ($i = 0; $i < $nbPlayers; $i++) {
                              $tables[$currentTable] += 1;
                              $currentTable = $currentTable == $nbTables ? 1 : $currentTable + 1;
                            }

                            $tableNames =
                              [
                                1 => ['name' => 'Table verte', 'color' => 'green'],
                                2 => ['name' => 'Table bleue', 'color' => 'blue'],
                                3 => ['name' => 'Table rouge', 'color' => 'red']
                              ];
                          }
                        }

                        foreach ($players as $player) {
                          $name = getName($player['firstname'], $player['lastname']);
                      ?>
                          <tr>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0"><?php echo $name; ?></h6>
                            </td>
                            <td class="border-bottom-0">
                              <?php if ($_GET['action'] == 'exitPlayers') echo '<input class="form-control" type="number" name="' . $player['id'] . '" placeholder="Jetons rendus">' ?>

                              <?php if ($_GET['action'] == 'pickTables') {
                                $table = array_rand(array_filter($tables, function ($table) {
                                  return $table > 0;
                                }));
                                $tables[$table] -= 1;

                                $tableInfos = $tableNames[$table];

                                if (!$tableInfos) {
                                  $tableInfos = ['name' => 'Table ' . $table, 'color' => 'primary'];
                                }

                                echo '<span class="badge bg-' . $tableInfos['color'] . ' rounded-3">' . $tableInfos['name'] . '</span>';
                              }
                              ?>
                            </td>
                          </tr>
                      <?php
                        }
                      } else {
                        echo "<tr><td colspan='2'>Aucun joueur trouvé.</td></tr>";
                      }
                      ?>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>

          <?php
          if ($_GET['action'] == 'exitPlayers') { ?>
            <div class="col-lg-4 d-flex align-items-stretch fixed-bottom ps-0 pe-0 pe-lg-3" style="left: auto; right: 0;">
              <div class="card w-100 mb-0 mb-lg-4">
                <div class="card-body p-4">
                  <div class="d-flex justify-content-around">

                    <div class="d-flex flex-column align-items-center" onclick="window.location.href='panel.php'" style="cursor: pointer;">
                      <i class="ti ti-x fs-4 mb-2"></i>
                      <span class="fw-semibold">Annuler</span>
                    </div>

                    <div class="d-flex flex-column align-items-center" onclick="document.querySelector('form').submit();" style="cursor: pointer;">
                      <i class="ti ti-check fs-4 mb-2"></i>
                      <span class="fw-semibold">Valider</span>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            </form>

          <?php } ?>

        </div>
      </div>
    </div>
  </div>

  <?php include('./components/scripts.php'); ?>

</body>

</html>