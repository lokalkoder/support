<?php

namespace Lokalkoder\Support\Services;

class Hasher
{
    public const SPONGE = '2881';

    /**
     * @var string|null
     */
    private $salted;

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
        $this->salted = $salted;

        $this->hashPayload = $payload.$salt . config('lokalsupport.hasher.sponge', self::SPONGE) . $salted;
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

    /**
     * Get hasher value.
     *
     * @return string
     */
    public function getHasher(): string
    {
        return hash_hmac('sha3-512', md5($this->hashPayload), md5($this->salted));
    }

    /**
     * Check hasher.
     *
     * @param string|null $hasher
     * @return bool
     */
    public function checkHasher(?string $hasher): bool
    {
        return ($hasher !== null) ? hash_equals($hasher, $this->getHasher()) : false;
    }
}
