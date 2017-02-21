<?php
namespace Hangman\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Hangman\Bundle\AppBundle\Entity\Repository\GameStatusRepository")
 * @ORM\Table(name="hangman_game_status")
 */
class GameStatus
{
    /**
     * constants mapped from hangman_game_status
     */
    const BUSY    = 1;
    const FAIL    = 2;
    const SUCCESS = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="status_id")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @return int|null
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isGameOver()
    {
        return in_array($this->getId(), [
            self::FAIL, self::SUCCESS
        ]);
    }

    /**
     * @return bool
     */
    public function isSuccess() {
        return $this->getId() == self::SUCCESS;
    }
}