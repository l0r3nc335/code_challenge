<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerNotFoundException extends NotFoundHttpException
{
    public function __construct(string $message = "Customer not found")
    {
        parent::__construct($message);
    }
}