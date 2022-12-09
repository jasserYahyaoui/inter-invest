<?php

namespace App\Test\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CompanyControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CompanyRepository $repository;
    private string $path = '/company/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Company::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company index');

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
            'company[name]' => 'Testing',
            'company[SIREN]' => 'Testing',
            'company[registrationCity]' => 'Testing',
            'company[registrationDate]' => 'Testing',
            'company[Capital]' => 'Testing',
            'company[legalStatus]' => 'Testing',
        ]);

        self::assertResponseRedirects('/company/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSIREN('My Title');
        $fixture->setRegistrationCity('My Title');
        $fixture->setRegistrationDate('My Title');
        $fixture->setCapital('My Title');
        $fixture->setLegalStatus('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Company');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSIREN('My Title');
        $fixture->setRegistrationCity('My Title');
        $fixture->setRegistrationDate('My Title');
        $fixture->setCapital('My Title');
        $fixture->setLegalStatus('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'company[name]' => 'Something New',
            'company[SIREN]' => 'Something New',
            'company[registrationCity]' => 'Something New',
            'company[registrationDate]' => 'Something New',
            'company[Capital]' => 'Something New',
            'company[legalStatus]' => 'Something New',
        ]);

        self::assertResponseRedirects('/company/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getSIREN());
        self::assertSame('Something New', $fixture[0]->getRegistrationCity());
        self::assertSame('Something New', $fixture[0]->getRegistrationDate());
        self::assertSame('Something New', $fixture[0]->getCapital());
        self::assertSame('Something New', $fixture[0]->getLegalStatus());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Company();
        $fixture->setName('My Title');
        $fixture->setSIREN('My Title');
        $fixture->setRegistrationCity('My Title');
        $fixture->setRegistrationDate('My Title');
        $fixture->setCapital('My Title');
        $fixture->setLegalStatus('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/company/');
    }
}
