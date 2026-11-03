<?php
// единая точка входа: все адреса приходят сюда

spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . $class . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require __DIR__ . '/../src/helpers.php';

Auth::start();

$method = $_SERVER['REQUEST_METHOD'];
$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';

$routes = [
    'GET /' => ['PageController', 'home'],
    'GET /events' => ['PageController', 'events'],
    'GET /register' => ['AuthController', 'registerForm'],
    'POST /register' => ['AuthController', 'register'],
    'GET /login' => ['AuthController', 'loginForm'],
    'POST /login' => ['AuthController', 'login'],
    'POST /logout' => ['AuthController', 'logout'],
    'GET /requests' => ['RequestController', 'mine'],
    'GET /requests/new' => ['RequestController', 'form'],
    'POST /requests' => ['RequestController', 'create'],
    'GET /admin' => ['AdminController', 'index'],
];

$args = [];
if (isset($routes["$method $path"])) {
    [$class, $action] = $routes["$method $path"];
} elseif ($method === 'POST' && preg_match('#^/admin/requests/(\d+)/status$#', $path, $m)) {
    [$class, $action, $args] = ['AdminController', 'setStatus', [(int) $m[1]]];
} elseif ($method === 'POST' && preg_match('#^/admin/requests/(\d+)/delete$#', $path, $m)) {
    [$class, $action, $args] = ['AdminController', 'delete', [(int) $m[1]]];
} else {
    [$class, $action] = ['PageController', 'notFound'];
}

(new $class())->$action(...$args);
