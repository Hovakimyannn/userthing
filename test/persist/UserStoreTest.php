<?php

use PHPUnit\Framework\TestCase;

class UserStoreTest extends TestCase
{
    private $store;

    protected function setUp(): void
    {
        $this->store = new App\persist\UserStore();
    }

    protected function tearDown(): void
    {

    }

    public function testGetUser()
    {
        $this->store->addUser(
            "bob williams",
            "a@b.com",
            "12345"
        );
        $user = $this->store->getUser("a@b.com");
        $this->assertEquals($user['mail'], "a@b.com");
        $this->assertEquals($user['name'], "bob williams");
        $this->assertEquals($user['pass'], "12345");
    }

    /*public function testAddUserShortPass()
    {
        try {
            $this->store->addUser(
                "bob williams",
                "bob@example.com",
                "ff"
            );
        }catch (\Exception $e) {
            return;
        }
        $this->fail("Ожидалось исключение из-за короткого пароля");
    }*/
    public function testAddUserShortPass()
    {
        $this->expectException('\\Exception');
        $this->store->addUser("bob williams", "a@b.com", "ff");
        $this->fail("Ожидалось исключение из-за короткого пароля");
    }

    public function testAddUserDuplicate()
    {
        try {
            $ret = $this->store->addUser(
                "bob williams",
                "a@b.com",
                "12345"
            );
            $ret = $this->store->addUser(
                "bob williams",
                "a@b.com",
                "12345"
            );
            self::fail("Здесь должно быть вызвано исключение.");
        }
        catch (\Exception $e) {
            $const = $this->logicalAnd(
               // $this->logicalNot($this->contains("bob stevens")),
                $this->isType('array')
            );
            self::AssertThat($this->store->getUser("a@b.com"),$const);
        }
    }
}