<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'index';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <?php

      $semester = getSemester();
      if (isset($_GET['semester']) && isValidSemester($_GET['semester'])) {
        $semester = $_GET['semester'];
      }
      $players = getPlayers(null, $semester);

      ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <?php
                /*if (isPartyInProgress($players)) {
                  echo '<div class="alert alert-warning mb-4" role="alert">Une soirée est actuellement en cours !</div>';
                }*/
                ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h5 class="card-title fw-semibold">Classement soirées</h5>

                  <div class="dropdown">
                    <button class="btn btn-link text-decoration-none text-muted dropdown-toggle-split d-flex align-items-center gap-1 text-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Semestre <?php echo $semester; ?>
                      <i class="ti ti-chevron-down"></i>
                    </button>

                    <ul class="dropdown-menu pt-0 pb-0">
                      <?php
                      $semesters = getSemesters();
                      $semesters = array_reverse($semesters);

                      foreach ($semesters as $sem) {
                        $isCurrentSemester = ($sem === $semester);
                        echo '<li><a class="dropdown-item" href="?semester=' . $sem . '">' . ($isCurrentSemester ? '<i class="ti ti-check me-2"></i>' : '') . 'Semestre ' . $sem . '</a></li>';
                      }
                      ?>
                    </ul>
                  </div>
                </div>




                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0 m-0" style="padding-right: 0px; padding-left: 0px;">
                          <h6 class="fw-semibold mb-0">Place</h6>
                        </th>

                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Joueur</h6>
                        </th>

                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Points</h6>
                        </th>

                        <th class="border-bottom-0 ordi-affichage">
                          <h6 class="fw-semibold mb-0">Argent</h6>
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php

                      if ($players) {
                        $players = sortPlayersByPointsAndMoney($players);

                        $color = "";
                        $indice = 1;

                        foreach ($players as $player) {
                          if ($indice == 1) {
                            $color = "first";
                          } else if ($indice == 2) {
                            $color = "second";
                          } else if ($indice == 3) {
                            $color = "danger";
                          } else {
                            $color = "primary";
                          }

                          $indice++;

                          $money = getMoney($player['money']);
                          $name = getName($player['firstname'], $player['lastname']);
                      ?>

                          <tr>
                            <td class="border-bottom-0 m-0" style="padding-right: 0px; padding-left: 0px;">
                              <h6 class="fw-semibold mb-0"><?php echo $indice - 1; ?></h6>
                            </td>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0"><?php echo $name;
                                                            if ($player['isPlaying'] == true) {
                                                              echo '<span class="badge bg-success rounded-3 ms-2">Joue</span>';
                                                            }
                                                            ?>
                              </h6>
                              <span class="fw-normal mobile-affichage" style="display: none;"><?php echo $money; ?></span>
                            </td>
                            <td class="border-bottom-0">
                              <div class="d-flex align-items-center gap-2">
                                <span class="badge bg-<?php echo $color; ?> rounded-3 fw-semibold"><?php echo $player['points']; ?></span>
                              </div>
                            </td>
                            <td class="border-bottom-0 ordi-affichage">
                              <p class="mb-0 fw-normal"><?php echo $money; ?></p>
                            </td>
                          </tr>
                      <?php
                        }
                      } else {
                        echo "<tr><td colspan='4'>Aucun joueur trouvé.</td></tr>";
                      }

                      ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <script>
    function change_place_argent() {
      let largeur = window.innerWidth;

      if (largeur <= 500) {
        let argent = document.getElementsByClassName('mobile-affichage');
        let argentArray = Array.from(argent);
        argentArray.forEach(element => {
          element.style.display = 'block';
        });

        let argentordi = document.getElementsByClassName('ordi-affichage');
        let argentordiArray = Array.from(argentordi);
        argentordiArray.forEach(element => {
          element.style.display = 'none';
        });
      } else {
        let argent = document.getElementsByClassName('mobile-affichage');
        let argentArray = Array.from(argent);
        argentArray.forEach(element => {
          element.style.display = 'none';
        });

        let argentordi = document.getElementsByClassName('ordi-affichage');
        let argentordiArray = Array.from(argentordi);
        argentordiArray.forEach(element => {
          element.style.display = 'block';
        });
      }
    }

    window.addEventListener('resize', function() {
      change_place_argent();
    });

    change_place_argent();
  </script>

  <?php include('./components/scripts.php'); ?>

</body>

</html>