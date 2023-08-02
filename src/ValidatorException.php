<?php

namespace YusamHub\Validator;

class ValidatorException extends \Exception
{
    protected array $validatorErrors;

    public function __construct($message = "", array $validatorErrors = [], $code = 0, \Throwable $previous = null)
    {
        $this->validatorErrors = $validatorErrors;
        parent::__construct($message, $code, $previous);
    }

    public function getValidatorErrors(): array
    {
        return $this->validatorErrors;
    }
}