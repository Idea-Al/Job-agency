<?php

namespace App\Resolver;

use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;


final class UsersResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \App\Entity\User
     */
    public function resolve()
    {
        return $this->userRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Users',
        ];
    }
}