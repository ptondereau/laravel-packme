<?php

namespace Ptondereau\Tests\PackMe\Commands;

use Ptondereau\PackMe\Commands\CreateCommand;
use Ptondereau\Tests\PackMe\TestCase;

/**
 * Class CreateCommandTest.
 */
class CreateCommandTest extends TestCase
{
    public function testParseValidAuthorString()
    {
        $command = new CreateCommand();
        $author = $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john@example.com>');
        $this->assertEquals('John Smith', $author['name']);
        $this->assertEquals('john@example.com', $author['email']);
    }

    public function testParseEmptyAuthorString()
    {
        $command = new CreateCommand();
        $this->setExpectedException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', '');
    }

    public function testParseAuthorStringWithInvalidEmail()
    {
        $command = new CreateCommand();
        $this->setExpectedException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john>');
    }
}
