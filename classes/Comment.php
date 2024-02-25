<?php
/**
 * @var $pdo
 */
class Comment
{

  public static $table = "comments";



  public static function insert(array $data)
  {
    // data is columns
    DB::insert(self::$table, $data);
  }

  public static function selectWithUser($post_id): array
  {
    // $keys = array_keys($columns);
    // $placeHolder = array_map(fn(string $key) => "$key=:$key", $keys);

    $stmt = DB::$pdo->prepare("
        SELECT comments.comment_id , accounts.id AS 'commenter_id',accounts.name AS 'commenter_name' ,comments.TEXT AS 'comment_text',comments.img AS 'comment_img' , comments.DATE
        FROM comments
        JOIN accounts ON comments.commenter_id = accounts.id
        WHERE post_id=$post_id
        ORDER BY comments.DATE;
    ");

    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_DEFAULT);
    return $comments;

  }

  public static function selectNumOfCommentsFor($postId): int
  {
    $placeHolder = array_map(fn($key) => "$key=:$key", array_keys($postId));
    $stmt = DB::$pdo->prepare("
        SELECT COUNT(*) FROM " . self::$table . "
        WHERE " . implode(" AND ", $placeHolder) . "
    ");
    $stmt->execute($postId);
    return (int) $stmt->fetchColumn();
  }

  public static function selectLikers($comment_id): array
  {
    $placeHolders = array_map(fn($key) => "$key=:$key", array_keys($comment_id));
    $stmt = DB::$pdo->prepare("
    SELECT  liker_id,post_id FROM " . self::$table . "
    WHERE " . implode(" AND ", $placeHolders) . "
");
    $stmt->execute($comment_id);

    // Fetch all liker_id values directly
    $likers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    return $likers;

  }

  public static function deleteCommentWith($postId){
    $stmt = DB::$pdo->prepare("
    DELETE  FROM comments
    WHERE post_id=$postId
    ");
    $stmt->execute();
  }

}