<?php

namespace PokerCore\Tests;

use PHPUnit\Framework\TestCase;
use PokerCore\Card;

class CardTest extends TestCase
{
    /**
     * @return array
     */
    public static function providerGetSuit(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = ["{$rank}{$suit}", $suit];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param string $expectedSuit
     *
     * @dataProvider providerGetSuit
     */
    public function testGetSuit(string $card, string $expectedSuit): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($expectedSuit, $item->getSuit());
    }

    /**
     * @return array
     */
    public static function providerGetBitSuit(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    "{$rank}{$suit}",
                    (Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                        | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]) >> 12 & 0xF
                ];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param int $bitSuit
     *
     * @dataProvider providerGetBitSuit
     */
    public function testGetBitSuit(string $card, int $bitSuit)
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitSuit, $item->getBitSuit());
    }


    /**
     * @return array
     */
    public static function providerGetBitRankInt(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    "{$rank}{$suit}",
                    (Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                        | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]) >> 8 & 0xF
                ];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param int $bitRank
     *
     * @dataProvider providerGetBitRankInt
     */
    public function testGetBitRankInt(string $card, int $bitRank)
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitRank, $item->getBitRankInt());
    }

    /**
     * @return array
     */
    public static function providerGetBitSuitFromInt(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                    | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank],
                    (Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                        | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]) >> 12 & 0xF
                ];
            }
        }

        return $data;
    }

    /**
     * @param int $bitCard
     * @param int $bitSuit
     *
     * @dataProvider providerGetBitSuitFromInt
     */
    public function testGetBitSuitFromInt(int $bitCard, int $bitSuit)
    {
        $this->assertEquals($bitSuit, Card::getBitSuitFromInt($bitCard));
    }

    /**
     * @param string $card
     * @param int $bitRank
     *
     * @dataProvider providerGetBitRank
     */
    public function testGetBitRankFromString(string $card, int $bitRank)
    {
        $this->assertEquals($bitRank, Card::getBitRankFromString($card));
    }

    /**
     * @return array
     */
    public static function providerGetBitRank(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    "{$rank}{$suit}",
                    (Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                        | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]) >> 16
                ];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param int $bitRank
     *
     * @dataProvider providerGetBitRank
     */
    public function testGetBitRank(string $card, int $bitRank)
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitRank, $item->getBitRank());
    }

    /**
     * @return array
     */
    public static function providerGetBitCard(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    "{$rank}{$suit}",
                    Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                    | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]
                ];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param int $bitCard
     *
     * @dataProvider providerGetBitCard
     */
    public function testGetBitCard(string $card, int $bitCard): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitCard, $item->getBitCard());
    }


    /**
     * @return array
     */
    public static function providerGetBitRankFromInt(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                    | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank],
                    (Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                        | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]) >> 16
                ];
            }
        }

        return $data;
    }

    /**
     * @param int $bitCard
     * @param int $bitRank
     *
     * @dataProvider providerGetBitRankFromInt
     */
    public function testGetBitRankFromInt(int $bitCard, int $bitRank)
    {
        $this->assertEquals($bitRank, Card::getBitRankFromInt($bitCard));
    }

    /**
     * @param string $card
     * @param int $bitPrime
     *
     * @dataProvider providerGetBitPrime
     */
    public function testGetBitPrimeFromInt(string $card, int $bitPrime): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitPrime, Card::getBitPrimeFromInt($item->getBitCard()));
    }

    /**
     * @return array
     */
    public static function providerFromString(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = ["{$rank}{$suit}"];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     *
     * @dataProvider providerFromString
     */
    public function testFromString(string $card): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($card, $item->__toString());
        $this->assertEquals($card, $item->getRank() . $item->getSuit());
    }

    /**
     * @return array
     */
    public static function providerGetRank(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = ["{$rank}{$suit}", $rank];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param string $expectedRank
     *
     * @dataProvider providerGetRank
     */
    public function testGetRank(string $card, string $expectedRank): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($expectedRank, $item->getRank());

    }

    /**
     * @return array
     */
    public static function provider__construct(): array
    {
        $data = [];

        foreach (['A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2'] as $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = [
                    Card::STR_TO_BIT_MAP[$rank] | Card::STR_TO_BIT_SUIT_MAP[$suit]
                    | Card::STR_TO_BIT_RANK_MAP[$rank] | Card::STR_TO_BIT_PRIME_MAP[$rank]
                ];
            }
        }

        return $data;
    }

    /**
     * @param int $bitCard
     *
     * @dataProvider provider__construct
     */
    public function test__construct(int $bitCard): void
    {
        $item = new Card($bitCard);

        $this->assertInstanceOf(Card::class, $item);
    }

    /**
     * @return array
     */
    public static function provider__constructException(): array
    {
        return [
            [1],
            [2],
            [3],
            [-1],
            [0]
        ];
    }

    /**
     * @param int $bitCard
     *
     * @dataProvider provider__constructException
     */
    public function test__constructException(int $bitCard): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $item = new Card($bitCard);
    }

    /**
     * @param string $card
     *
     * @dataProvider providerFromString
     */
    public function test__toString(string $card): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($card, $item->__toString());
        $this->assertEquals($card, $item->getRank() . $item->getSuit());
    }

    /**
     * @return array
     */
    public static function providerGetBitPrime(): array
    {
        $data = [];

        foreach ([
                     41 => 'A',
                     37 => 'K',
                     31 => 'Q',
                     29 => 'J',
                     23 => 'T',
                     19 => '9',
                     17 => '8',
                     13 => '7',
                     11 => '6',
                     7 => '5',
                     5 => '4',
                     3 => '3',
                     2 => '2'
                 ] as $bitPrime => $rank) {
            foreach (['s', 'h', 'd', 'c'] as $suit) {
                $data[] = ["{$rank}{$suit}", $bitPrime];
            }
        }

        return $data;
    }

    /**
     * @param string $card
     * @param int $bitPrime
     *
     * @dataProvider providerGetBitPrime
     */
    public function testGetBitPrime(string $card, int $bitPrime): void
    {
        $item = Card::fromString($card);

        $this->assertEquals($bitPrime, $item->getBitPrime());
    }
}
