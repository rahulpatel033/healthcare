<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\DTO\UserDTO;
use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;


class UserService {

    public function __construct(private UserRepository $repo)
    {
    }

    public function register(UserDTO $dto)
    {
        $dto->password = Hash::make($dto->password);
        return $this->repo->create($dto);
    }

    public function login(string $email, string $password)
    {
        $user = $this->repo->findByEmail($email);

        if(empty($user) || !Hash::check($password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        return [
            'user'  => $user,
            'token' => $user->createToken('auth')->plainTextToken,
        ];
    }
}
