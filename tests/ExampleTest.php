<?php

namespace YusamHub\Validator\Tests;

use YusamHub\Validator\Validator;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $validator = new Validator();
        $validator->setAttributes([
            'id' => 2,
            'email' => 'test@test.ru',
            'float' => '0.1',
            'title' => '12',
        ]);
        $validator->setRules([
            'id' => ['int','max:20'],
            'email' => ['string','min:6','email'],
            'float' => ['float'],
            'title' => ['require','string','min:2',
                function($v) {
                    return true;
                }
            ]
        ]);
        $validator->setRuleMessages([
            'title' => 'Value must be string and min 2 digits'
        ]);

        var_dump($validator->validate());

        print_r($validator->getErrors());
    }
}