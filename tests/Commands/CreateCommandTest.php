<?php

namespace Ptondereau\Tests\PackMe\Commands;

use Ptondereau\PackMe\Commands\CreateCommand;
use Ptondereau\Tests\PackMe\TestCase;

/**
 * Class CreateCommandTest
 *
 * @package Ptondereau\Tests\PackMe\Commands
 */
class CreateCommandTest extends TestCase
{
    public function testParseValidAuthorString()
    {
        $command = new CreateCommand;
        $author = $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john@example.com>');
        $this->assertEquals('John Smith', $author['name']);
        $this->assertEquals('john@example.com', $author['email']);
    }

    public function testParseValidUtf8AuthorString()
    {
        $command = new CreateCommand;
        $author = $this->invokeMethod($command, 'parseAuthorString', 'Matti Meikäläinen <matti@example.com>');
        $this->assertEquals('Matti Meikäläinen', $author['name']);
        $this->assertEquals('matti@example.com', $author['email']);
    }

    public function testParseNumericAuthorString()
    {
        $command = new CreateCommand;
        $author = $this->invokeMethod($command, 'parseAuthorString', 'h4x0r <h4x@example.com>');
        $this->assertEquals('h4x0r', $author['name']);
        $this->assertEquals('h4x@example.com', $author['email']);
    }

    public function testParseEmptyAuthorString()
    {
        $command = new CreateCommand;
        $this->setExpectedException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', '');
    }

    public function testParseAuthorStringWithInvalidEmail()
    {
        $command = new CreateCommand;
        $this->setExpectedException('InvalidArgumentException');
        $this->invokeMethod($command, 'parseAuthorString', 'John Smith <john>');
    }
}