<?php

namespace Ptondereau\Tests\PackMe\Commands;

use Ptondereau\PackMe\Commands\CreateCommand;
use Ptondereau\PackMe\Crafters\PHPCrafter;
use Ptondereau\Tests\PackMe\TestCase;
use Silly\Edition\PhpDi\Application;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

/**
 * Class CreateCommandTest.
 */
class CreateCommandTest extends TestCase
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

    public function testParseEmptyAuthorString()
    {
        $command = new CreateCommand($this->crafter, $this->helperSet);
        $this->expectException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', '');
    }

    public function testParseAuthorStringWithInvalidEmail()
    {
        $command = new CreateCommand($this->crafter, $this->helperSet);
        $this->expectException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john>');
    }
}
