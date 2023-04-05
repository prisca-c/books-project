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

    public function show($data): false|array
    {
        $id = $data['id'];
        return $this->users->findById($id);
    }

    public function update($data): array
    {
        return $this->users->update($data);
    }

    public function delete($data): array
    {
        $id = $data['id'];
        return $this->users->deleteById($id);
    }
}