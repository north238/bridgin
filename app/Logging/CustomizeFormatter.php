<?php

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\LogRecord;

class CustomizeFormatter extends LineFormatter
{
  public function __construct()
  {
    $lineFormat = "%datetime% [%channel%.%level_name%] %message%" . PHP_EOL;
    $dateFormat = "Y-m-d H:i:s.v";

    parent::__construct($lineFormat, $dateFormat, true, true);
  }

  /**
   * Formats a log record.
   *
   * @param LogRecord $record The log record to format.
   * @return string The formatted record.
   */
  public function __invoke(LogRecord $record): string
  {
    $output = parent::format($record);

    return $output;
  }
}
