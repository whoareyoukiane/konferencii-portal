<?php

// общий предок: показ страницы, переходы, всплывающие сообщения
abstract class Controller
{
    protected function render(string $view, array $data = [], int $code = 200): void
    {
        http_response_code($code);
        $user = Auth::user();
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        extract($data);
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    protected function redirect(string $url, ?string $message = null): void
    {
        if ($message) {
            $_SESSION['flash'] = $message;
        }
        header('Location: ' . $url);
        exit;
    }

    protected function requireLogin(): array
    {
        $user = Auth::user();
        if ($user === null) {
            $this->redirect('/login', 'Сначала войдите в аккаунт');
        }
        return $user;
    }

    protected function requireAdmin(): array
    {
        $user = $this->requireLogin();
        if ($user['role'] !== 'admin') {
            $this->render('403', [], 403);
            exit;
        }
        return $user;
    }
}
