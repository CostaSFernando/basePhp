<?php

use celebre\src\control\router\AcessoRouter;

include './src/autoload.php';

include_once 'vendor/autoload.php';

$config['displayErrorDetails'] = true;

$app = new \Slim\App(['settings' => $config]);

$app->add(new Tuupola\Middleware\CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    "headers.allow" => ["Content-type", "Authorization"],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0
]));

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => [], //End-points bloqueados com JWT
    "ignore" => [], // End-points ignorados pelo JWT
    "secret" => "telegram", // Senha para decodificar o JWT
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->getBody()->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));

$app->options('*', function ($request, $response) {
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200)
        ->withJson("ok");
});
/**
 * Função cria o JWT do usuario com o id.
 * Padrão do acesso local é fixo a principio
 */
$app->group('/usuario', AcessoRouter::class . ":groupAcesso");




$app->run();
