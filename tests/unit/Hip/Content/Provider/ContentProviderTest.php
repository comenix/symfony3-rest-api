<?php

class ContentProviderTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
    }

    protected function tearDown()
    {
    }

    // tests


    public function testCanConstruct()
    {
        $repo = $this->getMockRepository();
        $provider = $this->getProvider($repo);
        static::assertInstanceOf(
            '\Hip\Content\Provider\ContentProvider',
            $provider
        );
    }


    public function testCanGetWithValidId()
    {
        $data = ['anything'];

        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue($data));
        $provider = $this->getProvider($repo);

        static::assertEquals(
            $data,
            $provider->get(1)
        );
    }

    public function testCantGetWithInvalidId()
    {
        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('find')
            ->will(static::returnValue(null));
        $provider = $this->getProvider($repo);

        static::assertNull($provider->get(100000));
    }

    public function testCanGetAll()
    {
        $data = [1,2];

        $repo = $this->getMockRepository();
        $repo->expects(static::once())
            ->method('findBy')
            ->will(static::returnValue($data));

        $provider = $this->getProvider($repo);
        static::assertEquals(
            $data,
            $provider->all(1, 1)
        );
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockRepository()
    {
        $repo = $this->getMockBuilder('Hip\Content\Repository\ContentRepository')
            ->disableOriginalConstructor()
            ->getMock();
        return $repo;
    }

    /**
     * @param $repo
     * @return \Hip\Content\Provider\ContentProvider
     */
    private function getProvider($repo)
    {
        $handler = $this->getMockBuilder('Hip\AppBundle\Form\Handler\FormHandler')
            ->disableOriginalConstructor()
            ->getMock();

        return new \Hip\Content\Provider\ContentProvider($repo, $handler);
    }
}
