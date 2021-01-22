<?php

namespace App\Resolver;

use App\Repository\UserRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;


final class UserResolver implements ResolverInterface, AliasedInterface
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
    public function resolve(int $id)
    {
        
        return $this->userRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'User',
        ];
    }
}