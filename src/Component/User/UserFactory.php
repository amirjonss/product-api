<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class UserFactory.
 *
 * UserFactory
 */
readonly class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function create(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        return $user;
    }
}
