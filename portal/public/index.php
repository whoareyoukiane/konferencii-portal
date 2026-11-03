<?php
// единая точка входа: все адреса приходят сюда

spl_autoload_register(function (string $class) {
    $file = __DIR__ . '/../src/' . $class . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require __DIR__ . '/../src/helpers.php';

header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; img-src 'self'; style-src 'self'; script-src 'self'; form-action 'self'");

Auth::start();

$method = $_SERVER['REQUEST_METHOD'];

// любой post без верного токена отклоняем
if ($method === 'POST' && !Csrf::valid()) {
    http_response_code(403);
    echo 'Форма устарела или отправлена с другого сайта. Вернитесь назад и повторите.';
    exit;
}
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
