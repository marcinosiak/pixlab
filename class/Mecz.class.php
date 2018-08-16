<?php

require_once('dbconn.class.php');

class Mecz
{

  /**
   * Zapisuje wynik meczu w bazie
   * @param  int $gospodarze - wynik gospodarzy
   * @param  int $goscie     - wynik gości
   * @param  int $id_spotkania
   */
  public static function zapiszWynik($gospodarze, $goscie, $id_spotkania)
  {
    $db = new DBConn();

    $rows = $db->updateRow("UPDATE zawody SET wynik = ? WHERE id = ?", [$gospodarze.":".$goscie, $id_spotkania]);

    $db->Disconnect();
  }


}
