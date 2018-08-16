<?php
    require_once('class/DBConn.class.php');
    require_once('class/Zawodnik.class.php');

    if(isset($_POST['dodaj_zawodnika']))
    {
      $nazwa_zawodnika = htmlspecialchars($_POST['nazwa_zawodnika']);

      $zawodnik = new Zawodnik();
      $zawodnik->createZawodnik($nazwa_zawodnika);
    }

?>

<?php require_once('partials/head.php'); ?>


    <div class="container">

      <div class="row">
        <div class="col-12">
            <h2>Dodaj zawodnika</h2>
            <form action="zawodnik.php" method="post">
              <div class="row">
                <div class="col">
                  <input type="text" id="nazwa_zawodnika" name="nazwa_zawodnika" class="form-control" placeholder="Nazwa zawodnika">
                  <button type="submit" name="dodaj_zawodnika" class="btn btn-primary my-3">Dodaj zawodnika</button>
                </div>

              </div>
            </form>
        </div>
      </div>


      <h2 class="mt-3">Wszyscy zawodnicy</h2>
      <br>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nazwa</th>
            <th scope="col">ilość punktów</th>
            <th scope="col">ilość rozegranych meczy</th>
          </tr>
        </thead>
        <tbody>
          <?php Zawodnik::pokazZawodnikow(); ?>
        </tbody>
      </table>

    </div>

    <?php require_once('partials/bottom.php'); ?>
