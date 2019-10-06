<?php

namespace PokerCore\Tests;

use PHPUnit\Framework\TestCase;
use PokerCore\Card;
use PokerCore\Hand;

class HandTest extends TestCase
{
    /**
     * @return array
     */
    public static function provider__toStringFromString(): array
    {
        return [
            ['AcAd'],
            ['AcKc'],
            ['2s3s'],
        ];
    }

    /**
     * @param string $cards
     * @dataProvider provider__toStringFromString
     */
    public function test__toString(string $cards): void
    {
        $item = Hand::fromString($cards);

        $this->assertEquals($cards, $item->__toString());
    }

    /**
     * @return array
     */
    public static function provider__construct(): array
    {
        return [
            ['Ac', 'Ad'],
            ['Ac', 'Kc'],
            ['2s', '3s'],
            ['Qh', 'Qd'],
        ];
    }

    /**
     * @param string $card1
     * @param string $card2
     *
     * @dataProvider provider__construct
     */
    public function test__construct(string $card1, string $card2)
    {
        $card1 = Card::fromString($card1);
        $card2 = Card::fromString($card2);

        $item = new Hand($card1, $card2);

        $this->assertInstanceOf(Hand::class, $item);
    }

    /**
     * @return array
     */
    public static function providerGetCards(): array
    {
        return [
            ['AcAd'],
            ['AcKc'],
            ['2s3s'],
            ['QhQd'],
        ];
    }

    /**
     * @param string $cards
     *
     * @dataProvider providerGetBitCards
     */
    public function testGetCards(string $cards)
    {
        $item = Hand::fromString($cards);

        $cards = str_split($cards, 2);

        $card1 = Card::fromString($cards[0]);
        $card2 = Card::fromString($cards[1]);

        $this->assertEquals([$card1, $card2], $item->getCards());
    }

    /**
     * @param string $cards
     * @dataProvider provider__toStringFromString
     */
    public function testFromString(string $cards): void
    {
        $item = Hand::fromString($cards);

        $this->assertEquals($cards, $item->__toString());
    }

    /**
     * @return array
     */
    public static function providerGetBitCards(): array
    {
        return [
            ['AcAd', 268471337, 268454953],
            ['AcKc', 268471337, 134253349],
            ['2s3s', 69634, 135427],
        ];
    }

    /**
     * @param string $cards
     * @param int    $bitCard1
     * @param int    $bitCard2
     *
     * @dataProvider providerGetBitCards
     */
    public function testGetBitCards(string $cards, int $bitCard1, int $bitCard2)
    {
        $item = Hand::fromString($cards);

        $this->assertEquals([$bitCard1, $bitCard2], $item->getBitCards());
    }
}
