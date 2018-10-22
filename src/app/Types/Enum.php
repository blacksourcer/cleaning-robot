<?php

namespace App\Types;

/**
 * Class Enum
 *
 * @package App\Types
 */
class Enum
{
    /**
     * @var Enum[]
     */
    private static $instances = [];

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string[]
     */
    protected static $values = [];

    /**
     *
     */
    private function __clone()
    {
        /**
         * No action taken
         */
    }

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        if (!static::isValid($value)) {
            throw new \InvalidArgumentException("Value \"" . var_export($value, true) . "\"is not valid for the enum \"" . static::class . "\"");
        }

        $this->value = $value;
    }

    /**
     * @param string$value
     * @return static
     */
    protected static function getInstance(string $value)
    {
        $className = get_called_class();

        if (!isset(self::$instances[$className][$value])) {
            self::$instances[$className][$value] = new static($value);
        }

        return self::$instances[$className][$value];
    }

    /**
     * @param string $value
     * @return static
     */
    public static function parse(string $value)
    {
        return static::getInstance($value);
    }

    /**
     * @param string $value
     * @return static|null
     */
    public static function tryParse(string $value)
    {
        try {
            return static::parse($value);
        } catch (\InvalidArgumentException $ex) {
            return null;
        }
    }

    /**
     * @param string value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        if (static::$values) {
            return is_numeric(key(static::$values))
                ? in_array((string)$value, static::$values)
                : in_array((string)$value, array_keys(static::$values));
        }

        return true;
    }

    /**
     * @return static[]
     */
    public static function getMembers(): array
    {
        $values = is_numeric(key(static::$values))
            ? static::$values
            : array_keys(static::$values);

        return array_map(function ($value) {
            return static::getInstance($value);
        }, $values);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $value = $this->getValue();

        return static::$values && !is_numeric(key(static::$values))
            ? static::$values[$value]
            : $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}