<?php

declare(strict_types=1);

namespace Sandesh\Ssh;

use InvalidArgumentException;
use phpseclib3\Crypt\PublicKeyLoader;
use phpseclib3\Net\SFTP as SFTP2;
use RuntimeException;

final class Sftp extends SshBase
{
    /**
     * The SSH2 connection object.
     */
    private SFTP2 $sftp;

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

        $this->sftp = new SFTP2($this->host, $this->port);

        $this->loginToSftpServer();

        if ($this->timeout) {
            $this->sftp->setTimeout($this->timeout);
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

        $this->sftp->disconnect();
        $this->connected = false;
    }

    /**
     * Upload a file to the remote server.
     *
     * @throws RuntimeException
     */
    public function upload(string $localFilePath, string $remoteFilePath): bool
    {
        if (! $this->connected) {
            throw new RuntimeException('Could not upload a file. ' . self::ERROR_NOT_CONNECTED);
        }

        if (! file_exists($localFilePath)) {
            throw new InvalidArgumentException('The local file does not exist.');
        }

        return $this->sftp->put($remoteFilePath, $localFilePath, SFTP2::SOURCE_LOCAL_FILE);
    }

    /**
     * Download a file from the remote server.
     *
     * @throws RuntimeException
     */
    public function download(string $remoteFilePath, string $localFilePath): bool
    {
        if (! $this->connected) {
            throw new RuntimeException('Could not download a file. ' . self::ERROR_NOT_CONNECTED);
        }

        return $this->sftp->get($remoteFilePath, $localFilePath);
    }

    /**
     * Get fingerprint of public key.
     */
    public function getFingerprint(): string
    {
        if (! $this->connected) {
            throw new RuntimeException('Could not get a fingerprint. ' . self::ERROR_NOT_CONNECTED);
        }

        return $this->sftp->getServerPublicHostKey();
    }

    /**
     * Authenticates with the SFTP server using either a private key or a password.
     *
     * If a private key is provided, it will be used for authentication. If a password is provided,
     * it will be used for authentication. If neither a private key nor a password is provided,
     * an exception will be thrown.
     *
     * @throws RuntimeException
     */
    private function loginToSftpServer(): void
    {
        if (! empty($this->privateKey)) {
            // Login with private key
            $keyLoader = PublicKeyLoader::load($this->privateKey);
            $authenticated = $this->sftp->login($this->username, $keyLoader);
            if (! $authenticated) {
                throw new RuntimeException(self::ERROR_PRIVATE_KEY);
            }
        } else {
            // Login with password
            $authenticated = $this->sftp->login($this->username, $this->password);
            if (! $authenticated) {
                throw new RuntimeException(self::ERROR_PASSWORD);
            }
        }
    }
}
