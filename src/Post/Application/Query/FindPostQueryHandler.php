<?php

declare(strict_types=1);

namespace App\Post\Application\Query;
use Symfony\Component\Uid\Uuid;

use App\Post\Domain\PostRepository;
use App\Shared\Domain\Bus\QueryHandler;
use App\Shared\Domain\Bus\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FindPostQueryHandler implements QueryHandler
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(FindPostQuery $query)
    {
        $resultArr = '';
        $Uuid = Uuid::fromString(
                $query->id,
        );
        $resultArr = $this->repository->find($Uuid);
        if($resultArr){
            $resultArr = [ 
                "post_id" => $query->id,
                "title" => $resultArr->getTitle(),
                "summary" => $resultArr->getSummary(),
            ];
        }
        
        return $resultArr;
    }
}
