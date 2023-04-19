<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Exception;

class UsersController extends Controller
{
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User();
    }

    public function index(): false|array
    {
        return $this->users->findAll();
    }

    /**
     * @throws Exception
     */
    public function store($data): array
    {
        $username = $data['username'];
        if ($username === '') {
            $this->response->internalServerError('Username cannot be empty');
        }
        return $this->users->create($data);
    }

    public function show(string $id): false|array
    {
        return $this->users->findById($id);
    }

    public function update($data): array
    {
        return $this->users->update($data);
    }

    public function delete(string $id): array
    {
        return $this->users->deleteById($id);
    }

    /**
     * @throws Exception
     */
    public  function login(array $payload): array
    {
        $data = $payload['data'];
        $username = $data['username'];
        $password = $data['password'];
        if ($username === '' || $password === '') {
            return $this->response->internalServerError('Username or password cannot be empty');
        }

        $user = $this->users->findAllBy('username', $username)[0];
        if (empty($user) or !password_verify($password, $user['password'])) {
            return $this->response->internalServerError('Username or password is incorrect');
        }

        return $this->response->ok('Login successful');
    }

    /**
     * @throws Exception
     */
    public function register(array $payload): array
    {
        $data = $payload['data'];
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];

        $emailExist = $this->users->findAllBy('email', $email);
        $usernameExist = $this->users->findAllBy('username', $username);

        // Username Match
        if(!preg_match('/^[a-z0-9_-]{3,15}$/', $username) OR $usernameExist)
        {
            return $this->response->internalServerError('Something went wrong with username.');
        }

        // Email Match
        if(!preg_match('/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,6})+$/', $email) OR $emailExist)
        {
            return $this->response->internalServerError('Something went wrong with email.');
        }

        // Password Match
        if(!preg_match('/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#%@\?\*\.\-]*[!#%$@\?\*\.\-])[A-Za-z0-9!#%@$\?\*\.\-]{8,65}$/', $password))
        {
            return $this->response->internalServerError('Something went wrong with password.');
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $data['password'] = $password;

        return $this->users->create($data);
    }
}