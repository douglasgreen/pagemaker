<?php

namespace PageMaker\Test;

use PageMaker\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testCookie()
    {
        $request = new Request();
        $request->set('cookie', ['key' => 'value']);
        $this->assertEquals('value', $request->get('cookie', 'key'));
    }

    public function testFile()
    {
        $request = new Request();
        $request->set('file', ['key' => 'value']);
        $this->assertEquals('value', $request->get('file', 'key'));
    }

    public function testGet()
    {
        $request = new Request();
        $request->set('get', ['key' => 'value']);
        $this->assertEquals('value', $request->get('get', 'key'));
    }

    public function testGetWithDefaultValue()
    {
        $request = new Request();
        $this->assertEquals('default', $request->get('get', 'key', 'default'));
    }

    public function testPost()
    {
        $request = new Request();
        $request->set('post', ['key' => 'value']);
        $this->assertEquals('value', $request->get('post', 'key'));
    }

    public function testProcessArgv()
    {
        $argv = ['script.php', '--key1', 'value1', '--key2'];

        $request = new Request();
        $request->set('arg', $argv);
        $this->assertEquals('value1', $request->get('arg', 'key1'));
    }

    public function testServer()
    {
        $request = new Request();
        $request->set('server', ['key' => 'value']);
        $this->assertEquals('value', $request->get('server', 'key'));
    }
}
