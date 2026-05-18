<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class AuthController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function loginForm()
    {
        if (isLoggedIn()) {
            redirect('/');
        }

        loadView('auth/login', ['pageTitle' => 'Login — RightJob', 'errors' => []]);
    }

    public function login()
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if (!Validation::email($email)) {
            $errors['email'] = 'A valid email is required.';
        }

        if (!Validation::string($password, 6)) {
            $errors['password'] = 'Password must be at least 6 characters.';
        }

        if (!empty($errors)) {
            loadView('auth/login', [
                'pageTitle' => 'Login — RightJob',
                'errors' => $errors,
                'email' => $email,
            ]);
            return;
        }

        $user = $this->db->query(
            'SELECT * FROM users WHERE email = :email',
            ['email' => $email]
        )->fetch();

        if (!$user || !password_verify($password, $user->password)) {
            loadView('auth/login', [
                'pageTitle' => 'Login — RightJob',
                'errors' => ['auth' => 'Invalid email or password.'],
                'email' => $email,
            ]);
            return;
        }

        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];

        setFlash('success_message', 'Welcome back, ' . $user->name . '!');
        redirect('/');
    }

    public function registerForm()
    {
        if (isLoggedIn()) {
            redirect('/');
        }

        loadView('auth/register', ['pageTitle' => 'Register — RightJob', 'errors' => []]);
    }

    public function register()
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirm'] ?? '';
        $role = $_POST['role'] ?? 'user';

        $errors = [];

        if (!Validation::string($name, 2, 100)) {
            $errors['name'] = 'Name is required (2–100 characters).';
        }

        if (!Validation::email($email)) {
            $errors['email'] = 'A valid email is required.';
        }

        if (!Validation::string($password, 6)) {
            $errors['password'] = 'Password must be at least 6 characters.';
        }

        if (!Validation::match($password, $confirm)) {
            $errors['password_confirm'] = 'Passwords do not match.';
        }

        if (!in_array($role, ['user', 'employer'], true)) {
            $role = 'user';
        }

        $existing = $this->db->query(
            'SELECT id FROM users WHERE email = :email',
            ['email' => $email]
        )->fetch();

        if ($existing) {
            $errors['email'] = 'An account with this email already exists.';
        }

        if (!empty($errors)) {
            loadView('auth/register', [
                'pageTitle' => 'Register — RightJob',
                'errors' => $errors,
                'name' => $name,
                'email' => $email,
                'role' => $role,
            ]);
            return;
        }

        $this->db->query(
            'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)',
            [
                'name' => sanitize($name),
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => $role,
            ]
        );

        $userId = $this->db->conn->lastInsertId();

        $_SESSION['user'] = [
            'id' => (int) $userId,
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ];

        setFlash('success_message', 'Account created successfully. Welcome to RightJob!');
        redirect('/');
    }

    public function logout()
    {
        unset($_SESSION['user']);
        setFlash('success_message', 'You have been logged out.');
        redirect('/');
    }
}
