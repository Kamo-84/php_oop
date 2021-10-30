<?php

class Renderer
{

  /**
   * Affiche un template HTML en injectant les $varible
   * 
   * @param string $path
   * @param array $varible
   * @return void
   * 
   */
  public static function render(string $path, array $variables = []): void
  {
    extract($variables); // extract methode will extrat varables from associative array creating varible name same as  keys for exemple "color" => "green" ; $collor = "green"  
    ob_start();
    require('templates/' . $path . '.html.php');
    $pageContent = ob_get_clean();

    require('templates/layout.html.php');
  }
}
