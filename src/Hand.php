<?php

namespace PokerCore;

/**
 * Class Hand
 * @package PokerCore
 */
class Hand
{
    /**
     * @var Card
     */
    protected $card1;

    /**
     * @var Card
     */
    protected $card2;

    /**
     * Hand constructor.
     *
     * @param Card $card1
     * @param Card $card2
     */
    public function __construct(Card $card1, Card $card2)
    {
        $this->card1 = $card1;
        $this->card2 = $card2;
    }

    /**
     * @return Card[]
     */
    public function getCards(): array
    {
        return [$this->card1, $this->card2];
    }

    /**
     * @return int[]
     */
    public function getBitCards(): array
    {
        return [$this->card1->getBitCard(), $this->card2->getBitCard()];
    }

    /**
     * @param string $stringHand
     *
     * @return self
     */
    public static function fromString(string $stringHand): self
    {
        $tempData = str_split($stringHand, 2);

        return new self(Card::fromString($tempData[0]), Card::fromString($tempData[1]));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return ((string)$this->card1) . ((string)$this->card2);
    }
}
