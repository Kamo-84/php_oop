
<?php
function render(string $path, array $variables = [])
{
  extract($variables); // extract methode will extrat varables from associative array creating varible name same as  keys for exemple "color" => "green" ; $collor = "green"  
  ob_start();
  require('templates/' . $path . '.html.php');
  $pageContent = ob_get_clean();

  require('templates/layout.html.php');
}


function redirect(string $url): void
{
  header('Location:' . $url);
  exit();
}
