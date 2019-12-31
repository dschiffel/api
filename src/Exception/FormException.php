<?php declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormException extends HttpException
{
    /**
     * @var FormErrorIterator
     */
    private $formErrors;

    public function __construct(FormErrorIterator $formErrors, \Throwable $previous = null, array $headers = [])
    {
        $this->formErrors = $formErrors;

        parent::__construct(Response::HTTP_UNPROCESSABLE_ENTITY, '', $previous, $headers);
    }

    public function getFormatterErrors(): array
    {
        $errObj = [];
        foreach ($this->formErrors as $formError) {
            $name = $formError->getOrigin()->getName();
            if (!array_key_exists($name, $errObj)) {
                $errObj[$name] = [];
            }

            $errObj[$name][] = $formError->getMessage();
        }

        $errObj = array_map(function ($value) {
            return implode("\n", $value);
        }, $errObj);

        return [$this->formErrors->getForm()->getName() => $errObj];
    }
}
