<?php

return [
    'slow' => env('SQLLOG_SLOW', true),
    'slow_time' => env('SQLLOG_SLOW_TIME', 0),
    'debug_backtrace' => env('SQLLOG_DEBUG_BACKTRACE', false),
];