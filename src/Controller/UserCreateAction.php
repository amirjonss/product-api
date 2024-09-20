<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\Exception\ValidationException;
use ApiPlatform\Validator\ValidatorInterface;
use App\Component\User\UserFactory;
use App\Component\User\UserManager;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class UserCreateAction
 *
 * UserCreateAction
 *
 * @package App\Controller
 */
class UserCreateAction extends AbstractController
{
    public function __construct(
        private UserFactory $userFactory,
        private UserManager $userManager,
        private ValidatorInterface $validator
    ) {
    }

    public function __invoke(User $data, UserRepository $userRepository): User
    {
        $this->validator->validate($data);
        $this->validate($data->getEmail(), userRepository: $userRepository);
        $user = $this->userFactory->create($data->getEmail(), $data->getPassword());
        $this->userManager->save($user, true);

        return $user;
    }

    protected function validate(string $email, ?UserRepository $userRepository = null): void
    {
        if ($userRepository && $userRepository->findOneBy(['email' => $email])) {
            throw new ValidationException(
                new ConstraintViolationList(
                    [
                        new ConstraintViolation(
                            message: 'This email is already used',
                            messageTemplate: '',
                            parameters: [],
                            root: [],
                            propertyPath: '',
                            invalidValue: $email,
                            code: '422'
                        )
                    ]
                )
            );
        }
    }
}
