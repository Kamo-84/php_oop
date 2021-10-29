
<?php
require_once('libraries/models/Model.php');
class Comment extends Model
{

  protected $table = "comments";
  /**
   * Retourne la liste des commentaires d'un article donné
   * 
   * @param ingeger $article_id
   * @return array
   */

  public function findAllWithArticle(int $article_id): array
  {
    $pdo = getPdo();

    $query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");

    $query->execute(['article_id' => $article_id]);

    $commentaires = $query->fetchAll();


    return $commentaires;
  }


  /**
   * Insère un commentaire dans la base de données
   * 
   * @param string $author
   * @param string $content
   * @param ingeger $article_id
   * @return void
   */

  function  insert(string $author, string $content, int $article_id): void
  {
    $pdo = getPdo();

    $query = $pdo->prepare("INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()");

    // $query->execute(['author' => $author, 'content' => $content, 'article_id' => $article_id]);
    $query->execute(compact('author', 'content', 'article_id'));  //Avec methode compacte c'est plus compacte :D
  }
}
