<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;

class UserRepository {
    
    public function create(UserDTO $data): User
    {
        return User::create([
            "name" => $data->name,
            "email" => $data->email,
            "password" => $data->password,
        ]);
    }

    public function findByEmail(string $email): User
    {
        return User::where("email", $email)
            ->first();
    }
}