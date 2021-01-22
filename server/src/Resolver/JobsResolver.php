<?php

namespace App\Resolver;

use App\Repository\JobRepository;
use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;


final class JobsResolver implements ResolverInterface, AliasedInterface
{
    /**
     * @var JobRepository
     */
    private $jobRepository;

    /**
     *
     * @param JobRepository $jobRepository
     */
    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * @return \App\Entity\Job
     */
    public function resolve()
    {
        return $this->jobRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            'resolve' => 'Jobs',
        ];
    }
}