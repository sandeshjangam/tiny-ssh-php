<?php

use Sandesh\Ssh\Ssh;

// test('example', function () {
//     expect(true)->toBeTrue();
// });


beforeEach(function () {
    $ip = 'example.com';
    $rootUsername = 'root';

    $this->ssh = (new Ssh)
        ->host($ip)
        ->port(22)
        ->user($rootUsername);
        // ->password($rootPassword);
        // ->privateKey($privateKey)
        // ->privateKeyPath($privateKeyPath)
        // ->timeout(100)
        // ->connect();
});

test('no host', function () {
    $this->expectException(InvalidArgumentException::class);

    $ssh = (new Ssh)
        ->port(22)
        ->user('root')
        ->password('root')
        ->connect();
});

test('no user', function () {
    $this->expectException(InvalidArgumentException::class);

    $ssh = (new Ssh)
        ->host('example.com')
        ->port(22)
        ->password('root')
        ->connect();
});

test('no password', function () {
    $this->expectException(InvalidArgumentException::class);

    $ssh = (new Ssh)
        ->host('example.com')
        ->port(22)
        ->user('root')
        ->connect();
});

test('no private key', function () {
    $this->expectException(InvalidArgumentException::class);

    $ssh = (new Ssh)
        ->host('example.com')
        ->port(22)
        ->user('root')
        ->connect();
});

test('no private key path', function () {
    $this->expectException(InvalidArgumentException::class);

    $ssh = (new Ssh)
        ->host('example.com')
        ->port(22)
        ->user('root')
        ->connect();
});
