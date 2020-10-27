<?php

namespace celebre\src\control\router;

use celebre\src\control\controllers\AcessoController;
use Slim\App;

class AcessoRouter
{
  static public function groupAcesso(App $app)
  {
    $app->post('/autenticar/', AcessoController::class . ":createAcess");
  }
}
