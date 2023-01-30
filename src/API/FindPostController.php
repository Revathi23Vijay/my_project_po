<?php

declare(strict_types=1);

namespace App\API;

use App\Post\Application\Query\FindPostQuery;
use App\Shared\Domain\Bus\QueryBus;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;



#[Route(path: '/posts/{post_id}', methods: ['GET'])]
class FindPostController
{
    public function __construct(
        private readonly QueryBus $queryBus
    ) {
    }

    public function __invoke(string $post_id)
    {
        try {
            $query = new FindPostQuery(
                id: $post_id,
            );
           $result = $this->queryBus->ask(
                query: $query,
            );
           if ($result == null) {
                return new JsonResponse(
                [],
                Response::HTTP_NOT_FOUND,
                );
           }
        } catch (Exception $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }

        return new JsonResponse(
            
                $result,
            
            Response::HTTP_OK,
        );
    }
}
