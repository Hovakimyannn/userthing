<?php

use App\persist\UserStore;
use App\persist\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $store = new UserStore();
        $store->addUser(
            "bob williams",
            "bob@example.com",
            "12345"
        );
        $this->validator = new Validator($store);
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testValidateCorrectPass()
    {
        $this->assertTrue(
            $this->validator->validateUser(
                "bob@example.com",
                "12345",
            ),
            "Ожидалась успешная проверка."
        );
    }

   /* public function testValidateFalsePass()
    {
        $store = $this->getMock(__NAMESPACE__ . "\\UserStore");
        $this->validator = new Validator($store);

        $store->expects($this->once())
        ->method('notifyPasswordFailure')
            ->with($this->equalTo('bob@example.com'));

        $store->expects($this->any())
            ->method("getUser")
            ->will($this->returnValue([
                "name" => "bob williams",
                "mail" => "bob@example.com",
                "pass" => "right"
            ]));
        $this->validator->validateUser("bob@example.com", "wrong");
    }*/
}