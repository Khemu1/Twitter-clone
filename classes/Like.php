<?php
/**
 * @var $pdo
 */
class Like
{

  public static $table = "likes";

  public static $columns = ["id", "post_id", "user_id", "liker_id", "DATE"];

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


  public static function select(array $columns, $condition)
  {
    DB::select(self::$table, $columns ?? self::$columns, $condition ?? []);
  }


  public static function selectPostLikes($postId): int
  {
    $placeHolder = array_map(fn($key) => "$key=:$key", array_keys($postId));
    $stmt = DB::$pdo->prepare("
        SELECT COUNT(*) FROM " . self::$table . "
        WHERE " . implode(" AND ", $placeHolder) . "
    ");
    $stmt->execute($postId);
    return (int) $stmt->fetchColumn();
  }

  public static function selectLikers($id): array
  {
    $placeHolders = array_map(fn($key) => "$key=:$key", array_keys($id));
    $stmt = DB::$pdo->prepare("
    SELECT  liker_id,post_id FROM " . self::$table . "
    WHERE " . implode(" AND ", $placeHolders) . "
");
    $stmt->execute($id);

    // Fetch all liker_id values directly
    $likers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $likers;

  }

}