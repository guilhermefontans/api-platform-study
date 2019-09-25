<?php


namespace App\Test;


use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UserResourceTest extends CustomApiTestCase
{

    use ReloadDatabaseTrait;

    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'test@test.com',
                'username' => 'test',
                'password' => 'testpassword'
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);
        $this->logIn($client, 'test@test.com', 'testpassword');
    }

    public function testUpdateUser()
    {
        $client = self::createClient();
        $user = $this->createUserAndLogin($client, "teste@teste.com", '123');

        $client->request('PUT', '/api/users/' . $user->getId(), [
           'json' => ['username' => 'newusername']
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'username' => 'newusername'
        ]);
    }
}