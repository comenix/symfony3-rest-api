<?php

namespace Hip\AppBundle\DataFixtures\ORM;

use Hip\AppBundle\Entity\Content;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 *
USAGE:
bin/console doctrine:fixtures:load -n --env=dev
 *
 * Class LoadContentData
 * @package Hip\AppBundle\DataFixtures\ORM
 */
class LoadContentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData() as $data) {
            $content = new Content();
            $content
                ->setTitle($data['title'])
                ->setBody($data['body']);

            $manager->persist($content);
            $this->addReference($data['reference'], $content);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 100; // the order in which fixtures will be loaded
    }

    /**
     * @return array
     */
    private function getData()
    {
        return [
            1 => ['title' => 'home', 'body' => '<h1>Home</h1><p>Welcome</p>', 'reference' => 'content-1'],
            2 => ['title' => 'about', 'body' => '<h1>About</h1><p>stuff</p>', 'reference' => 'content-2'],
        ];
    }
}
