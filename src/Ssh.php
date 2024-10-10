<?php

declare(strict_types=1);

namespace Sandesh\Ssh;

use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SSH2;
use RuntimeException;

final class Ssh extends SshBase
{
    /**
     * The SSH2 connection object.
     */
    private SSH2 $ssh;

    /**
     * Connects to the remote server using the configured details.
     *
     * @return $this
     *
     * @throws RuntimeException
     */
    public function connect(): self
    {
        $this->validateArguments();

        $this->ssh = new SSH2($this->host, $this->port);

        $this->loginToSshServer();

        if ($this->timeout) {
            $this->ssh->setTimeout($this->timeout);
        }

        $this->connected = true;

        return $this;
    }

    /**
     * Disconnects from the remote server.
     *
     * @throws RuntimeException
     */
    public function disconnect(): void
    {
        if (! $this->connected) {
            throw new RuntimeException(self::ERROR_DISCONNECT);
        }

        $this->ssh->disconnect();
        $this->connected = false;
    }

    /**
     * Execute a command
     *
     * @throws RuntimeException
     */
    /**
     * Execute a command
     *
     * @throws RuntimeException
     */
    public function execute(string|array $command): SshCommand
    {
        if (! $this->connected) {
            throw new RuntimeException('Could not execute command. ' . self::ERROR_NOT_CONNECTED);
        }

        $commands = (array) $command;

        $commandString = implode(PHP_EOL, $commands);

        return (new SshCommand($this->ssh, $commandString))->execute();
    }

    /**
     * Get fingerprint of public key.
     */
    public function getFingerprint(): string
    {
        if (! $this->connected) {
            throw new RuntimeException('Could not get a fingerprint. ' . self::ERROR_NOT_CONNECTED);
        }

        return $this->ssh->getServerPublicHostKey();
    }

    /**
     * Authenticates with the SSH server using either a private key or a password.
     *
     * If a private key is provided, it will be used for authentication. If a password is provided,
     * it will be used for authentication. If neither a private key nor a password is provided,
     * an exception will be thrown.
     *
     * @throws RuntimeException
     */
    private function loginToSshServer(): void
    {
        if (! empty($this->privateKey)) {
            // Login with private key
            $keyLoader = PublicKeyLoader::load($this->privateKey);
            $authenticated = $this->ssh->login($this->username, $keyLoader);
            if (! $authenticated) {
                throw new RuntimeException(self::ERROR_PRIVATE_KEY);
            }
        } else {
            // Login with password
            $authenticated = $this->ssh->login($this->username, $this->password);
            if (! $authenticated) {
                throw new RuntimeException(self::ERROR_PASSWORD);
            }
        }
    }
}
