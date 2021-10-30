<?php

spl_autoload_register(function ($className) {
  // className = Controller/Article
  // require = libraires/controllers/Article.php
  $className = str_replace('\\', '/', $className);
  require_once("libraries/$className.php");
  var_dump($className);
});
