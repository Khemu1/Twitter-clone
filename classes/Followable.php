<?php

class Followable
{
  public static $table = "followable";
  public static $columns = ["followable_id", "follower_id"];

  /**
   * @var $pdo
   */
  public static function insertOrDelete(array $ids)
  {
    try {
      $placeHolders = array_map(fn($key) => "$key=:$key", array_keys($ids));
      $checkStmt = DB::$pdo->prepare("
            SELECT 1 FROM " . self::$table . "
            WHERE " . implode(" AND ", $placeHolders)
      );
      $checkStmt->execute($ids);
      $entryExists = $checkStmt->fetchColumn();

      if ($entryExists) {
        $deleteStmt = DB::$pdo->prepare("
                DELETE FROM " . self::$table . "
                WHERE " . implode(" AND ", $placeHolders)
        );
        $deleteStmt->execute($ids);
      } else {
        $insertStmt = DB::$pdo->prepare("
                INSERT INTO " . self::$table . " (" . implode(", ", array_keys($ids)) . ")
                VALUES (" . implode(", ", array_map(fn($key) => ":$key", array_keys($ids))) . ")
            ");
        $insertStmt->execute($ids);
      }

      return true;
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
      return false;
    }
  }

  public static function select(array $follower_id)
  {
    return DB::select(self::$table, self::$columns, $follower_id);

  }
}