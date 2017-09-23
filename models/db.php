<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:59
 */

class Connection {

      private static $_db = NULL;
	  
	  private static $config = Array(
            'host'=>'localhost',
            'user'=>'id2895241_kholmatov',
            'password'=>'nlcBf7pg',
            'dbname'=>'id2895241_kholmatov_db',
      );

      public function __construct() {
          return $this->connectPDO();
      }

      private function __clone() {}

      public static function connectPDO() {
          if (!isset(self::$_db)) {
              $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
              self::$_db = new PDO('mysql:host='.self::$config['host'].';dbname='.self::$config['dbname'], self::$config['user'], self::$config['password'], $pdo_options);
          }
          return self::$_db;
      }

      public static function closePDO(){
          return self::$_db = NULL;
      }

      public function queryAll($sql){
            $stmt = self::$_db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }

      public function queryRow($sql){
          $stmt = self::$_db->query($sql);
          return $stmt->fetch(PDO::FETCH_ASSOC);
      }

      public function queryTotal($sql){
          $stmt = self::$_db->query($sql);
          return $stmt->rowCount();
      }

      public function insert($table, $ins_array){
          $column_name = implode(', ', array_keys($ins_array));
          $column_atre = implode(', ' , array_map('Connection::add_dote', array_keys($ins_array)));
          $stmt = self::$_db->prepare("INSERT INTO $table ($column_name) VALUES ($column_atre)");
          foreach($ins_array as $key => &$value) $stmt->bindParam(':'.$key, $value);
          $stmt->execute();
          return self::$_db->lastInsertId();
      }

      public function delete($sql){
          return self::$_db->exec($sql);
      }
      public function update($sql){
          $stmt = self::$_db->prepare($sql);
         return $stmt->execute();
      }

      public function add_dote($str){
          return ':'.$str;
      }

  }
?>