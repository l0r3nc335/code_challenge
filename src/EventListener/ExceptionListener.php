<?php

namespace App\EventListener;

use App\Exception\CustomerNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $response = $this->createJsonResponse($exception);
        $event->setResponse($response);
    }

    private function createJsonResponse(\Throwable $exception): JsonResponse
    {
        $statusCode = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $exception instanceof CustomerNotFoundException ? $exception->getMessage() : 'An error occurred';

        return new JsonResponse(['error' => $message], $statusCode);
    }
}