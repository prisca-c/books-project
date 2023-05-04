<?php

namespace App\Controllers;

use App\Models\User;
use Core\Auth;
use Core\Cache;
use Core\Database\QueryMethods;
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

        $user = $this->users->findByOne('username', $username);
        $userId = (string)$user->_id;
        if (empty($user) or !password_verify($password, $user['password'])) {
            return $this->response->internalServerError('Username or password is incorrect');
        }

        $JWT = Auth::generateToken($userId);
        setcookie('cookie-session', $JWT, time() + 86400, '/', '', true, true);
        setcookie('user-id', $userId, time() + 86400, '/', '', true, false);

        return $this->response->ok('Login Successful');
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
        $userId = $result->getInsertedId();

        $JWT = Auth::generateToken($userId);
        setcookie('cookie-session', $JWT, time() + 86400, '/', '', true, true);
        setcookie('user-id', $userId, time() + 86400, '/', '', true, false);

        return $this->response->created('Created');
    }

    public function logout (string $id): array
    {
        $cookie = ['name'=>'cookie-session','value'=>'', 'max-age'=>'0'];
        setcookie('cookie-session', '', time() - 86400, '/', '', true, true);
        if(Cache::redis()->get('auth:users:' . $id) !== null){
            Cache::redis()->del('auth:users:' . $id);
        }
        return $this->response->ok('Logout Successful');
    }

    public function checkSession (): bool
    {
        $JWT = ($_COOKIE['cookie-session'] ?? false);
        if(!$JWT){
            setcookie('cookie-session', '', time() - 86400, '/', '', true, true);
            setcookie('user-id', '', time() - 86400, '/', '', true, false);
            return false;
        }

        $tokenCheck = Auth::verifyToken($JWT);
        if(!$tokenCheck){
            setcookie('cookie-session', '', time() - 86400, '/', '', true, true);
            setcookie('user-id', '', time() - 86400, '/', '', true, false);
            return false;
        }

        $token = Auth::decodeToken($JWT);
        $userId = $token['id'];
        setcookie('user-id', $userId, time() + 86400, '/', '', true, false);
        return true;
    }
}
