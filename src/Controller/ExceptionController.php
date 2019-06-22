<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExceptionController
{
    /**
     * @param Request $request
     * @param \Throwable $exception
     * @return JsonResponse
     */
    public function showAction(Request $request, \Throwable $exception)
    {
        return new JsonResponse(['error' => $exception->getMessage()]);
    }
}
