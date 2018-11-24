<?php

namespace TimurFlush\PhalconLogger\Tests\Adapter;

use PHPUnit\Framework\Error\Error;
use PHPUnit\Framework\TestCase;
use TimurFlush\PhalconLogger\Adapter\Telegram;

class TelegramTest extends TestCase
{
    /**
     * @var array
     */
    protected $sampleOptions = [
        'chat_id' => 'sampleId',
        'bot_token' => 'sampleToken',
        'allowed_types' => '*'
    ];

    public function testGettingErrorOnCreateWithoutNecessaryOptions()
    {
        $this->expectException(Error::class);
        new Telegram([]);
    }

    public function testClose()
    {
        $a = new Telegram($this->sampleOptions);
        $this->assertTrue($a->close());
    }

    public function testGetFormatter()
    {
        $a = new Telegram($this->sampleOptions);
        $this->assertInstanceOf(
            \Phalcon\Logger\FormatterInterface::class,
            $a->getFormatter()
        );
    }
}
