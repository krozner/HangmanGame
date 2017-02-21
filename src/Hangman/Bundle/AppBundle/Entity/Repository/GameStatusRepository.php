<?php
namespace Hangman\Bundle\AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Hangman\Bundle\AppBundle\Entity\GameStatus;

class GameStatusRepository extends EntityRepository
{
    /**
     * @param int $status
     * @return GameStatus
     */
    public function getStatus(int $status) : GameStatus
    {
        $status = $this->createQueryBuilder('s')
            ->where('s.id = ?1')
            ->getQuery()
            ->setParameter(1, $status)
            ->useResultCache(true)
            ->getSingleResult();

        if(! $status) {
            throw new \InvalidArgumentException('Unknown game status');
        }

        return $status;
    }

    /**
     * @return GameStatus
     */
    public function getSuccess() : GameStatus {
        return $this->getStatus(GameStatus::SUCCESS);
    }

    /**
     * @return GameStatus
     */
    public function getFail() : GameStatus {
        return $this->getStatus(GameStatus::FAIL);
    }
}