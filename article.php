<?php


require_once('libraries/database.php');
require_once('libraries/utils.php');
require_once('libraries/models/Article.php');
require_once('libraries/models/Comment.php');
/**
 * 1. Récupération du param "id" et vérification de celui-ci
 */
// On part du principe qu'on ne possède pas de param "id"
$articleModel = new Article();
$commentModel = new Comment();

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
$pdo = getPdo();

/**
 * 3. Récupération de l'article en question
 * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur : Ne faites
 * jamais confiance à ce connard d'utilisateur ! :D
 */
$article = $articleModel->find($article_id);

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

render(
    'articles/show',
    //[ "article" => $article,
    // "commentaires" => $commentaires,
    // 'article_id' => $article_id]

    compact('article', 'commentaires', 'article_id', 'pageTitle') // compact() methode permet de créér un tableau assiciatif à partir du nom des variables

);
