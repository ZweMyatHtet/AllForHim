<?php
  $host = "127.0.0.1";
  $user = "root";
  $password = "";
  $db="AllForHim";

  $dsn = "mysql:host=$host; dbname=$db;";

  try{
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   // echo "connected";
  }catch(PDOException $e)
  {
    echo $e->getMessage();
  }



?>