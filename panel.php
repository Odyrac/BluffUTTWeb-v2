<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>

  <?php
  // Include the scripts before the "return;" possibility
  include('./components/scripts.php');
  ?>

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

                <h5 class="card-title fw-semibold mb-4">Panel admin
                  <?php
                  if (isPartyInProgress($players)) {
                    echo '<span class="badge bg-success rounded-3 ms-2">Soirée en cours</span>';
                  } else {
                    echo '<span class="badge bg-danger rounded-3 ms-2">Aucune soirée en cours</span>';
                  }
                  ?>
                </h5>

                <?php
                include('./components/env.php');

                if (!isset($_COOKIE['password']) || $_COOKIE['password'] != $passwordGlobal) {
                ?>
                  <form action="./api/login.php" method="post">
                    <div class="mb-3">
                      <label for="password" class="form-label">Mot de passe</label>
                      <input type="password" class="form-control" id="password" name="password" required autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                  </form>
                <?php
                  if (isset($_GET['error']) && $_GET['error'] == 'auth') {
                    echo '<div class="alert alert-danger mt-4" role="alert">Mot de passe incorrect !</div>';
                  }
                  return;
                } ?>

                <?php if (isset($_GET['action']) && $_GET['action'] == 'addPlayer') {
                ?>
                  <form action="./api/addPlayer.php" method="post">
                    <div class="mb-3">
                      <label for="firstname" class="form-label">Prénom</label>
                      <input type="text" class="form-control" id="firstname" name="firstname" required autofocus>
                    </div>
                    <div class="mb-3">
                      <label for="lastname" class="form-label">Nom</label>
                      <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3 form-check">
                      <input checked type="checkbox" class="form-check-input" id="check" name="checkbox">
                      <label class="form-check-label" for="check">L'ajouter directement dans la soirée</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                  </form>
                <?php return;
                } ?>

                <?php if (isset($_GET['success']) && $_GET['success'] == 'addPlayer') {
                  echo '<div class="alert alert-success mt-4" role="alert">Joueur ajouté avec succès !</div>';
                };

                if (isset($_GET['success']) && $_GET['success'] == 'enterPlayers') {
                  echo '<div class="alert alert-success mt-4" role="alert">Joueur(s) entré(s) avec succès !</div>';
                };

                if (isset($_GET['success']) && $_GET['success'] == 'rebuyPlayers') {
                  echo '<div class="alert alert-success mt-4" role="alert">Recave(s) enregistrée(s) avec succès !</div>';
                };

                if (isset($_GET['success']) && $_GET['success'] == 'exitPlayers') {
                  echo '<div class="alert alert-success mt-4" role="alert">Joueur(s) sorti(s) avec succès !</div>';
                };

                if (isset($_GET['success']) && $_GET['success'] == 'closeParty') {
                  echo '<div class="alert alert-success mt-4" role="alert">La soirée a été fermée avec succès !</div>';
                };

                if (isset($_GET['success']) && $_GET['success'] == 'closeSemester') {
                  echo '<div class="alert alert-success mt-4" role="alert">Le semestre a été fermé avec succès !</div>';
                }; ?>

                <div class="table-responsive">
                  <table class="table text-nowrap mb-0 align-middle">
                    <thead class="text-dark fs-4">
                      <tr>
                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">Joueur</h6>
                        </th>

                        <th class="border-bottom-0">
                          <h6 class="fw-semibold mb-0">État</h6>
                        </th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php
                      if ($players) {
                        $players = sortPlayersByFirstname($players);
                        foreach ($players as $player) {
                          $name = getName($player['firstname'], $player['lastname']);
                      ?>
                          <tr class="player-row" style="cursor: pointer;"
                            data-player='<?php echo json_encode($player); ?>'>
                            <td class="border-bottom-0">
                              <h6 class="fw-semibold mb-0"><?php echo $name; ?></h6>
                            </td>
                            <td class="border-bottom-0">
                              <?php if ($player['hasAlreadyPlayed'] == true) {
                                echo '<span class="badge bg-warning rounded-3 ms-2">A déjà joué</span>';
                              } else {
                                if ($player['isPlaying'] == true) {
                                  echo '<span class="badge bg-success rounded-3 ms-2">Joue</span>';
                                } else {
                                  echo '<span class="badge bg-danger rounded-3 ms-2">Ne joue pas</span>';
                                }
                              } ?>
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

          <div class="col-lg-6 d-flex align-items-stretch fixed-bottom ps-0 pe-0 pe-lg-3" style="left: auto; right: 0;">
            <div class="card w-100 mb-0 mb-lg-4">
              <div class="card-body p-4">
                <div class="d-flex justify-content-around">

                  <div class="d-flex flex-column align-items-center" onclick="window.location.href='panel.php?action=addPlayer'" style="cursor: pointer;">
                    <i class="ti ti-user-plus fs-4 mb-2"></i>
                    <span class="fw-semibold">Ajout</span>
                  </div>

                  <div class="d-flex flex-column align-items-center action-btn" id="enterBtn" style="opacity: 0.5; cursor: not-allowed;">
                    <i class="ti ti-login fs-4 mb-2"></i>
                    <span class="fw-semibold">Entrée</span>
                  </div>

                  <div class="d-flex flex-column align-items-center action-btn" id="rebuyBtn" style="opacity: 0.5; cursor: not-allowed;">
                    <i class="ti ti-pig-money fs-4 mb-2"></i>
                    <span class="fw-semibold">Recave</span>
                  </div>

                  <div class="d-flex flex-column align-items-center" id="exitBtn" style="opacity: 0.5; cursor: not-allowed;">
                    <i class="ti ti-logout fs-4 mb-2"></i>
                    <span class="fw-semibold">Sortie</span>
                  </div>

                  <div class="dropdown d-flex flex-column align-items-center">
                    <div class="dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                      <div class="d-flex flex-column align-items-center">
                        <i class="ti ti-dots fs-4 mb-2"></i>
                        <span class="fw-semibold">Plus</span>
                      </div>
                    </div>

                    <ul class="dropdown-menu pt-0 pb-0">
                      <li>
                        <a class="dropdown-item" style="opacity: 0.5; cursor: not-allowed;" id="pickTablesBtn">
                          <i class="ti ti-arrows-random me-2"></i>
                          Tirer les tables
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="null" style="opacity: 0.5; cursor: not-allowed;" id="closePartyBtn">
                          <i class="ti ti-confetti-off me-2"></i>
                          Fermer la soirée
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="null" style="opacity: 0.5; cursor: not-allowed;" id="closeSemesterBtn">
                          <i class="ti ti-calendar-off me-2"></i>
                          Fermer le semestre
                        </a>
                      </li>
                      <li>
                        <a class="dropdown-item border-top" href="./api/logout.php">
                          <i class="ti ti-door-exit me-2"></i>
                          Se déconnecter
                        </a>
                      </li>
                    </ul>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="closeParty" tabindex="-1" aria-labelledby="closePartyLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="closePartyLabel">Fermer une soirée</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Êtes-vous sûr de vouloir fermer la soirée ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <form method="post" action="./api/closeParty.php">
            <input type="hidden" name="confirm" value="true">
            <button type="submit" class="btn btn-primary">Confirmer</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="closeSemester" tabindex="-1" aria-labelledby="closeSemesterLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" action="./api/closeSemester.php">
          <div class="modal-header">
            <h5 class="modal-title" id="closeSemesterLabel">Fermer un semestre</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Êtes-vous sûr de vouloir fermer le semestre ?
            <input class="form-control mt-3" type="text" name="newSemester" placeholder="Nom du nouveau semestre à créer (ex : A25)" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary">Confirmer</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const playerRows = document.querySelectorAll('.player-row');
      const enterBtn = document.getElementById('enterBtn');
      const rebuyBtn = document.getElementById('rebuyBtn');
      const exitBtn = document.getElementById('exitBtn');
      const closePartyBtn = document.getElementById('closePartyBtn');
      const closeSemesterBtn = document.getElementById('closeSemesterBtn');
      const pickTablesBtn = document.getElementById('pickTablesBtn');
      let selectedPlayers = new Set();

      const dataPlayers = Array.from(playerRows).map(row => JSON.parse(row.dataset.player));
      const hasPlayingPlayerAll = dataPlayers.some(player => player.isPlaying);

      if (hasPlayingPlayerAll) {
        exitBtn.style.opacity = '1';
        exitBtn.style.cursor = 'pointer';
        exitBtn.onclick = function() {
          window.location.href = 'listPlayers.php?action=exitPlayers';
        };

        pickTablesBtn.style.opacity = '1';
        pickTablesBtn.style.cursor = 'pointer';
        pickTablesBtn.onclick = function() {
          window.location.href = 'listPlayers.php?action=pickTables';
        };

        closePartyBtn.style.opacity = '1';
        closePartyBtn.style.cursor = 'pointer';
        closePartyBtn.dataset.bsTarget = "#closeParty";
      } else {
        closeSemesterBtn.style.opacity = '1';
        closeSemesterBtn.style.cursor = 'pointer';
        closeSemesterBtn.dataset.bsTarget = "#closeSemester";
      }

      // Fonction pour mettre à jour l'état des boutons
      function updateButtonStates() {
        const hasPlayingPlayer = Array.from(selectedPlayers).some(player => player.isPlaying);
        const allPlaying = Array.from(selectedPlayers).every(player => player.isPlaying);
        const hasAlreadyPlayedPlayer = Array.from(selectedPlayers).some(player => player.hasAlreadyPlayed);

        // Par défaut, désactiver les deux boutons
        enterBtn.style.opacity = '0.5';
        enterBtn.style.cursor = 'not-allowed';
        enterBtn.onclick = null;
        rebuyBtn.style.opacity = '0.5';
        rebuyBtn.style.cursor = 'not-allowed';
        rebuyBtn.onclick = null;

        // Si des joueurs sont sélectionnés
        if (selectedPlayers.size > 0) {
          // Si aucun joueur sélectionné ne joue, activer le bouton Entrée
          if (!hasPlayingPlayer) {
            enterBtn.style.opacity = '1';
            enterBtn.style.cursor = 'pointer';

            enterBtn.onclick = function() {
              const selectedPlayersArray = Array.from(selectedPlayers);
              const playerIds = selectedPlayersArray.map(player => player.id);

              // Créer un formulaire caché
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = './api/enterPlayers.php';

              // Ajouter un champ caché pour les IDs des joueurs
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = 'players';
              input.value = JSON.stringify(playerIds);
              form.appendChild(input);

              // Ajouter le formulaire au document et le soumettre
              document.body.appendChild(form);
              form.submit();
            };
          }

          // Si tous les joueurs sélectionnés jouent, activer le bouton Recave
          if (allPlaying && !hasAlreadyPlayedPlayer) {
            rebuyBtn.style.opacity = '1';
            rebuyBtn.style.cursor = 'pointer';

            rebuyBtn.onclick = function() {
              const selectedPlayersArray = Array.from(selectedPlayers);
              const playerIds = selectedPlayersArray.map(player => player.id);

              // Créer un formulaire caché
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = './api/rebuyPlayers.php';

              // Ajouter un champ caché pour les IDs des joueurs
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = 'players';
              input.value = JSON.stringify(playerIds);
              form.appendChild(input);

              // Ajouter le formulaire au document et le soumettre
              document.body.appendChild(form);
              form.submit();
            };
          }
        }
      }

      // Ajouter les événements de clic sur les lignes
      playerRows.forEach(row => {
        row.addEventListener('click', function() {
          const playerData = JSON.parse(this.dataset.player);

          if (Array.from(selectedPlayers).some(p => p.id === playerData.id)) {
            selectedPlayers.forEach(p => {
              if (p.id === playerData.id) {
                selectedPlayers.delete(p);
              }
            });
            this.style.backgroundColor = '';
          } else {
            selectedPlayers.add(playerData);
            this.style.backgroundColor = '#e9ecef';
          }

          updateButtonStates();
        });
      });
    });
  </script>

</body>

</html>