<?php

namespace Alias\tests;

require __DIR__ . '/../src/Alias.php';

use slprime\Alias;
use PHPUnit\Framework\TestCase;

class AliasTest extends TestCase {

    public function testFilePathAlias() {
        $path = '/path/to/foo';
        $alias = new Alias();

        // an alias of a file path
        $alias->setAlias('@foo', $path);

        $this->assertEquals($path, $alias->getAlias('@foo'));
    }

    public function testURLAlias() {
        $path = 'http://www.example.com';
        $alias = new Alias();

        // an alias of a URL
        $alias->setAlias('@foo', $path);

        $this->assertEquals($path, $alias->getAlias('@foo'));
    }

    public function testFilePathAliasWithPostfix() {
        $path = '/path/to/foo';
        $alias = new Alias();

        // an alias of a file path
        $alias->setAlias('@foo', $path);

        $this->assertEquals($path . '/path/to', $alias->getAlias('@foo/path/to'));
    }

    public function testURLAliasWithPostfix() {
        $path = 'http://www.example.com';
        $alias = new Alias();

        // an alias of a URL
        $alias->setAlias('@foo', $path);

        $this->assertEquals($path . '/path/to', $alias->getAlias('@foo/path/to'));
    }

    public function testConstructorInjection(){
        $alias = new Alias([
            '@foo' => '/path/to/foo',
            '@bar' => 'http://www.example.com',
        ]);

        $this->assertEquals('/path/to/foo/path/to', $alias->getAlias('@foo/path/to'));
        $this->assertEquals('http://www.example.com/path/to', $alias->getAlias('@bar/path/to'));
        $this->assertEquals('http://www.example.com', $alias->getAlias('@bar'));
    }

    public function testResolvingAliases(){
        $alias = new Alias();
        $alias->setAlias('@foo', '/path/to/foo');
        $alias->setAlias('@foo/bar', '/path2/bar');

        $this->assertEquals('/path/to/foo/test/file.php', $alias->getAlias('@foo/test/file.php'));
        $this->assertEquals('/path2/bar/file.php', $alias->getAlias('@foo/bar/file.php'));
    }

}