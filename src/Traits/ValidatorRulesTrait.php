<?php

namespace YusamHub\Validator\Traits;

trait ValidatorRulesTrait
{
    protected function ruleInt($v, $extra): bool
    {
        return is_int($v);
    }

    protected function ruleString($v, $extra): bool
    {
        return is_string($v);
    }

    protected function ruleFloat($v, $extra): bool
    {
        return is_float($v);
    }

    protected function ruleBool($v, $extra): bool
    {
        return is_bool($v);
    }

    protected function ruleMax($v, $extra): bool
    {
        return strlen($v) <= intval($extra);
    }

    protected function ruleMin($v, $extra): bool
    {
        return strlen($v) >= intval($extra);
    }

    protected function ruleEmail($v, $extra): bool
    {
        return filter_var($v, FILTER_VALIDATE_EMAIL);
    }

    protected function ruleNullable($v, $extra): bool
    {
        return is_null($v);
    }

    protected function ruleRequire($v, $extra): bool
    {
        return !empty($v);
    }

    protected function ruleIn($v, $extra): bool
    {
        return in_array($v, explode(",", $extra));
    }

    protected function ruleRegex($v, $extra): bool
    {
        return preg_match("/" . $extra . "/", strval($v));
    }
}