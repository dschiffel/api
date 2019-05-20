<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionController
{
    public function showAction()
    {
        return new JsonResponse(['error' => null]);
    }
}
