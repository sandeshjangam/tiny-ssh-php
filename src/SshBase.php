<?php

declare(strict_types=1);

namespace Sandesh\Ssh;

use InvalidArgumentException;

abstract class SshBase
{
    protected const ERROR_PRIVATE_KEY = 'Error authenticating with private key.';

    protected const ERROR_PASSWORD = 'Error authenticating with password.';

    protected const ERROR_NOT_CONNECTED = 'Not connected to server.';

    protected const ERROR_DISCONNECT = 'Could not disconnect. Not connected to server.';

    /**
     * The host of the SSH server.
     */
    protected string $host;

    /**
     * The port number of the SSH server. Defaults to 22.
     */
    protected int $port = 22;

    /**
     * The username to use for the SSH connection.
     */
    protected string $username;

    /**
     * The password to use for the SSH connection.
     */
    protected string $password;

    /**
     * The private key to use for the SSH connection.
     */
    protected string $privateKey;

    /**
     * The timeout in seconds for the SSH connection. Defaults to 10.
     */
    protected int $timeout = 10;

    /**
     * Whether the SSH connection has been established.
     */
    protected bool $connected = false;

    /**
     * Sets the host of the SSH server.
     *
     * @return $this
     */
    public function host(string $host): self
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Sets the port number of the SSH server. Defaults to 22.
     *
     * @return $this
     */
    public function port(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Sets the user.
     *
     * @return $this
     */
    public function user(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Sets the password.
     *
     * @return $this
     */
    public function password(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Sets the private key as a string.
     *
     * @return $this
     */
    public function privateKey(string $privateKey): self
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * Sets the path to a private key file.
     *
     * @return $this
     */
    public function privateKeyPath(string $privateKeyPath): self
    {
        // Prepare private key from path
        if (! empty($privateKeyPath)) {
            $keyContent = file_get_contents($privateKeyPath);
            $keyContent = is_string($keyContent) ? $keyContent : '';
            $this->privateKey = $keyContent;
        }

        return $this;
    }

    /**
     * Sets the timeout in seconds for the SSH connection. Defaults to 10.
     *
     * @return $this
     */
    public function timeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Returns true if the connection is established, false otherwise.
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * Connect to remote server.
     */
    abstract public function connect(): self;

    /**
     * Disconnects from the remote server.
     */
    abstract public function disconnect(): void;

    /**
     * Validates the connection arguments.
     * If any of the required arguments are empty, an exception will be thrown.
     *
     * @throws InvalidArgumentException
     */
    protected function validateArguments(): void
    {
        if (empty($this->host)) {
            throw new InvalidArgumentException('Host is required');
        }

        if (empty($this->port)) {
            throw new InvalidArgumentException('Port is required');
        }

        if (empty($this->username)) {
            throw new InvalidArgumentException('Username is required');
        }

        if (empty($this->password) && empty($this->privateKey)) {
            throw new InvalidArgumentException('Password, private key or private key path is required');
        }
    }
}
