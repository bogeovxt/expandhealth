<?php

namespace Laravel\Nova\Exceptions;

use Exception;

class NovaException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param  string  $method
     * @param  string  $class
     * @return \Laravel\Nova\Exceptions\HelperNotSupported
     */
    public static function helperNotSupported($method, $class)
    {
        return new HelperNotSupported("The {$method} helper method is not supported by the {$class} class.");
    }

    /**
     * Create a new exception instance.
     *
     * @param  string  $name
     * @return \Laravel\Nova\Exceptions\ResourceMissingException
     */
    public static function missingResourceForRepeater($name)
    {
        return ResourceMissingException::forRepeater("Missing resource for repeater {$name}");
    }
}
