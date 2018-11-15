<?php

namespace TimurFlush\PhalconLogger\Adapter;

use Phalcon\Logger\Adapter;
use TimurFlush\PhalconLogger\Formatter\Telegram as TelegramFormatter;

/**
 * Class Telegram
 * @package TimurFlush\PhalconLogger\Adapter
 */
class Telegram extends Adapter
{
    /**
     * @var array
     */
    private $options = [
        'chat_id' => '',
        'bot_token' => '',
        'allowed_types' => '*'
    ];

    /**
     * Telegram constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (!isset($options['chat_id'], $options['bot_token'])) {
            trigger_error("Parameters [chat_id] and [bot_token] are mandatory.");
        }

        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * @return \Phalcon\Logger\FormatterInterface
     */
    public function getFormatter()
    {
        if ($this->_formatter === null) {
            $this->_formatter = new TelegramFormatter();
        }

        return $this->_formatter;
    }

    /**
     * @param string $message
     * @param int $type
     * @param int $time
     * @param array $context
     */
    public function logInternal(string $message, int $type, int $time, array $context) : void
    {
        if (isset($this->options['allowed_types'])){
            if (is_string($this->options['allowed_types']) && $this->options['allowed_types'] !== '*') {
                return;
            } else if (is_array($this->options['allowed_types']) && !in_array($type, $this->options['allowed_types'])) {
                return;
            }
        }

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => "https://api.telegram.org/bot${this->options['bot_token']}/sendMessage",
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'chat_id' => $this->options['chat_id'],
                'text' => $this->getFormatter()->format($message, $type, $time, $context),
                'parse_mode' => 'Markdown'
            ]
        ]);

        curl_exec($ch);
        curl_close($ch);
    }
}
