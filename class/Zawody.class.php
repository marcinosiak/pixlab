<?php
  require_once('DBConn.class.php');
  require_once('Zawodnik.class.php');

  class Zawody
  {
    /**
     * Łączy zawodnikow zarejestrowanych w bazie w drużyny dwuosobowe
     * @return array [description]
     * Zwraca tablicę z drużynami w postaci:
     * [['Adam', 'Bartek'], ['Adam', 'Czarek'], ['Adam', 'Darek'] ...]
     */
    public function generujDruzyny()
    {
      $db = new DBConn();
      // $rows = $db->getRows("SELECT nazwa FROM zawodnicy");
      $rows = $db->getRows("SELECT id FROM zawodnicy");
      $db->Disconnect();

      $druzyny = [];
      $zawodnicy = [];

      foreach ($rows as $row) {
        // array_push($zawodnicy, $row['nazwa']);
        array_push($zawodnicy, $row['id']);
      }

      for($i=0; $i<=count($zawodnicy)-1; $i++)
      {
          for($j=$i+1;$j<count($zawodnicy);$j++)
          {
            array_push($druzyny, [$zawodnicy[$i],$zawodnicy[$j]]);
          }
      }

      return $druzyny;
    }


    /**
     * Sprawdzam czy podane pary mogą ze sobą zagrac.
     * Czy zawodnicy nie dublują się
     * @param  array $tablica1 - pierwsza drużyna
     * @param  array $tablica2  - druga drużyna
     * @return bool
     */
    private function porownaj_pary($tablica1, $tablica2)
    {
      $wyniki = [];
      // wynikiem działania tych pętli jest tablica z wartościami false i/lub true
      for ($i=0; $i<2; $i++)
      {
        for ($j=0; $j<2; $j++)
        {
          // echo "porownuję ".$tablica1[$i]." z tablicy 1 z elementem ".$tablica2[$j]." z tablicy 2  = ";
          if($tablica1[$i] == $tablica2[$j])
          {
            array_push($wyniki, false);
          }
          else
          {
            array_push($wyniki, true);
          }
        }
      }

      /**
       * Szukam w tablicy $wyniki wartości false.
       * Jeżeli jest chociaż jedna, to znaczy że zawodnicy dublują się
       * i ta kombinacja nie może ze sobą zagrać
       * @return integer lub bool
       * array_search() zwraca false w przypadku nieznalezienia lub int - numer indeksu znalezionej wartości
       */
      $czy_moga_zagrac = array_search(false, $wyniki);

      return !is_int($czy_moga_zagrac);
    }


    /**
     * Generuje tabele rozgrywek spośrod podanych drużyn
     * @param  [type] $druzyny [description]
     * @return [type]          [description]
     */
    public function zaplanujSpotkania($druzyny)
    {
      $spotkania = [];

      for ($i=0; $i<count($druzyny); $i++) {
        for ($j=$i+1; $j<count($druzyny); $j++) {
          if($this->porownaj_pary($druzyny[$i],$druzyny[$j]))
          {
            array_push($spotkania, [$druzyny[$i][0], $druzyny[$i][1], $druzyny[$j][0], $druzyny[$j][1]]);
          }
        }
      }
      return $spotkania;
    }

    /**
     * Zapisuje tabelę rozgrywek do bazy
     * @return [type] [description]
     */
    public function zapiszZawody($spotkania, $sezon)
    {
      $db = new DBConn();

      foreach ($spotkania as $zawodnik)
      {
        $mecz = $zawodnik[0].",".$zawodnik[1].",".$zawodnik[2].",".$zawodnik[3];

        $db->insertRow("INSERT INTO zawody(druzyny, wynik, sezon) VALUE(?, ?, ?)", [$mecz, "-", $sezon]);
        // $m = $mecz[0][0]." ".$mecz[0][1]." vs. ".$mecz[0][2]." ".$mecz[0][3];
        // var_dump($m);
      }

      $db->Disconnect();
    }

    /**
     * Pobiera z bazy i wyświetla tabele rozgrywek dla podanego sezony
     * @param  int $sezon  - numer sezonu
     * @return [type]        [description]
     */
    public static function pokazTabeleRozgrywek($sezon)
    {
      $db = new DBConn();
      $get_rows = $db->getRows("SELECT * FROM zawody WHERE sezon = ?", [$sezon]);

      $ile_meczy = 0;

      foreach ($get_rows as $spotkanie)
      {
        $ile_meczy++;

        // rozdzielam stringa do tablicy $druzyny
        $druzyny = explode(",", $spotkanie['druzyny']);

        $zawodnik_0 = Zawodnik::pobierzZawodnika($druzyny[0]);
        $zawodnik_1 = Zawodnik::pobierzZawodnika($druzyny[1]);
        $zawodnik_2 = Zawodnik::pobierzZawodnika($druzyny[2]);
        $zawodnik_3 = Zawodnik::pobierzZawodnika($druzyny[3]);

        echo "<tr>";
        echo "<th scope='row'>{$ile_meczy}</th>";
        echo "<td>{$zawodnik_0['nazwa']}, {$zawodnik_1['nazwa']} vs. {$zawodnik_2['nazwa']}, {$zawodnik_3['nazwa']}</td>";
        echo "<td>{$spotkanie['wynik']}</td>";
        echo "<td><form action='wynik-meczu.php' method='post'><button type='submit' name='wyslij_wynik' value='{$spotkanie['id']}' class='btn btn-primary'>Wprowadź wynik meczu</button></td>";
        echo "</tr>";

        // echo "<tr>";
        // echo "<th scope='row'>{$ile_meczy}</th>";
        // echo "<td>{$druzyny[0]}, {$druzyny[1]} vs. {$druzyny[2]}, {$druzyny[3]}</td>";
        // echo "<td>{$spotkanie['wynik']}</td>";
        // echo "<td><form action='wynik-meczu.php' method='post'><button type='submit' name='wyslij_wynik' value='{$spotkanie['id']}' class='btn btn-primary'>Wprowadź wynik meczu</button></td>";
        // echo "</tr>";
      }

      $db->Disconnect();
    }

    public static function szukajMeczu($id)
    {
      $db = new DBConn();

      $get_row = $db->getRow("SELECT * FROM zawody WHERE id = ?", [$id]);

      $db->Disconnect();

      return $get_row;
    }

  }
