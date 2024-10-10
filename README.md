# Tiny SSH PHP

Tiny SSH package that allows you to execute commands over SSH connections. It supports both password and private key authentication and is built on the [phpseclib](https://phpseclib.com/) library.


## Installation

Install the package via composer:

```bash
composer require sandeshjangam/tiny-ssh-php
```

## Usage

Simple SSH command using password authentication:

```php
$ssh = (new Ssh)
    ->host($ip)
    ->port(22)
    ->user($user)
    ->password($password)
    // ->privateKey($privateKey)
    // ->privateKeyPath($privateKeyPath)
    ->connect();

$response = $ssh->execute('whoami');

$response->getOutput();  // 'username'
$response->getError();   // ''

```

### Response of a command

Get the output:
```php
$response->getOutput(); // It returns the `stdout`
```

Get the error if any:
```php
$response->getError(); // It returns the `stderr`
```

Get the exit status:
```php
$response->getExitStatus(); // 0 for success. To check if the command ran successfully
```

### Running multiple commands

To execute multiple commands pass an array of commands:

```php
$response = $ssh->execute(['whoami', 'ls -la']);
```

Or pass the commands as a string separated by `&&`:

```php
$response = $ssh->execute('whoami && ls -la');
```

### Use timeout for the long running command

You can set the `timeout`. Default is 10 seconds:

```php
->timeout(60) // 60 seconds
```

### Use private key as a string or file

You can use `Private Key` content:

```php
->privateKey('private_key_content')
```

Or `Private Key` file path:

```php
->privateKeyPath('/home/user/.ssh/id_rsa')
```

### Upload or Download files and directories

To upload or download files and directories, you'll need to use the SFTP class:

```php
$sftp = (new Sftp)
    ->host($ip)
    ->port(22)
    ->user($user)
    ->password($password)
    // ->privateKey($privateKey)
    // ->privateKeyPath($privateKeyPath)
    ->connect();
```

To `upload` a file or directory to the remote server:

```php
$sftp->upload('local/file/path', 'remote/file/path')
```

To `download` a file or directory from the remote server:

```php
$sftp->download('remote/file/path', 'local/file/path')
```

### Disconnect SSH or SFTP connection

To disconnect the SSH connection:

```php
$ssh->disconnect();
```

To disconnect the SFTP connection:

```php
$sftp->disconnect();
```

## Testing

``` bash
composer test
```

## Credits

- [phpseclib](https://phpseclib.com/)
- [PHP SSH Connection](https://github.com/DivineOmega/php-ssh-connection)

## License

The [MIT License (MIT)](LICENSE.md).
