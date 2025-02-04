<!doctype html>
<html lang="fr">

<?php include('./components/head.php'); ?>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <?php
    $page = 'help';
    include('./components/sidebar.php'); ?>

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <?php include('./components/header.php'); ?>

      <?php include('./components/functions.php'); ?>

      <div class="container-fluid">

        <!--  Row 1 -->
        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <h5 class="card-title fw-semibold mb-4">Explications</h5>

                <p>À partir du semestre A23, la notion de "points" est introduite. Pour gagner ces points, il faut finir parmi les meilleurs d'une soirée. En effet, comme pour la Formule 1, à chaque soirée, les 10 plus gros gagnants sont récompensés. Ce changement permet de minimiser l'impact d'une seule bonne soirée pour un joueur sur le classement semestriel !</p>

                <p>Pour tous les nouveaux, nous vous rappelons qu'au début de chaque semestre, 10,000$ vous sont attribués et ce "compte fictif" vous suit à chaque soirée. Ce système est bien conservé, mais il ne représente plus le classement prioritaire !</p>

                <p>Voici le barème des points :</p>

                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">Place en fin de soirée</th>
                      <th scope="col">Points</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">1er</th>
                      <td>25</td>
                    </tr>
                    <tr>
                      <th scope="row">2ème</th>
                      <td>18</td>
                    </tr>
                    <tr>
                      <th scope="row">3ème</th>
                      <td>15</td>
                    </tr>
                    <tr>
                      <th scope="row">4ème</th>
                      <td>12</td>
                    </tr>
                    <tr>
                      <th scope="row">5ème</th>
                      <td>10</td>
                    </tr>
                    <tr>
                      <th scope="row">6ème</th>
                      <td>8</td>
                    </tr>
                    <tr>
                      <th scope="row">7ème</th>
                      <td>6</td>
                    </tr>
                    <tr>
                      <th scope="row">8ème</th>
                      <td>4</td>
                    </tr>
                    <tr>
                      <th scope="row">9ème</th>
                      <td>2</td>
                    </tr>
                    <tr>
                      <th scope="row">10ème</th>
                      <td>1</td>
                    </tr>
                  </tbody>
                </table>

                <p><strong>Informations : </strong><br>- Au delà de la dixième place, aucun point n'est obtenu.<br>- En cas d'égalité sur la somme d'argent rendue, le joueur étant le plus riche sur son compte fictif prend la place la plus haute.<br>- Il est possible de marquer des points à partir du moment où l'on est présent à la soirée, même si l'on finit en négatif (tant que cela reste une des 10 meilleures performances du soir).</p>

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