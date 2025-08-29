<?php

namespace EleFilter\Exceptions;

use RuntimeException;

class InvalidParameterException extends RuntimeException
{
    const FILTER_ARRAY_PARAMETERS_INCOMPATIBLE = 'The filter array parameters are not compatible!';

    public static function filterArrayParametersAreIncompatible(): InvalidParameterException
    {
        return new self(self::FILTER_ARRAY_PARAMETERS_INCOMPATIBLE);
    }
}
