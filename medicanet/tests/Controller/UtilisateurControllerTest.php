<?php

namespace App\Test\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/utilisateur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Utilisateur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[username]' => 'Testing',
            'utilisateur[mail]' => 'Testing',
            'utilisateur[password]' => 'Testing',
            'utilisateur[telephone]' => 'Testing',
            'utilisateur[role]' => 'Testing',
            'utilisateur[adresse]' => 'Testing',
            'utilisateur[age]' => 'Testing',
            'utilisateur[specialite]' => 'Testing',
            'utilisateur[sexe]' => 'Testing',
            'utilisateur[bio]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setUsername('My Title');
        $fixture->setMail('My Title');
        $fixture->setPassword('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setRole('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setAge('My Title');
        $fixture->setSpecialite('My Title');
        $fixture->setSexe('My Title');
        $fixture->setBio('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setUsername('Value');
        $fixture->setMail('Value');
        $fixture->setPassword('Value');
        $fixture->setTelephone('Value');
        $fixture->setRole('Value');
        $fixture->setAdresse('Value');
        $fixture->setAge('Value');
        $fixture->setSpecialite('Value');
        $fixture->setSexe('Value');
        $fixture->setBio('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[username]' => 'Something New',
            'utilisateur[mail]' => 'Something New',
            'utilisateur[password]' => 'Something New',
            'utilisateur[telephone]' => 'Something New',
            'utilisateur[role]' => 'Something New',
            'utilisateur[adresse]' => 'Something New',
            'utilisateur[age]' => 'Something New',
            'utilisateur[specialite]' => 'Something New',
            'utilisateur[sexe]' => 'Something New',
            'utilisateur[bio]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utilisateur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getUsername());
        self::assertSame('Something New', $fixture[0]->getMail());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getAge());
        self::assertSame('Something New', $fixture[0]->getSpecialite());
        self::assertSame('Something New', $fixture[0]->getSexe());
        self::assertSame('Something New', $fixture[0]->getBio());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateur();
        $fixture->setNom('Value');
        $fixture->setPrenom('Value');
        $fixture->setUsername('Value');
        $fixture->setMail('Value');
        $fixture->setPassword('Value');
        $fixture->setTelephone('Value');
        $fixture->setRole('Value');
        $fixture->setAdresse('Value');
        $fixture->setAge('Value');
        $fixture->setSpecialite('Value');
        $fixture->setSexe('Value');
        $fixture->setBio('Value');

        $$this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/utilisateur/');
        self::assertSame(0, $this->repository->count([]));
    }
}
