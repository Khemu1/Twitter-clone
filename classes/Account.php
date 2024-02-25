<?php
/**
 * @var $pdo
 */
require_once("/laragon/www/twitter/classes/DB.php");
class Account
{
  public static $table = "accounts";
  public static $columns = ["id", "name", "pass"];



  public static function select(array $columns = null, array $condition = null)
  {
    return DB::select(self::$table, $columns ?? ["*"], $condition ?? []);
  }
  public static function insert($data): bool
  {
    return DB::insert(self::$table, $data);
  }
  public static function returnNameUsing($id): bool
  {
    $stmt = DB::$pdo->prepare("
    
    SELECT name from " . self::$table . "
    
    WHERE id=$id

    ");
    return $stmt->execute();
  }
}