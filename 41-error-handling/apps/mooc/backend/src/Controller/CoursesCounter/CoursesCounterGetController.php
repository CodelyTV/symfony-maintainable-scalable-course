<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\CoursesCounter;

use CodelyTv\Mooc\CoursesCounter\Application\Find\CoursesCounterResponse;
use CodelyTv\Mooc\CoursesCounter\Application\Find\FindCoursesCounterQuery;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterNotExist;
use CodelyTv\Shared\Domain\Bus\Query\QueryBus;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CoursesCounterGetController
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        try {
            /** @var CoursesCounterResponse $response */
            $response = $this->queryBus->ask(new FindCoursesCounterQuery());
            return new JsonResponse(
                [
                    'total' => $response->total(),
                ]
            );
        } catch (CoursesCounterNotExist $exception) {
            $code = Response::HTTP_NOT_FOUND;
            return new JsonResponse(
                [
                    'code'    => $code,
                    'message' => $exception->getMessage(),
                ],
                $code
            );
        } catch (InvalidArgumentException $exception) {
            $code = Response::HTTP_BAD_REQUEST;
            return new JsonResponse(
                [
                    'code'    => $code,
                    'message' => $exception->getMessage(),
                ],
                $code
            );
        } catch (Throwable $exception) {
            $code = Response::HTTP_INTERNAL_SERVER_ERROR;
            return new JsonResponse(
                [
                    'code'    => $code,
                    'message' => $exception->getMessage(),
                ],
                $code
            );
        }
    }
}
