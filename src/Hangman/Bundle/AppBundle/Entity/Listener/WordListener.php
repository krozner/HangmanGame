<?php

namespace Hangman\Bundle\AppBundle\Entity\Listener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Hangman\Bundle\AppBundle\Entity\Word;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\Mapping as ORM;

class WordListener
{
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @ORM\PrePersist()
     * @param Word $word
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(Word $word, LifecycleEventArgs $event)
    {
        $errors = $this->validator->validate($word);

        if (count($errors) > 0) {
            throw new \RuntimeException("Entity " . get_class($word) . " is not valid. \n" . $errors);
        }
    }
}