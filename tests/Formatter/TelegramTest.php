<?php

namespace TimurFlush\PhalconLogger\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use \TimurFlush\PhalconLogger\Formatter\Telegram as TelegramFormatter;

class TelegramTest extends TestCase
{
    public function testSettingNullOnCreateIfPassedNotNullArguments()
    {
        $expectationFormat = '{date} {type} {message}';
        $expectationDateFormat = '(d.m.yTH:i:s)';

        $f = new TelegramFormatter(
            $expectationFormat,
            $expectationDateFormat
        );

        $reflection = new \ReflectionObject($f);

        $formatProperty = $reflection->getProperty('_format');
        $formatProperty->setAccessible(true);

        $dateFormatProperty = $reflection->getProperty('_dateFormat');
        $dateFormatProperty->setAccessible(true);

        $this->assertEquals(
            $expectationFormat,
            $formatProperty->getValue($f)
        );

        $this->assertEquals(
            $expectationDateFormat,
            $dateFormatProperty->getValue($f)
        );
    }

    public function testFormat()
    {
        $timestamp = time();

        $f = new TelegramFormatter('{date}{type}{message}', 'd.m.Y');

        $this->assertEquals(
            date('d.m.Y', $timestamp)
            . (new \Phalcon\Logger\Formatter\Line())->getTypeString(\Phalcon\Logger::INFO)
            . 'Ping-Pong'
            ,
            $f->format('Ping-Pong', \Phalcon\Logger::INFO, $timestamp)
        );
    }
}
