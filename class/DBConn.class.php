<?php

  class DBConn
  {
      public $is_conn;
      protected $datab;

      public function __construct($username = "root", $password = "", $host = "localhost", $db_name = "pixlab", $options = [])
      {
        $this->is_conn = true;
        try
        {
          $this->datab = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8", $username, $password, $options);
          $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
          throw new Exception($e->getMessage());

        }
      }

      public function Disconnect()
      {
        $this->is_conn = false;
        $this->datab = null;
      }

      public function getRow($query, $params = [])
      {
        try
        {
          $stmt = $this->datab->prepare($query);
          $stmt->execute($params);
          return $stmt->fetch();
        }
        catch (Exception $e)
        {
          throw new Exception($e->getMessage());
        }
      }

      public function getRows($query, $params = [])
      {
        try
        {
          $stmt = $this->datab->prepare($query);
          $stmt->execute($params);
          return $stmt->fetchAll();
        }
        catch (Exception $e)
        {
          throw new Exception($e->getMessage());
        }
      }

      public function insertRow($query, $params = [])
      {
        try
        {
          $stmt = $this->datab->prepare($query);
          $stmt->execute($params);
          return true;
        }
        catch (Exception $e)
        {
          throw new Exception($e->getMessage());
        }
      }

      public function updateRow($query, $params = [])
      {
        $this->insertRow($query, $params);
      }

      public function deletetRow($query, $params = [])
      {
        $this->insertRow($query, $params);
      }
  }
