<?php require_once('partials/head.php'); ?>
<?php require_once('class/Zawody.class.php'); ?>
<?php require_once('class/Mecz.class.php'); ?>
<?php require_once('class/Zawodnik.class.php'); ?>

<?php
  /*
    Szukam meczu w bazie po id
   */
  if(isset($_POST['wyslij_wynik']))
  {
    $id_meczu = $_POST['wyslij_wynik'];
    $spotkanie = Zawody::szukajMeczu($id_meczu);

    $druzyny = explode(",", $spotkanie['druzyny']);

    $mecz = "{$druzyny[0]}, {$druzyny[1]} vs. {$druzyny[2]}, {$druzyny[3]}";
    $gospodarze = "{$druzyny[0]}, {$druzyny[1]}";
    $goscie = "{$druzyny[2]}, {$druzyny[3]}";

    $zawodnik_0 = Zawodnik::pobierzZawodnika($druzyny[0]);
    $zawodnik_1 = Zawodnik::pobierzZawodnika($druzyny[1]);
    $zawodnik_2 = Zawodnik::pobierzZawodnika($druzyny[2]);
    $zawodnik_3 = Zawodnik::pobierzZawodnika($druzyny[3]);

    $gospodarze_nazwa = $zawodnik_0['nazwa']." ".$zawodnik_1['nazwa'];
    $goscie_nazwa = $zawodnik_2['nazwa']." ".$zawodnik_3['nazwa'];
    $zawodnicy = $gospodarze_nazwa." vs. ".$goscie_nazwa;
  }

  if(isset($_POST['zapisz_wynik']))
  {
    $id_meczu = $_POST['zapisz_wynik'];
    // pobieram wynik meczu z formularza
    (isset($_POST['wynik_gospodarze'])) ? $wynik_gospodarze = $_POST['wynik_gospodarze'] : $wynik_gospodarze = 0;
    (isset($_POST['wynik_goscie'])) ? $wynik_goscie = $_POST['wynik_goscie'] : $wynik_goscie = 0;

    Mecz::zapiszWynik($wynik_gospodarze, $wynik_goscie, $id_meczu);

    // pobieram z bazy id zawodnikow, ktorzy grali w tym meczu
    $spotkanie = Zawody::szukajMeczu($id_meczu);
    $druzyny = explode(",", $spotkanie['druzyny']);

    if($wynik_gospodarze > $wynik_goscie)
    {
      Zawodnik::zapiszPunkty(1, $druzyny[0]);
      Zawodnik::zapiszPunkty(1, $druzyny[1]);
      Zawodnik::zapiszPunkty(0, $druzyny[2]);
      Zawodnik::zapiszPunkty(0, $druzyny[3]);
    }
    else
    {
      Zawodnik::zapiszPunkty(0, $druzyny[0]);
      Zawodnik::zapiszPunkty(0, $druzyny[1]);
      Zawodnik::zapiszPunkty(1, $druzyny[2]);
      Zawodnik::zapiszPunkty(1, $druzyny[3]);
    }

    header("Location: index.php");
  }

?>

<div class="container">

  <div class="row">
    <div class="col-12">
        <h2>Wprowadź wynik meczu:</h2>
        <h4> <?php if(isset($zawodnicy)) echo $zawodnicy; ?></h4>

        <form action="wynik-meczu.php" method="post">
          <div class="row mt-5">

            <div class="col-12">
              <div class="form-group">
                <label for="wynik_gospodarze">Wynik gospodarzy:
                  <?php if(isset($gospodarze_nazwa)) echo $gospodarze_nazwa; ?>
                </label>
                <input type="text" name="wynik_gospodarze" class="form-control" placeholder="Wpisz wynik">
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label for="wynik_gospodarze">Wynik gości: <?php if(isset($goscie_nazwa)) echo $goscie_nazwa; ?></label>
                <input type="text" name="wynik_goscie" class="form-control" placeholder="Wpisz wynik">
              </div>
            </div>

            <div class="col-12">
              <button type="submit" name="zapisz_wynik" value="<?php if(isset($id_meczu)) echo $id_meczu; ?>" class="btn btn-primary my-3">Zapisz wynik meczu</button>
            </div>

          </div>
        </form>
    </div>
  </div>

</div>

<?php require_once('partials/bottom.php'); ?>
