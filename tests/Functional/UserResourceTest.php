<?php

namespace App\Test;

use App\Entity\User;
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
           'json' => [
               'username' => 'newusername',
               'roles' => ['ROLE_ADMIN']
           ]
        ]);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'username' => 'newusername'
        ]);

        $em = $this->getEntityManager();
        $user = $em->getRepository(User::class)->find($user->getId());

        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    public function testGetUser()
    {
        $client = self::createClient();
        $user = $this->createUser( "teste@teste.com", '123');
        $this->createUserAndLogin($client, "otherteste@teste.com", '123');
        $user->setPhoneNumber('555.123.456');

        $em = $this->getEntityManager();
        $em->flush();

        $client->request('GET', '/api/users/' . $user->getId());
        $this->assertJsonContains([
            'username' => 'teste'
        ]);

        $data = $client->getResponse()->toArray();
        $this->assertArrayNotHasKey('phoneNumber', $data);

        $user = $em->getRepository(User::class)->find($user->getId());
        $user->setRoles(['ROLE_ADMIN']);
        $em->flush();

        $this->logIn($client, 'teste@teste.com', '123');

        $client->request('GET', '/api/users/' . $user->getId());
        $this->assertJsonContains([
            'phoneNumber' => '555.123.456'
        ]);
    }
}