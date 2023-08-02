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

    /**
     * @throws ValidatorException
     */
    public function validate(): bool
    {
        $this->errors = [];
        $ruleKeys = array_keys($this->rules);
        foreach($ruleKeys as $k) {

            $v = null;
            if (isset($this->attributes[$k])) {
                $v = $this->attributes[$k];
            }

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
     * @param string $name
     * @return mixed|null
     */
    public function getAttribute(string $name)
    {
        return $this->attributes[$name]??null;
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function setAttribute(string $name, $value)
    {
        $this->attributes[$name] = $value;
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
     * @param string $name
     * @return mixed|null
     */
    public function getRule(string $name)
    {
        return $this->rules[$name]??null;
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function setRule(string $name, $value)
    {
        $this->rules[$name] = $value;
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
     * @param string $name
     * @return mixed|null
     */
    public function getRuleMessage(string $name)
    {
        return $this->ruleMessages[$name]??null;
    }

    /**
     * @param string $name
     * @param $value
     * @return void
     */
    public function setRuleMessage(string $name, $value)
    {
        $this->ruleMessages[$name] = $value;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

}