
    <?php require_once('partials/head.php'); ?>
    <?php require_once('class/Zawody.class.php'); ?>

    <div class="container">

      <h2>Tabela rozgrywek</h2>
      <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Spotkanie</th>
            <th scope="col">Wynik</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>

          <?php
            // tylko raz aby wygenerować nowy sezon rozgrywek
            // $zawody = new Zawody();
            // $druzyny = $zawody->generujDruzyny();
            // $spotkania = $zawody->zaplanujSpotkania($druzyny);
            // $zawody->zapiszZawody($spotkania, 2);

            Zawody::pokazTabeleRozgrywek(2);
          ?>

        </tbody>
      </table>

      <h2 class="mt-3">Ranking zawodników</h2>
      <p>na podstawie różnicy zwycięstw nad porażkami</p>
      <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">Ilość zwycięstw</th>
            <th scope="col">Ilość porażek</th>
            <th scope="col">Różnica</th>
          </tr>
        </thead>
        <tbody>

          <?php Zawodnik::pokazRankingZawodnikow(); ?>

        </tbody>
      </table>

    </div>

    <?php require_once('partials/bottom.php'); ?>
