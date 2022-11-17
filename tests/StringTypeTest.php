<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Type\Tests;

use Eureka\Component\Type\StringType;
use PHPUnit\Framework\TestCase;

/**
 * Class StringTypeTest
 *
 * @author romain
 */
class StringTypeTest extends TestCase
{
    private const DEFAULT_STRING = 'any';
    private const DEFAULT_STRING_LONG = 'any long string';

    public function testICanInstantiateStringType(): void
    {
        //~ Given
        $input    = self::DEFAULT_STRING;
        $expected = StringType::class;

        //~ When
        $string = new StringType($input);

        //~ Then
        $this->assertInstanceOf($expected, $string);
    }

    public function testICanCountOnStringType(): void
    {
        //~ Given
        $input    = self::DEFAULT_STRING;
        $expected = \mb_strlen($input);

        //~ When
        $string = new StringType($input);

        //~ Then
        $this->assertSame($expected, count($string));
    }

    public function testICanIterateOnStringType(): void
    {
        //~ Given
        $input    = self::DEFAULT_STRING;
        $expected = StringType::class;
        $string = new StringType($input);

        //~ When
        foreach ($string as $index => $letter) {
            //~ Then
            $this->assertInstanceOf($expected, $letter);
            $this->assertInstanceOf($expected, $string[$index]);
            $this->assertSame($input[$index], (string) $letter, "Current index: $index");
            $this->assertSame($input[$index], (string) $string[$index], "Current index: $index");
        }
    }

    public function testICanUseStringTypeAsArrayLikeRegularString(): void
    {
        //~ Given
        $input  = 'any';
        $string = new StringType($input);

        //~ When

        //~ Then
        $this->assertSame('a', (string) $string[0]);
        $this->assertSame('n', (string) $string[1]);
        $this->assertSame('y', (string) $string[2]);
        $this->assertSame(null, $string[3]);

        $this->assertTrue(isset($string[0]));
        $this->assertFalse(isset($string[3]));

        //~ When
        $string[2] = 'o';

        //~ Then
        $this->assertSame('o', (string) $string[2]);
        $this->assertSame('ano', (string) $string);

        //~ When
        unset($string[1]);
        $this->assertSame('ao', (string) $string);

        $string = new StringType($input);
        unset($string[0]);
        $this->assertSame('ny', (string) $string);

        $string = new StringType($input);
        unset($string[2]);
        $this->assertSame('an', (string) $string);

        $string = new StringType($input);
        unset($string[3]);
        $this->assertSame('any', (string) $string);
    }

    public function testICanSerializeAndUnserializeStringType(): void
    {
        //~ Given
        $input  = 'any';
        $string = new StringType($input);

        //~ When
        $unserializedString = unserialize(serialize($string));

        //~ Then
        $this->assertEquals($string, $unserializedString);
    }

    public function testICanJsonSerializeStringType(): void
    {
        //~ Given
        $string = new StringType(self::DEFAULT_STRING);

        //~ When
        $json = json_encode($string);

        //~ Then
        $this->assertSame(json_encode(self::DEFAULT_STRING), $json);
    }

    public function testICanCheckIfAStringStartsWithAnotherString(): void
    {
        //~ Given
        $string = new StringType(self::DEFAULT_STRING_LONG);

        //~ When / Then
        $this->assertTrue($string->startsWith('any'));
        $this->assertFalse($string->startsWith('ano'));
    }

    public function testICanCheckIfAStringEndsWithAnotherString(): void
    {
        //~ Given
        $string = new StringType(self::DEFAULT_STRING_LONG);

        //~ When / Then
        $this->assertTrue($string->endsWith('ing'));
        $this->assertFalse($string->endsWith('ong'));
    }

    public function testICanCheckIfAStringContainsAnotherString(): void
    {
        //~ Given
        $string = new StringType(self::DEFAULT_STRING_LONG);

        //~ When / Then
        $this->assertTrue($string->contains('any'));
        $this->assertTrue($string->contains('ing'));
        $this->assertTrue($string->contains('long'));
        $this->assertFalse($string->contains('nog'));
    }

    public function testICanSplitAStringOnGivenSeparator(): void
    {
        //~ Given
        $string = new StringType(self::DEFAULT_STRING_LONG);


        //~ When / Then
        $this->assertEquals(
            [new StringType('any'), new StringType('long'), new StringType('string')],
            $string->explode()
        );
        $this->assertEquals(
            [new StringType('any'), new StringType('string')],
            $string->explode(' long ')
        );
    }
}
