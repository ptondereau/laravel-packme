<?php

namespace Ptondereau\Tests\PackMe\Commands;

use Ptondereau\PackMe\Commands\CreateCommand;
use Ptondereau\PackMe\Crafters\PHPCrafter;
use Ptondereau\Tests\PackMe\AbstractTestCase;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Class CreateCommandTest.
 */
class CreateCommandTest extends AbstractTestCase
{
    /**
     * @var PHPCrafter
     */
    protected $crafter;

    /**
     * @var HelperSet
     */
    protected $helperSet;

    /**
     * @before
     */
    public function setUpMock()
    {
        $this->crafter = $this->getMockBuilder(PHPCrafter::class)->disableOriginalConstructor()->getMock();
        $this->helperSet = $this->getMockBuilder(HelperSet::class)->disableOriginalConstructor()->getMock();
    }

    public function testParseValidAuthorString()
    {
        $command = new CreateCommand($this->crafter, $this->helperSet);
        $author = $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john@example.com>');
        $this->assertEquals('John Smith', $author['name']);
        $this->assertEquals('john@example.com', $author['email']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid author string.  Must be in the format: John Smith <john@example.com>
     */
    public function testParseEmptyAuthorString()
    {
        $command = new CreateCommand($this->crafter, $this->helperSet);
        $this->invokeMethod($command, 'parseAuthorString', '');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid author string.  Must be in the format: John Smith <john@example.com>
     */
    public function testParseAuthorStringWithInvalidEmail()
    {
        $command = new CreateCommand($this->crafter, $this->helperSet);
        $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john>');
    }
}
