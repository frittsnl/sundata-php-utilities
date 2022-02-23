<?php

namespace Sundata\Utilities\Version;

use InvalidArgumentException;

class Version
{
    /** @var int */
    private $major;
    /** @var int */
    private $minor;
    /** @var int */
    private $patch;

    private function __construct(int $major, int $minor, int $patch)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
    }

    static function of(string $version): Version
    {
        $matches = [];
        $result = preg_match(
            '/^(\d+)\.(\d+)\.(\d+)$/',
            trim($version),
            $matches
        );
        if ($result !== 1) {
            throw new InvalidArgumentException('Invalid version format');
        }
        return new Version(...array_slice($matches, 1));
    }

    function isMajor(int $major): bool
    {
        return $this->major === $major;
    }

    function isMinor(int $minor): bool
    {
        return $this->minor === $minor;
    }

    function isPatch(int $patch): bool
    {
        return $this->patch === $patch;
    }

    function isMajorMinor(int $major, int $minor): bool
    {
        return $this->isMajor($major) && $this->isMinor($minor);
    }

    function toString(): string
    {
        return join('.', [
            $this->major,
            $this->minor,
            $this->patch
        ]);
    }
}