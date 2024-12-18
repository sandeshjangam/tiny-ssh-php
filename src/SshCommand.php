<?php

declare(strict_types=1);

namespace Sandesh\Ssh;

use phpseclib3\Net\SSH2;

final class SshCommand
{
    /**
     * The SSH2 connection object.
     */
    private SSH2 $ssh;

    /**
     * The command to execute.
     */
    private string $command;

    /**
     * The output of the command.
     */
    private string|false $output;

    /**
     * The error output of the command.
     */
    private string $error;

    /**
     * The exit status of the command.
     */
    private int|false $exitStatus;

    /**
     * Constructs a new instance of the SshCommand class.
     *
     * @param SSH2 $ssh The SSH2 connection object.
     * @param string $command The command to execute.
     */
    public function __construct(SSH2 $ssh, string $command)
    {
        $this->ssh = $ssh;
        $this->command = $command;
    }

    /**
     * Execute the command.
     *
     * @return static
     */
    public function execute(): self
    {
        // Suppress stderr from output
        $this->ssh->enableQuietMode();

        $this->output = $this->ssh->exec($this->command);

        $this->error = $this->ssh->getStdError();

        $this->exitStatus = $this->ssh->getExitStatus();

        return $this;
    }

    /**
     * Returns the raw output of the command.
     *
     * @return bool|string The raw output, or false if no output was captured.
     */
    public function getRawOutput(): string|false
    {
        return $this->output;
    }

    /**
     * Returns the raw error output of the command.
     */
    public function getRawError(): string
    {
        return $this->error;
    }

    /**
     * Returns the output of the command, trimmed of whitespace.
     */
    public function getOutput(): string
    {
        $output = (string) $this->getRawOutput();

        return trim($output);
    }

    /**
     * Returns the error output of the command, trimmed of whitespace.
     */
    public function getError(): string
    {
        return trim($this->getRawError());
    }

    /**
     * Returns the exit status of the command.
     */
    public function getExitStatus(): int|false
    {
        return $this->exitStatus;
    }

    /**
     * Check if the exit status of the command matches the given status.
     */
    public function isExitStatus(int|false $status): bool
    {
        return $this->exitStatus === $status;
    }
}
