<?php

namespace TimurFlush\PhalconLogger\Formatter;

use Phalcon\Logger\Formatter;

/**
 * Class Telegram
 * @package TimurFlush\PhalconLogger\Formatter
 */
class Telegram extends Formatter
{
    /**
     * @var string
     */
    protected $_format = "\[{date}] *{type}* \n\n{message}";

    /**
     * @var string
     */
    protected $_dateFormat = \DATE_RFC1036;

    /**
     * Telegram constructor.
     *
     * @param string|null $format
     * @param string|null $dateFormat
     */
    public function __construct(?string $format = null, ?string $dateFormat = null)
    {
        if ($format !== null) {
            $this->format = $format;
        }

        if ($dateFormat !== null) {
            $this->_dateFormat = $dateFormat;
        }
    }

    /**
     *
     * @param string $message
     * @param int $type
     * @param int $timestamp
     * @param null $context
     * @return string
     */
    public function format($message, $type, $timestamp, $context = null)
    {
        $context = [
            'date' => date($this->_dateFormat, $timestamp),
            'type' => $this->getTypeString($type),
            'message' => $message
        ];

        $message = $this->interpolate($this->_format, $context);

        return $message;
    }
}
