<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Type;

/*
 * @todo:
 * - implode()
 * - lcfirst()
 * - trim(), ltrim(), rtrim()
 * - md5()
 * - sha1()
 * -
 * - str_replace / str_ireplace
 * - str_pad
 * - str_repeat
 * - str_replace
 * - str_rot13
 * - str_shuffle
 * - str_split
 * - str_word_count
 * - strcasecmp
 * - strchr
 * - strcmp
 * - strcoll
 * - strcspn
 * - strip_tags
 * - stripcslashes
 * - stripos
 * - stripslashes
 * - stristr
 * - strlen
 * - strnatcasecmp
 * - strnatcmp
 * - strncasecmp
 * - strncmp
 * - strpbrk
 * - strpos
 * - strrchr
 * - strrev
 * - strripos
 * - strrpos
 * - strspn
 * - strstr
 * - strtok
 * - strtolower
 * - strtoupper
 * - strtr
 * - substr_compare
 * - substr_count
 * - substr_replace
 * - substr
 * - ucfirst
 * - ucwords
 * - wordwrap
 *
 * - sprintf
 */

/**
 * Class StringType
 *
 * @author Romain Cottard
 * @implements \ArrayAccess<int,StringType>
 * @implements \Iterator<int,StringType>
 */
class StringType implements \ArrayAccess, \Iterator, \Countable, \JsonSerializable, \Serializable
{
    /** @var string $string */
    private $string;

    /** @var int $pointer */
    private $pointer = 0;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function jsonSerialize(): string
    {
        return $this->string;
    }

    public function startsWith(string $string): bool
    {
        return (strpos($this->string, $string) === 0);
    }

    public function endsWith(string $string): bool
    {
        return (strpos(strrev($this->string), strrev($string)) === 0);
    }

    public function contains(string $string): bool
    {
        return (strpos($this->string, $string) !== false);
    }

    /**
     * @param string $separator
     * @return StringType[]
     */
    public function explode(string $separator = ' '): array
    {
        $strings = [];
        foreach ((array) explode($separator, $this->string) as $string) {
            $strings[] = new self((string) $string);
        }

        return $strings;
    }

    public function current(): ?StringType
    {
        return isset($this->string[$this->pointer]) ? new self($this->string[$this->pointer]) : null;
    }

    public function next(): void
    {
        $this->pointer++;
    }

    public function key(): int
    {
        return $this->pointer;
    }

    public function valid(): bool
    {
        return ($this->pointer < \mb_strlen($this->string));
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->string[$offset]);
    }

    public function offsetGet($offset): ?StringType
    {
        if (!isset($this->string[$offset])) {
            return null;
        }

        return new self($this->string[$offset]);
    }

    public function offsetSet($offset, $value): void
    {
        if (isset($this->string[(int) $offset])) {
            $this->string[(int) $offset] = (string) $value;
        }
    }

    public function offsetUnset($offset): void
    {
        if (!isset($this->string[$offset])) {
            return;
        }

        $this->string = substr($this->string, 0, ($offset + 1) - 1) . substr($this->string, $offset + 1);

        if ($offset <= $this->pointer) {
            $this->pointer--;
        }
    }

    public function count(): int
    {
        return \mb_strlen($this->string);
    }

    public function serialize(): string
    {
        return $this->string;
    }

    public function unserialize($data): void
    {
        $this->string = $data;
    }
}
