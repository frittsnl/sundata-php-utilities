<?php

namespace Sundata\Utilities\Test\Version;

use InvalidArgumentException;
use Sundata\Utilities\Version\Version;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    function testItParsesAndIgnoresSpaces()
    {
        $version = Version::of('2.3.4 ');
        $this->assertTrue($version->isMajor(2));
        $this->assertTrue($version->isMinor(3));
        $this->assertTrue($version->isPatch(4));

        $this->assertTrue($version->isMajorMinor(2, 3));
    }

    function testBadVersionIsRejected()
    {
        $this->expectException(InvalidArgumentException::class);
        Version::of('2.3.4.RC1');
    }

    function testToString()
    {
        $this->assertEquals(
            '8.5.3',
            Version::of(' 8.5.3 ')->toString()
        );
    }
}
