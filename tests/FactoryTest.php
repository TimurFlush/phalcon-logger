<?php

namespace TimurFlush\PhalconLogger\Tests;

use PHPUnit\Framework\TestCase;
use TimurFlush\PhalconLogger\Factory as TestingFactory;

class FactoryTest extends TestCase
{
    public function testLoadIsInstanceOF()
    {
        $adapter = TestingFactory::load(
            [
                'adapter' => 'Telegram',
                'chat_id' => '',
                'bot_token' => '',
            ]
        );

        $this->assertInstanceOf(
            \Phalcon\Logger\AdapterInterface::class,
            $adapter
        );
    }
}
