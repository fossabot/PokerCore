<?php

namespace PokerCore;

/**
 * Class Card
 *
 * We represent cards as 32-bit integers, so there is no object instantiation - they are just ints.
 * Most of the bits are used, and have a specific meaning. See below:
 *
 * Card:
 * bitrank     suit rank   prime
 * +--------+--------+--------+--------+
 * |xxxbbbbb|bbbbbbbb|cdhsrrrr|xxpppppp|
 * +--------+--------+--------+--------+
 *
 * 1) p = prime number of rank (deuce=2,trey=3,four=5,...,ace=41)
 * 2) r = rank of card (deuce=0,trey=1,four=2,five=3,...,ace=12)
 * 3) cdhs = suit of card (bit turned on based on suit of card)
 * 4) b = bit turned on depending on rank of card
 * 5) x = unused
 * This representation will allow us to do very important things like:
 * - Make a unique prime prodcut for each hand
 * - Detect flushes
 * - Detect straights
 * and is also quite performant.
 *
 * @package HandHistory
 */
class Card
{
    const SPADES = 1 << 12;
    const HEARTS = 1 << 13;
    const DIAMONDS = 1 << 14;
    const CLUBS = 1 << 15;

    const _A = 1 << 28;
    const _K = 1 << 27;
    const _Q = 1 << 26;
    const _J = 1 << 25;
    const _T = 1 << 24;
    const _9 = 1 << 23;
    const _8 = 1 << 22;
    const _7 = 1 << 21;
    const _6 = 1 << 20;
    const _5 = 1 << 19;
    const _4 = 1 << 18;
    const _3 = 1 << 17;
    const _2 = 1 << 16;

    const _A_prime = 41;
    const _K_prime = 37;
    const _Q_prime = 31;
    const _J_prime = 29;
    const _T_prime = 23;
    const _9_prime = 19;
    const _8_prime = 17;
    const _7_prime = 13;
    const _6_prime = 11;
    const _5_prime = 7;
    const _4_prime = 5;
    const _3_prime = 3;
    const _2_prime = 2;

    const _A_rank = 12 << 8;
    const _K_rank = 11 << 8;
    const _Q_rank = 10 << 8;
    const _J_rank = 9 << 8;
    const _T_rank = 8 << 8;
    const _9_rank = 7 << 8;
    const _8_rank = 6 << 8;
    const _7_rank = 5 << 8;
    const _6_rank = 4 << 8;
    const _5_rank = 3 << 8;
    const _4_rank = 2 << 8;
    const _3_rank = 1 << 8;
    const _2_rank = 0 << 8;

    const STR_SPADES = 's';
    const STR_HEARTS = 'h';
    const STR_DIAMONDS = 'd';
    const STR_CLUBS = 'c';

    const STR_A = 'A';
    const STR_K = 'K';
    const STR_Q = 'Q';
    const STR_J = 'J';
    const STR_T = 'T';
    const STR_9 = '9';
    const STR_8 = '8';
    const STR_7 = '7';
    const STR_6 = '6';
    const STR_5 = '5';
    const STR_4 = '4';
    const STR_3 = '3';
    const STR_2 = '2';

    const STR_TO_BIT_SUIT_MAP = [
        self::STR_SPADES => self::SPADES,
        self::STR_HEARTS => self::HEARTS,
        self::STR_DIAMONDS => self::DIAMONDS,
        self::STR_CLUBS => self::CLUBS
    ];

    const BIT_CARDS = [
        268442665,
        134224677,
        67115551,
        33560861,
        16783383,
        8394515,
        4199953,
        2102541,
        1053707,
        529159,
        266757,
        135427,
        69634,
        268446761,
        134228773,
        67119647,
        33564957,
        16787479,
        8398611,
        4204049,
        2106637,
        1057803,
        533255,
        270853,
        139523,
        73730,
        268454953,
        134236965,
        67127839,
        33573149,
        16795671,
        8406803,
        4212241,
        2114829,
        1065995,
        541447,
        279045,
        147715,
        81922,
        268471337,
        134253349,
        67144223,
        33589533,
        16812055,
        8423187,
        4228625,
        2131213,
        1082379,
        557831,
        295429,
        164099,
        98306
    ];


    const BIT_TO_STR_SUIT_MAP = [
        1 => self::STR_SPADES,
        2 => self::STR_HEARTS,
        4 => self::STR_DIAMONDS,
        8 => self::STR_CLUBS
    ];


    const STR_TO_BIT_RANK_MAP = [
        self::STR_A => self::_A_rank,
        self::STR_K => self::_K_rank,
        self::STR_Q => self::_Q_rank,
        self::STR_J => self::_J_rank,
        self::STR_T => self::_T_rank,
        self::STR_9 => self::_9_rank,
        self::STR_8 => self::_8_rank,
        self::STR_7 => self::_7_rank,
        self::STR_6 => self::_6_rank,
        self::STR_5 => self::_5_rank,
        self::STR_4 => self::_4_rank,
        self::STR_3 => self::_3_rank,
        self::STR_2 => self::_2_rank
    ];

    const STR_TO_BIT_PRIME_MAP = [
        self::STR_A => self::_A_prime,
        self::STR_K => self::_K_prime,
        self::STR_Q => self::_Q_prime,
        self::STR_J => self::_J_prime,
        self::STR_T => self::_T_prime,
        self::STR_9 => self::_9_prime,
        self::STR_8 => self::_8_prime,
        self::STR_7 => self::_7_prime,
        self::STR_6 => self::_6_prime,
        self::STR_5 => self::_5_prime,
        self::STR_4 => self::_4_prime,
        self::STR_3 => self::_3_prime,
        self::STR_2 => self::_2_prime
    ];

    const STR_TO_BIT_MAP = [
        self::STR_A => self::_A,
        self::STR_K => self::_K,
        self::STR_Q => self::_Q,
        self::STR_J => self::_J,
        self::STR_T => self::_T,
        self::STR_9 => self::_9,
        self::STR_8 => self::_8,
        self::STR_7 => self::_7,
        self::STR_6 => self::_6,
        self::STR_5 => self::_5,
        self::STR_4 => self::_4,
        self::STR_3 => self::_3,
        self::STR_2 => self::_2,
    ];

    const BIT_TO_STR_MAP = [
        self::STR_2,
        self::STR_3,
        self::STR_4,
        self::STR_5,
        self::STR_6,
        self::STR_7,
        self::STR_8,
        self::STR_9,
        self::STR_T,
        self::STR_J,
        self::STR_Q,
        self::STR_K,
        self::STR_A
    ];

    /**
     * @var int
     */
    protected $bitCard;

    /**
     * @var int
     */
    protected $bitRank;

    /**
     * Card constructor.
     * @param int $bitCard
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(int $bitCard)
    {
        if (!in_array($bitCard, static::BIT_CARDS)) {
            throw new \InvalidArgumentException('Invalid rank or suit');
        }

        $this->bitCard = $bitCard;
        $this->bitRank = $this->bitCard >> 16;
    }

    /**
     * @param string $card
     *
     * @return Card
     *
     * @throws \InvalidArgumentException
     */
    public static function fromString(string $card): self
    {
        $tempData = str_split($card, 1);

        return new self(static::STR_TO_BIT_MAP[$tempData[0]] | static::STR_TO_BIT_SUIT_MAP[$tempData[1]] | static::STR_TO_BIT_RANK_MAP[$tempData[0]] | static::STR_TO_BIT_PRIME_MAP[$tempData[0]]);
    }

    public static function getBitRankFromString(string $card): int
    {
        $tempData = str_split($card, 1);
        return (static::STR_TO_BIT_MAP[$tempData[0]] | static::STR_TO_BIT_SUIT_MAP[$tempData[1]] | static::STR_TO_BIT_RANK_MAP[$tempData[0]] | static::STR_TO_BIT_PRIME_MAP[$tempData[0]]) >> 16;
    }

    /**
     * @return string
     */
    public function getRank(): string
    {
        return static::BIT_TO_STR_MAP[($this->bitCard >> 8) & 0xF];
    }

    /**
     * @return int
     */
    public function getBitRank(): int
    {
        return $this->bitRank;
    }

    /**
     * @param int $bitCard
     *
     * @return int
     */
    public static function getBitRankFromInt(int $bitCard): int
    {
        return $bitCard >> 16;
    }

    /**
     * @return int
     */
    public function getBitRankInt(): int
    {
        return ($this->bitCard >> 8) & 0xF;
    }

    /**
     * @return string
     */
    public function getSuit(): string
    {
        return static::BIT_TO_STR_SUIT_MAP[($this->bitCard >> 12) & 0xF];
    }

    /**
     * @return int
     */
    public function getBitSuit(): int
    {
        return ($this->bitCard >> 12) & 0xF;
    }

    /**
     * @param $bitCard
     *
     * @return int
     */
    public static function getBitSuitFromInt($bitCard): int
    {
        return ($bitCard >> 12) & 0xF;
    }

    /**
     * @return int
     */
    public function getBitCard(): int
    {
        return $this->bitCard;
    }

    /**
     * @return int
     */
    public function getBitPrime(): int
    {
        return $this->bitCard & 0x3F;
    }

    /**
     * @param int $bitCard
     *
     * @return int
     */
    public static function getBitPrimeFromInt(int $bitCard): int
    {
        return $bitCard & 0x3F;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getRank() . $this->getSuit();
    }
}