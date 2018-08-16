<?php
  require_once('dbconn.class.php');

  class Zawodnik
  {
    private $nazwa_zawodnika;
    private $ilosc_punktow;


    /**
     * Zapisuje zawodnika do bazy
     * @param  string  $nazwa  - nazwa zawodnika
     * @param  integer $punkty - ilość punktów, które zdobył w rozgrywkach
     */
    public function createZawodnik($nazwa, $punkty = 0)
    {
      $db = new DBConn();
      $db->insertRow("INSERT INTO zawodnicy(nazwa, punkty) VALUE(?, ?)", [$nazwa, $punkty]);

      $db->Disconnect();
    }

    /**
     * Wyświetla jednego zawodnika z bazy
     */
    public static function pobierzZawodnika($id)
    {
      $db = new DBConn();
      $zawodnik = $db->getRow("SELECT * FROM zawodnicy WHERE id = ?", [$id]);
      $db->Disconnect();

      return $zawodnik;
    }

    /**
     * Wyświetla wszystkich zawodnikow z bazy
     */
    public static function pokazZawodnikow()
    {
      $db = new DBConn();
      $get_rows = $db->getRows("SELECT * FROM zawodnicy");
      foreach ($get_rows as $zawodnik)
      {
        echo "<tr>";
        echo "<th scope='row'>{$zawodnik['id']}</th>";
        echo "<td>{$zawodnik['nazwa']}</td>";
        echo "<td>{$zawodnik['punkty']}</td>";
        echo "<td>{$zawodnik['ile_meczy']}</td>";
        echo "</tr>";
      }
      $db->Disconnect();
    }

    public static function zapiszPunkty($ile_pkt, $id_zawodnika)
    {
      $db = new DBConn();

      $zawodnik = $db->getRow("SELECT punkty, ile_meczy FROM zawodnicy WHERE id = ?", [$id_zawodnika]);
      $punkty_zawodnika = $zawodnik['punkty'];
      $punkty_zawodnika += $ile_pkt;

      $ile_meczy = $zawodnik['ile_meczy'];
      $ile_meczy += 1;

      // ranikin = różnica zwycięstw nad porażkami
      $porazka = $ile_meczy - $punkty_zawodnika;
      $ranking = $punkty_zawodnika - $porazka;

      $rows = $db->updateRow("UPDATE zawodnicy SET punkty = ?, ile_meczy = ?, ranking = ? WHERE id = ?", [$punkty_zawodnika, $ile_meczy, $ranking, $id_zawodnika]);

      $db->Disconnect();
    }

    /**
     * Sortuje na podstawie różnicy zwycięstw nad porażkami
     */
    public static function pokazRankingZawodnikow()
    {
      $db = new DBConn();
      $get_rows = $db->getRows("SELECT * FROM zawodnicy ORDER BY ranking DESC");

      foreach ($get_rows as $zawodnik)
      {
        $ile_porazek = $zawodnik['ile_meczy'] - $zawodnik['punkty'];

        echo "<tr>";
        echo "<th scope='row'>{$zawodnik['id']}</th>";
        echo "<td>{$zawodnik['nazwa']}</td>";
        echo "<td>{$zawodnik['punkty']}</td>";
        echo "<td>{$ile_porazek}</td>";
        echo "<td>{$zawodnik['ranking']}</td>";
        echo "</tr>";
      }
      $db->Disconnect();
    }


  }
