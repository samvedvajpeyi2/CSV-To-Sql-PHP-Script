<?php
/*
Script to upload a CSV file and add its contents into database.
Created by: Samved Mohan Vajpeyi

===== Table name can be changed on line 15 =====
===== Database name can be changed on line 23 =====
===== DB User can be changed on line 24 =====
===== DB User Password can be changed on line 25 =====
===== No other change required on this page =====

*/


$tableName = 'sales';       // Database table name

class ConnectDB {

  /** Give a connection to DB, in UTF-8 */
  
  public static function getConnection() {
    
    $db = "demo";                   // Database Name
    $user = "demo_user";            // Database User
    $password = "demo_password";    // Database User Password
    
    // Get a DB connection with PDO library
    $dsn = "mysql:dbname=$db;host=localhost";
    $bdd = new PDO($dsn, $user, $password);
    $bdd->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec("SET character_set_client = 'utf8'");
    return $bdd;
  }
}
?>
