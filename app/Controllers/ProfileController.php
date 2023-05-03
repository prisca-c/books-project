<?php

namespace App\Controllers;

use App\Models\User;
use Core\Auth;
use Core\Controller;

class ProfileController extends Controller
{
    private User $users;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User();
    }

    /**
     * @throws \Exception
     */
    public function updatePassword(array $data): array
    {
        $password = $data['data']['password'];
        $cookie = $_COOKIE['cookie-session'];

        if (!Auth::verifyToken($cookie))
        {
            return $this->response->unauthorized();
        }

        $token = Auth::decodeToken($cookie);
        $userId = $token['id'];
        $user = $this->users->findById($userId);

        if(!preg_match('/^(?=[^a-z]*[a-z])(?=[^A-Z]*[A-Z])(?=\D*\d)(?=[^!#%@\?\*\.\-]*[!#%$@\?\*\.\-])[A-Za-z0-9!#%@$\?\*\.\-]{8,65}$/', $password))
        {
            return $this->response->unauthorized('Something went wrong with password.');
        }

        $user['password'] = password_hash($password, PASSWORD_DEFAULT);
        $this->users->update($user);
        return $this->response->ok('Password updated');
    }

    /**
     * @throws \Exception
     */
    public function updateDetails(array $data): array
    {
        $username = $data["data"]["username"];
        $email = $data["data"]["email"];
        $cookie = $_COOKIE[ 'cookie-session'];

        if (!Auth::verifyToken($cookie))
        {
            return $this->response->unauthorized();
        }

        $token = Auth::decodeToken($cookie);
        $userId = $token['id'];
        $user = $this->users->findById($userId);
        $emailExist = false;
        $usernameExist = false;

        if($user['email'] !== $email) {
            $emailExist = $this->users->findAllBy('email', $email);
            $emailExist ? $emailExist = true : $emailExist = false;
        }

        if($user['username'] !== $username) {
            $usernameExist = $this->users->findAllBy('username', $username);
            $usernameExist ? $usernameExist = true : $usernameExist = false;
        }

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

        $user['email'] = $email;
        $user['username'] = $username;
        $this->users->update($user);
        return $this->response->ok('Details updated');
    }

//    public function __invoke(): void
//    {
//        echo 'Test Invoke';
//    }
}