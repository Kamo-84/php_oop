
<?php
require_once('libraries/database.php');
class Article
{
  /**
   * Retourne la liste des articles classée par date de création
   * @return array
   */
  public function findAll(): array
  {
    $pdo = getPdo();
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
    // On fouille le résultat pour en extraire les données réelles
    $articles = $resultats->fetchAll();
    return $articles;
  }

  /**
   * Retourne un article grâce à son identifiant
   * 
   * @param integer $id 
   * @return void 
   */


  public function find(int $id)
  {

    $pdo = getPdo();

    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

    // On exécute la requête en précisant le paramètre :article_id 
    $query->execute(['article_id' => $id]);

    // On fouille le résultat pour en extraire les données réelles de l'article
    $article = $query->fetch();


    return $article;
  }


  /**
   *  Supprime un article dans la base grâce à son indentifiant pour
   * @param integer $id 
   * @return void
   */

  public function delete(int $id): void
  {

    $pdo = getPdo();

    $query = $pdo->prepare("DELETE FROM articles WHERE id = :id");
    $query->execute(['id' => $id]);
  }
}
