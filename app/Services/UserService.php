<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\DTO\UserDTO;
use App\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Hash;


class UserService {

    /**
     * Create a new user service instance.
     *
     * @param UserRepository $repo
     */
    public function __construct(private UserRepository $repo)
    {
    }

    /**
     * register new user
     * 
     * This function hash user's password, prepare DTO and register via repository.
     * 
     * @param UserDTO $dto
     * @return mixed The created user instance
     */
    public function register(UserDTO $dto)
    {
        $dto->password = Hash::make($dto->password);
        return $this->repo->create($dto);
    }

    /**
     * Login user
     * 
     * This function validates user's credentials and login valid user
     * It returns user object and snctrum token
     * If credntials are invalid it will throw an exceptions
     * 
     * @param string $email
     * @param string $password
     * 
     * @return array{
     *      user: App\Models\User,
     *      token: string
     * }
     * 
     * @throws InvalidCredentialsException
     */
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
