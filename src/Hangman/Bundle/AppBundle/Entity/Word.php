<?php

namespace Hangman\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Hangman\Bundle\AppBundle\Entity\Repository\WordRepository")
 * @ORM\EntityListeners({"\Hangman\Bundle\AppBundle\Entity\Listener\WordListener"})
 * @ORM\Table(name="hangman_word")
 */
class Word
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="word_id")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Hangman\Bundle\AppBundle\Entity\Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id", nullable=false)
     */
    private $category;

    /**
     * @Assert\Regex("/^[a-z]+$/")
     * @ORM\Column(type="string")
     */
    private $word;

    /**
     * @ORM\Column(type="string")
     */
    private $hint;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Category
     */
    public function getCategory() : Category {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param string $word
     * @return $this
     */
    public function setWord($word)
    {
        $this->word = $word;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHint()
    {
        return $this->hint;
    }

    /**
     * @param mixed $hint
     * @return $this
     */
    public function setHint($hint)
    {
        $this->hint = $hint;
        return $this;
    }

}