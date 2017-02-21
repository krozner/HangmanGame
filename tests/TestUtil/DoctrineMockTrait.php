<?php

namespace Tests\TestUtil;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;

trait DoctrineMockTrait
{

    protected function getEntityRepositoryMock(array $methods = [])
    {
        $repository = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(array_keys($methods))
            ->getMock();

        foreach($methods as $methodName => $will) {
            $repository
                ->expects($this->any())
                ->method($methodName)
                ->will($will);
        }

        return $repository;
    }

    protected function getDoctrineRegistryMock($repository)
    {
        $emMock = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'getRepository', 'persist', 'flush'
            ])
            ->getMock();

        $emMock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));

        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        return $emMock;
    }
}