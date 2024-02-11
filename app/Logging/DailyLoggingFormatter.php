<?php

namespace App\Logging;
use Monolog\Formatter\LineFormatter;
class DailyLoggingFormatter{
    
    public function __invoke($logger) {
        
        foreach ($logger->getHandlers() as $handler){
            $handler->setFormatter(new LineFormatter(
                'Faisal[%datetime%] %channel%.%level_name%: %message%'
            ));
        }
    }
}

