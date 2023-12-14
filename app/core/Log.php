<?php

    namespace App\Core;

    class Log
    {
        public static function writeLog($text): string
        {
            fwrite(fopen('log.txt', 'ab'), PHP_EOL . date('Y.m.d H:s') . " $text " . PHP_EOL);
            return PHP_EOL . date('Y.m.d H:s') . " $text " . PHP_EOL;
        }
    }