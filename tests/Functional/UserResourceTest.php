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

}