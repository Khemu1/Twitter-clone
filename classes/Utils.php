<?php
include_once("Post.php");
include_once("Like.php");
include_once("Comment.php");
include_once("Followable.php");


class Utils
{

  public static function postTweet(array $data)
  {


    Post::insert(
      $data
    );

  }
  public static function insertComment($commenter_id, $post_id, $text, $img)
  {


    Comment::insert(
      [

        "commenter_id" => $commenter_id,
        "post_id" => $post_id,
        "text" => $text,
        "img" => $img
      ]
    );

  }

  public static function selectAllPosts(): array
  {
    return Post::selectAllPosts(

    );
  }
  public static function selectPost($post_id): array
  {
    return Post::selectPost(
      $post_id
    );
  }
  public static function selectComments($post_id): array
  {
    return Comment::selectWithUser(
      $post_id

    );
  }

  public static function like($post_id, $poster_id, $liker_id)
  {
    Like::insertOrDelete([
      "post_id" => $post_id,
      "user_id" => $poster_id,
      "liker_id" => $liker_id
    ]);

  }
  public static function returnLikes($postId): int
  {
    return Like::selectPostLikes(["post_id" => $postId]);
  }
  public static function returnLiker($liker_id, $post_id): array
  {
    return Like::selectLikers([
      "liker_id" => $liker_id,
      "post_id" => $post_id
    ]);
  }

  public static function print()
  {

  }

  public static function is_liker($liker_id, $post_id): bool
  {
    $likers = self::returnLiker($liker_id, $post_id);
    return count($likers) > 0;
  }

  public static function comments_num($post_id): int
  {
    $comments = Comment::selectNumOfCommentsFor(["post_id" => $post_id]);
    return $comments;
  }

  public static function follow($followable_id, $poster_id)
  {
    Followable::insertOrDelete(["followable_id" => $followable_id, "follower_id" => $poster_id]);
  }
  public static function is_follower($followable_id, $follower_id)
  {
    return count(Followable::select(["followable_id" => $followable_id, "follower_id" => $follower_id])) > 0;
  }
}