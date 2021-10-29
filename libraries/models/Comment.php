
<?php
require_once('libraries/database.php');
class Comment
{

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
   * Retourne un commentaire de la base de données grâce à son indentifiant
   * 
   * @param integer $id
   * @return array|bool le commentaire si on le truve, false si on ne le trouve pas 
   * 
   */

  public function find(int $id)
  {
    $pdo  = getPdo();

    $query = $pdo->prepare("SELECT * FROM comments WHERE id = :id");

    $query->execute(['id' => $id]);

    $comment = $query->fetch();

    return $comment;
  }
  /**
   *  Suprime un commentaire grâce à son identifient
   * @param integer $id
   * @return void
   */

  public function delete(int $id): void
  {
    $pdo = getPdo();
    $query = $pdo->prepare("DELETE FROM comments WHERE id = :id");
    $query->execute(['id' => $id]);
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
