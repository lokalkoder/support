<?php

namespace Lokalkoder\Support\Services;

class Hasher
{
    const SPONGE = '2881';

    /**
     * Hash payload.
     *
     * @var string
     */
    private $hashPayload;

    /**
     * Initiate class constructor.
     *
     * @param string $payload
     * @param string $salt
     * @param string $salted
     */
    public function __construct(string $payload, string $salt = null, string $salted = null)
    {
        $this->hashPayload = $payload.$salt . self::SPONGE . $salted;
    }

    /**
     * Get the hash string.
     *
     * @param string $algos
     *
     * @return String
     */
    public function getHash(string $algos = 'sha3-512'): string
    {
        return hash($algos, $this->hashPayload);
    }
}
