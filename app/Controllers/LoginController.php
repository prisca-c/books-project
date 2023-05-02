<?php

namespace App\Controllers;

use App\Models\User;
use Core\Auth;
use Exception;

class LoginController extends \Core\Controller
{
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User();
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

        $token = Auth::generateToken($user['id']);

        return array_merge($this->response->ok('Login Successful'), ['token' => $token]);
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

        $result = $this->users->create($data);
        $user = $this->users->findBy('username', $username)[0];

        $JWT = Auth::generateToken($result->getInsertedId());
        $cookie = ['name'=>'cookie-session','value'=>$JWT, 'max-age'=>'86400'];

        return $this->response->created('Created', $cookie);
    }
}