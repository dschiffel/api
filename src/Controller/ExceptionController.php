<?php

namespace App\Controller;

use App\Exception\FormException;
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
        if ($exception instanceof FormException) {
            $message = 'Invalid form';
            $errors = $exception->getFormatterErrors();
        }

        $data = [];
        $data['message'] = $message ?? $exception->getMessage();
        if (isset($errors)) {
            $data['errors'] = $errors;
        }

        return new JsonResponse($data);
    }
}
