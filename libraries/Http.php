<?php

class Http
{

  /**
   * Redirige la visieur ver $url 
   * 
   * @param string $urm
   * @return void
   */

  public static function redirect(string $url): void
  {
    header('Location:' . $url);
    exit();
  }
}
