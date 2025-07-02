<?php

class AuthController extends Controller
{
    private UserRepository $users;
    public function __construct()
    {
        $this->users = new UserRepository();
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Login-Form anzeigen
    public function showLogin(): void
    {
        include __DIR__ . '/../../Views/login.php';
    }

    // Login-Form verarbeiten
    public function login(): void
    {
        $u = $_POST['username'] ?? '';
        $p = $_POST['password'] ?? '';
        $user = $this->users->findByUsername($u);
        if ($user && password_verify($p, $user->getPasswordHash())) {
            // korrekt
            $_SESSION['user_id']   = $user->getId();
            $_SESSION['username']  = $user->getUsername();
            $_SESSION['role']      = $user->getRole();
            header('Location: /'); exit;
        }
        $error = 'Ungültige Anmeldedaten';
        include __DIR__ . '/../../Views/login.php';
    }

    // Logout
    public function logout(): void
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login'); exit;
    }

    // Hilfs-Methode: aktuell eingeloggter User
    public static function user(): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return $_SESSION['user_id'] 
            ? ['id'=>$_SESSION['user_id'], 'username'=>$_SESSION['username'], 'role'=>$_SESSION['role']]
            : null;
    }
}
