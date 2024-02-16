<?php

namespace App\Logging;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;

class CustomizeFormatter
{
  /**
   * 指定するロガーインスタンスをカスタマイズ
   */
  public function __invoke(Logger $logger): void
  {
    foreach ($logger->getHandlers() as $handler) {
      $handler->setFormatter(new LineFormatter(
        '[%datetime%] %channel%.%level_name%: %message%'
      ));
    }
  }
}
