<?php

namespace YusamHub\Validator;

use YusamHub\Validator\Traits\ValidatorRulesTrait;

class Validator
{
    use ValidatorRulesTrait;

    protected array $attributes = [];
    protected array $rules = [];
    protected array $errors = [];
    protected array $ruleMessages = [];

    public function validate(): bool
    {
        $this->errors = [];
        foreach($this->attributes as $k => $v) {

            if (!isset($this->rules[$k])) continue;

            if (!is_array($this->rules[$k])) {
                throw new ValidatorException(sprintf("Rule for [%s] key must be array", $k));
            }

            foreach($this->rules[$k] as $rule) {
                $ruleK = null;
                if (is_callable($rule)) {
                    $result = call_user_func_array($rule, [$v]);
                } else {
                    list($ruleK, $ruleV) = explode(":", strstr($rule, ':') ? $rule : $rule . ":");

                    $methodName = "rule" . ucfirst($ruleK);

                    if (method_exists($this, $methodName)) {
                        $result = call_user_func_array([$this, $methodName], [$v, $ruleV]);
                    } else {
                        throw new ValidatorException(sprintf("Rule not found [%s]", $rule));
                    }
                }

                if (!$result) {
                    $this->errors[$k] = $this->ruleMessages[$k]??'Invalid value';
                    break;
                }
            }
        }

        return count($this->errors) === 0;
    }

    /**
     * @return void
     * @throws ValidatorException
     */
    public function validateOrFail(): void
    {
        $validate = $this->validate();
        if (!$validate) {
            throw new ValidatorException("Validate errors", $this->getErrors());
        }
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     */
    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    /**
     * @return array
     */
    public function getRuleMessages(): array
    {
        return $this->ruleMessages;
    }

    /**
     * @param array $ruleMessages
     */
    public function setRuleMessages(array $ruleMessages): void
    {
        $this->ruleMessages = $ruleMessages;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}