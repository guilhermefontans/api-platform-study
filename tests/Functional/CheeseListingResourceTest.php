<?php

namespace App\Tests\Functional;

use App\Entity\CheeseListing;
use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

/**
 * Class CheeseListingResourceTest
 * @package App\Tests\Functional
 */
class CheeseListingResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();
        $this->createUserAndLogin($client, 'teste@teste.com', '123');

        $client->request('POST','/api/cheeses', [
            'json' => []
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testUpdateCheeseListing()
    {
        $client = self::createClient();
        $user1 = $this->createUser('teste1@teste.com', '123');
        $user2 = $this->createUser('teste2@teste.com', '123');

        $cheeseListing = new CheeseListing("My cheese");
        $cheeseListing->setOwner($user1);
        $cheeseListing->setPrice(1000);
        $cheeseListing->setDescription("humm");

        $em = $this->getEntityManager();
        $em->persist($cheeseListing);
        $em->flush();

        $this->logIn($client,$user1->getEmail(), '123' );
        $client->request('PUT', '/api/cheeses/'.$cheeseListing->getId(), [
            'json' => ['title' => 'updated']
        ]);
        $this->assertResponseStatusCodeSame(200);

        $this->logIn($client,$user2->getEmail(), '123' );
        $client->request('PUT', '/api/cheeses/'.$cheeseListing->getId(), [
            'json' => ['title' => 'updated']
        ]);
        $this->assertResponseStatusCodeSame(403);
    }
}