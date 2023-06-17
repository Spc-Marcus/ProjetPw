<?php include "Template/headerUser.php"; ?>
<!DOCTYPE html>
<html>

<head>
  <style>
    /* Styles spécifiques pour la mise en page */
    .blocs-festivals .card {
      margin-bottom: 20px;
    }

    .blocs-festivals .card-img-top {
      height: 200px;
      object-fit: cover;
    }

    .chg-btn {
      margin-bottom: 20px;
    }

    /* Styles pour la vue tableau */
    .hidden {
      display: none;
    }
  </style>
</head>

<body>


  <div class="container ">
    <div class="text-center mt-4 chg-btn">
      <button id="btn-liste" class="btn btn-primary">Afficher sous forme de liste</button>
      <button id="btn-blocs" class="btn btn-primary">Afficher sous forme de blocs</button>
    </div>

    <?php
    require_once("../DAO/FestivalDAO.php");
    require_once("../Model/Festival.php");

    $dbFile = '../DB/Donne.db';
    $pdo = new PDO('sqlite:' . $dbFile);
    $dao = new FestivalDAO($pdo);
    $festivals = $dao->getAll();

    if ($festivals) {
      // Vue sous forme de tableau
      echo '<div id="tableau-festivals">';
      echo '<table class="table table-striped table-hover">';
      echo '<thead>';
      echo '<tr>';
      echo '<th >Nom</th>';
      echo '<th onclick="trierParDate(this)">Date de début</th>';
      echo '<th onclick="trierParDate(this)">Date de fin</th>';
      echo '<th>Localisation</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';
      foreach ($festivals as $festival) {
        echo '<tr>';
        echo '<td>';
        echo '<form action="InfoFestival.php" method="post">';
        echo '<input type="hidden" name="festival_id" value="' . $festival->getFestivalId() . '">';
        echo '<button type="submit" class="btn btn-link">' . $festival->getNom() . '</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>' . $festival->getDate_debut() . '</td>';
        echo '<td>' . $festival->getDate_fin() . '</td>';
        echo '<td>' . $festival->getLocalisation() . '</td>';
        echo '</tr>';
      }
      echo '</tbody>';
      echo '</table>';
      echo '</div>';

      // Vue sous forme de blocs
      echo '<div id="blocs-festivals" class="hidden">';
      echo '<div class="row">';
      foreach ($festivals as $festival) {
        echo '<div class="col-md-4">';
        echo '<div class="card mb-4">';
        echo '<img src="../Image/' . $festival->getPhoto() . '" class="card-img-top" alt="Image du festival">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $festival->getNom() . '</h5>';
        echo '<p class="card-text">Date de début : ' . $festival->getDate_debut() . '</p>';
        echo '<p class="card-text">Date de fin : ' . $festival->getDate_fin() . '</p>';
        echo '<p class="card-text">Localisation : ' . $festival->getLocalisation() . '</p>';
        echo '<form action="InfoFestival.php" method="post">';
        echo '<input type="hidden" name="festival_id" value="' . $festival->getFestivalId() . '">';
        echo '<button type="submit" class="btn btn-primary">+ D\'info</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
      echo '</div>';

    } else {
      echo '<p>Aucun festival trouvé.</p>';
    }
    ?>

    <script>
      document.getElementById('btn-liste').addEventListener('click', function () {
        document.getElementById('tableau-festivals').classList.remove('hidden');
        document.getElementById('blocs-festivals').classList.add('hidden');
      });

      document.getElementById('btn-blocs').addEventListener('click', function () {
        document.getElementById('tableau-festivals').classList.add('hidden');
        document.getElementById('blocs-festivals').classList.remove('hidden');
      });

      function trierParDate(colonne) {
        const tableau = document.getElementById('tableau-festivals');
        const lignes = Array.from(tableau.getElementsByTagName('tbody')[0].getElementsByTagName('tr'));
        const indexColonne = colonne.cellIndex;
        const triInverse = (colonne.getAttribute('data-tri-inverse') === 'true');

        lignes.sort((a, b) => {
          const dateA = new Date(a.getElementsByTagName('td')[indexColonne].innerText);
          const dateB = new Date(b.getElementsByTagName('td')[indexColonne].innerText);

          if (triInverse) {
            return dateB - dateA;
          } else {
            return dateA - dateB;
          }
        });

        const fragment = document.createDocumentFragment();

        lignes.forEach((ligne) => {
          fragment.appendChild(ligne);
        });

        tableau.getElementsByTagName('tbody')[0].appendChild(fragment);

        colonne.setAttribute('data-tri-inverse', (!triInverse).toString());
      }



    </script>
  </div>

</body>

</html>