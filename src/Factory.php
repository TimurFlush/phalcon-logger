<?php

namespace TimurFlush\PhalconLogger;

use Phalcon\Factory as BaseFactory;

/**
 * Class Factory
 * @package TimurFlush\PhalconLogger
 */
class Factory extends BaseFactory
{
    /**
     * @param $config
     */
    public static function load($config)
    {
        return self::loadClass('\\TimurFlush\\PhalconLogger\\Adapter', $config);
    }
}
