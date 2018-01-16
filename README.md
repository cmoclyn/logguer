# Logguer for PHP 7

![build](https://travis-ci.org/cmoclyn/logguer.svg?branch=master-7)
[![codecov](https://codecov.io/gh/cmoclyn/logguer/branch/master-7/graph/badge.svg)](https://codecov.io/gh/cmoclyn/logguer)

## Documentation
--------------

### Init


```php
<?php
use Exceptions\ExceptionHandler;
use Logguer\Writer;

$writer = new Writer(); // Initialize the Writer
$writer->setDirectory(__DIR__.'/../logs/'); // Define the directory where the logs will be store
$writer->setFile('test'); // Specify the file name

ExceptionHandler::setWriter($writer); // Use the writer with the ExceptionHandler to log each exception
ExceptionHandler::debugEnable(); // If you want to display all the exceptions
```

> Note :
>
> The file name use in the writer, will be change to add *_(date).log* at the end of it.

### Write logs

You have different way to write logs. First you have to know that every exceptions (caught and uncaught) will be logs if you use `set_exception_handler`.

But you can log more than exception ; for that you can use the class `Log`.
When you create a new `Log` instance, it will automatically set the current DateTime.
After that, you can use these methods to define what you want to log :

```php
<?php
use Logguer\Log;

$log = new Log(); // The DateTime is already define now

$log->setClass(string $class);
$log->setMessage(string $message);
$log->setDescription(string $description);
$log->setFile(string $file);
$log->setLine(int $line);
$log->setType(string $type);
```

Now, you can use the Writer by doing

```php
<?php
// These 2 lines if you want to use an other file
$writer2 = clone $writer;
$wrtier2->setFile('otherFile');

$writer2->log($log);


```

### Read logs

```php
<?php
use Logguer\Reader;

$reader = new Reader(); // Init the Reader
$reader->setDirectory(__DIR__.'/../logs/'); // Define the directory where the logs are store

$reader->getLogFiles(); // Use this to find the log files in the given directory

$reader->readFile($file);
```
