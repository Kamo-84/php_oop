<?php

namespace Controllers;




class Article extends Controller
{
  protected $modelName = \Models\Article::class;

  public function index()
  {

    /**
     * 2. Récupération des articles
     */
    $articles = $this->model->findAll("created_at DESC");

    /**
     * 3. Affichage
     */
    $pageTitle = "Accueil";
    \Renderer::render('articles/index', compact('articles', 'pageTitle'));
  }

  public function show()
  {
    // Montre un article
    /**
     * 1. Récupération du param "id" et vérification de celui-ci
     */
    // On part du principe qu'on ne possède pas de param "id"

    $commentModel = new \Models\Comment();

    $article_id = null;

    // Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
    if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
      $article_id = $_GET['id'];
    }

    // On peut désormais décider : erreur ou pas ?!
    if (!$article_id) {
      die("Vous devez préciser un paramètre `id` dans l'URL !");
    }

    /**
     * 2. Connexion à la base de données avec PDO
     * Attention, on précise ici deux options :
     * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
     * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
     * 
     * PS : Vous remarquez que ce sont les mêmes lignes que pour l'index.php ?!
     */


    /**
     * 3. Récupération de l'article en question
     * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
     * jamais confiance à ce connard d'utilisateur ! :D
     */
    $article = $this->model->find($article_id);

    /**
     * 4. Récupération des commentaires de l'article en question
     * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
     */

    $commentaires = $commentModel->findAllWithArticle($article_id);
    /**
     * 5. On affiche 
     */
    $pageTitle = $article['title'];
    // ob_start();
    // require('templates/articles/show.html.php');
    // $pageContent = ob_get_clean();

    // require('templates/layout.html.php');

    \Renderer::render(
      'articles/show',
      //[ "article" => $article,
      // "commentaires" => $commentaires,
      // 'article_id' => $article_id]

      compact('article', 'commentaires', 'article_id', 'pageTitle') // compact() methode permet de créér un tableau assiciatif à partir du nom des variables

    );
  }

  public function delete()
  {
    // Supprimer un article



    /**
     * 1. On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
     */
    if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
      die("Ho ?! Tu n'as pas précisé l'id de l'article !");
    }

    $id = $_GET['id'];

    /**
     * 2. Connexion à la base de données avec PDO
     * Attention, on précise ici deux options :
     * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
     * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
     * 
     * PS : Vous remarquez que ce sont les mêmes lignes que pour l'index.php ?!
     */

    /**
     * 3. Vérification que l'article existe bel et bien
     */
    $article = $this->model->find($id);
    if (!$article) {
      die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
    }

    /**
     * 4. Réelle suppression de l'article
     */
    $this->model->delete($id);

    /**
     * 5. Redirection vers la page d'accueil
     */
    \Http::redirect('index.php');
  }
}
