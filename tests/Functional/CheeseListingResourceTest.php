<?php

namespace App\Tests\Functional;

use App\ApiPlatform\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();
        $client->request('POST','/api/cheeses', [
            'headers' => [
                'Content-type' => 'application/json'
            ],
            'body' => []
        ]);

        $this->assertResponseStatusCodeSame(400);

        $user = new User();
        $user->setEmail("teste@teste.com");
        $user->setUsername("teste@teste.com");
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$t2qjiuDPu38QiLh87eUsug$tviMBY+I/4b4bMu9xEW9pUCzQFAMXaDMQG2BYcHAEY8');

        /**
         * @var EntityManager
         */
        $em = self::$container->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        $client->request('POST','/login', [
            'headers' => [
                'content-type' => 'application/json'
            ],
            'json' => [
                'email' => 'teste@teste.com',
                'password' => "123"
            ]
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}