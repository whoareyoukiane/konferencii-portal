<?php

class AuthController extends Controller
{
    public function registerForm(): void
    {
        $this->render('register', ['errors' => [], 'old' => []]);
    }

    public function register(): void
    {
        $login = trim($_POST['login'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = array_filter([
            'login' => Validator::login($login),
            'email' => Validator::email($email),
            'phone' => Validator::phone($phone),
            'password' => Validator::password($password),
        ]);

        $users = new UserRepository();
        if (!isset($errors['login']) && $users->findByLogin($login)) {
            $errors['login'] = 'Такой логин уже занят';
        }

        if ($errors) {
            $old = ['login' => $login, 'email' => $email, 'phone' => $phone];
            $this->render('register', ['errors' => $errors, 'old' => $old], 422);
            return;
        }

        $id = $users->create($login, $password, $email, Validator::normalizePhone($phone));
        Auth::login($users->findById($id));
        $this->redirect('/requests', 'Вы зарегистрировались');
    }

    public function loginForm(): void
    {
        $this->render('login', ['error' => null, 'old' => []]);
    }

    public function login(): void
    {
        $login = trim($_POST['login'] ?? '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        if (LoginThrottle::blocked($ip, $login)) {
            $this->render('login', ['error' => 'Слишком много неудачных попыток. Попробуйте через 10 минут', 'old' => ['login' => $login]], 429);
            return;
        }

        $user = (new UserRepository())->findByLogin($login);
        if ($user === null || !password_verify($_POST['password'] ?? '', $user['password_hash'])) {
            LoginThrottle::fail($ip, $login);
            $this->render('login', ['error' => 'Неверный логин или пароль', 'old' => ['login' => $login]], 401);
            return;
        }
        LoginThrottle::clear($ip, $login);
        Auth::login($user);
        $this->redirect($user['role'] === 'admin' ? '/admin' : '/requests');
    }

    public function logout(): void
    {
        Auth::logout();
        Auth::start();
        $this->redirect('/', 'Вы вышли из аккаунта');
    }
}
