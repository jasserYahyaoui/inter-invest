<?php

namespace App\DataFixtures;

use App\Entity\LegalStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $datas = json_decode(file_get_contents(__DIR__ . '/../../var/data/legal-status-data.json'), true);

        foreach ($datas as $key => $data) {
            $status = 0 === $key ? new LegalStatus() : clone $status;
            $status->setStatus($data['status']);
            $manager->persist($status);
        }

        $manager->flush();
    }
}
