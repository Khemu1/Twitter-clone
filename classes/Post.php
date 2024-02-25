<?php
class Post
{

  public static $table = "posts";

  public static $columns = ["userId", "text", "img"];

  public static function insert(array $data)
  {
    // data is columns
    DB::insert(self::$table, $data);
  }

  public static function select(array $columns, $condition)
  {
    DB::select(self::$table, $columns ?? self::$columns, $condition ?? []);
  }

  public static function selectAllPost(): array
  {
    // $keys = array_keys($columns);
    // $placeHolder = array_map(fn(string $key) => "$key=:$key", $keys);

    $stmt = DB::$pdo->prepare("
        SELECT posts.id AS'post_id',accounts.id AS 'poster_id',accounts.name,posts.text,posts.DATE,posts.img
          FROM  posts
          JOIN  accounts ON posts.userId=accounts.id
          order by posts.Date
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_DEFAULT);
  }

  public static function selectPost($post_id): array
  {
    // $keys = array_keys($columns);
    // $placeHolder = array_map(fn(string $key) => "$key=:$key", $keys);

    $stmt = DB::$pdo->prepare("
        SELECT posts.id AS'post_id',accounts.id AS 'poster_id',accounts.name AS 'poster_name' ,posts.text AS 'post_text' ,posts.img AS 'post_img',posts.DATE
          FROM  posts
          JOIN  accounts ON posts.userId=accounts.id
          where posts.id=$post_id
          order by posts.Date
    ");

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_DEFAULT);
  }
  public static function deleteposttWith($postId)
  {
    $stmt = DB::$pdo->prepare("
    DELETE FROM posts
    WHERE id=$postId
    ");
    $stmt->execute();
  }
}