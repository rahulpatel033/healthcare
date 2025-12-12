<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;

class UserRepository {
    
    /**
     * It accepts the dto and create a user
     * 
     * @param UserDTO $dto
     * 
     * @return User user details
     */
    public function create(UserDTO $data): User
    {
        return User::create([
            "name" => $data->name,
            "email" => $data->email,
            "password" => $data->password,
        ]);
    }

    /**
     * It accepts email and find user by it
     * 
     * @param string $email
     * 
     * @return User | null 
     */
    public function findByEmail(string $email): User
    {
        return User::where("email", $email)
            ->first();
    }
}