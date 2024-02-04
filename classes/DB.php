<?php

class DB
{
  private static $server = "localhost";
  private static $user = "root";
  private static $password = "";

  private static $database = "users";
  public static PDO $pdo;
  public static function init()
  {
    try {
      self::$pdo = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$database, self::$user, self::$password);
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (Throwable $th) {
      echo $th->getMessage();
    }
  }

  public static function select($table, array $columns, array $condition = []): array
  {
    if (count($condition) > 0) {
      $keys = array_keys($condition);
      $placeHolders = array_map(fn(string $key) => "$key = :$key", $keys);

      $stmt = self::$pdo->prepare("SELECT " . implode(", ", $columns) . " FROM $table
            WHERE " . implode(" AND ", $placeHolders));


      if ($stmt->execute($condition)) {
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      }
      return [];
    } else {
      $stmt = self::$pdo->prepare("SELECT " . implode(", ", $columns) . " FROM $table");
      if ($stmt->execute()) {
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      }
      return [];
    }
  }


  public static function insert(string $table, array $data): bool
  {
    $keys = array_keys($data);
    $placeHolders = array_map(fn(string $key) => ":$key", $keys);

    $stmt = self::$pdo->prepare("
    INSERT INTO $table (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $placeHolders) . ")
    ");
    return $stmt->execute($data);
  }
}