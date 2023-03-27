<?php

namespace App\Test\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CharacterRepository $repository;
    private string $path = '/character/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Character::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Character index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'character[identifier]' => 'Testing',
            'character[name]' => 'Testing',
            'character[kind]' => 'Testing',
            'character[surname]' => 'Testing',
            'character[caste]' => 'Testing',
            'character[knowledge]' => 'Testing',
            'character[intelligence]' => 'Testing',
            'character[life]' => 'Testing',
            'character[image]' => 'Testing',
            'character[created]' => 'Testing',
            'character[modified]' => 'Testing',
        ]);

        self::assertResponseRedirects('/character/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Character();
        $fixture->setIdentifier('My Title');
        $fixture->setName('My Title');
        $fixture->setKind('My Title');
        $fixture->setSurname('My Title');
        $fixture->setCaste('My Title');
        $fixture->setKnowledge('My Title');
        $fixture->setIntelligence('My Title');
        $fixture->setLife('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Character');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Character();
        $fixture->setIdentifier('My Title');
        $fixture->setName('My Title');
        $fixture->setKind('My Title');
        $fixture->setSurname('My Title');
        $fixture->setCaste('My Title');
        $fixture->setKnowledge('My Title');
        $fixture->setIntelligence('My Title');
        $fixture->setLife('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'character[identifier]' => 'Something New',
            'character[name]' => 'Something New',
            'character[kind]' => 'Something New',
            'character[surname]' => 'Something New',
            'character[caste]' => 'Something New',
            'character[knowledge]' => 'Something New',
            'character[intelligence]' => 'Something New',
            'character[life]' => 'Something New',
            'character[image]' => 'Something New',
            'character[created]' => 'Something New',
            'character[modified]' => 'Something New',
        ]);

        self::assertResponseRedirects('/character/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdentifier());
        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getKind());
        self::assertSame('Something New', $fixture[0]->getSurname());
        self::assertSame('Something New', $fixture[0]->getCaste());
        self::assertSame('Something New', $fixture[0]->getKnowledge());
        self::assertSame('Something New', $fixture[0]->getIntelligence());
        self::assertSame('Something New', $fixture[0]->getLife());
        self::assertSame('Something New', $fixture[0]->getImage());
        self::assertSame('Something New', $fixture[0]->getCreated());
        self::assertSame('Something New', $fixture[0]->getModified());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Character();
        $fixture->setIdentifier('My Title');
        $fixture->setName('My Title');
        $fixture->setKind('My Title');
        $fixture->setSurname('My Title');
        $fixture->setCaste('My Title');
        $fixture->setKnowledge('My Title');
        $fixture->setIntelligence('My Title');
        $fixture->setLife('My Title');
        $fixture->setImage('My Title');
        $fixture->setCreated('My Title');
        $fixture->setModified('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/character/');
    }
}
