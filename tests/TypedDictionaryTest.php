<?php

declare(strict_types=1);

/**
 * Contains the DictionaryTest class.
 *
 * @copyright   Copyright (c) 2025 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2025-01-11
 *
 */

namespace Konekt\Extend\Tests;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;
use Konekt\Extend\TypedDictionary;
use PHPUnit\Framework\TestCase;

class TypedDictionaryTest extends TestCase
{
    /** @test */
    public function it_can_be_created_for_a_specific_class()
    {
        $dict = TypedDictionary::ofClass(DateTime::class);

        $today = new DateTime();
        $dict->set('today', $today);

        $this->assertEquals($dict->get('today'), $today);
    }

    /** @test */
    public function it_does_not_allow_objects_of_different_class_to_be_added()
    {
        $dict = TypedDictionary::ofClass(DateTime::class);

        $this->expectException(InvalidArgumentException::class);
        $dict->set('today', new \DateTimeImmutable());
    }

    /** @test */
    public function it_allows_subclasses()
    {
        $dict = TypedDictionary::ofClass(DateTime::class);

        $anonymus = new class() extends DateTime {};
        $dict->set('today', $anonymus);

        $this->assertEquals($dict->get('today'), $anonymus);
    }

    /** @test */
    public function it_can_be_created_for_a_specific_interface()
    {
        $dict = TypedDictionary::ofInterface(DateTimeInterface::class);

        $date = new DateTime();
        $dict->set('date1', $date);
        $immutable = new DateTimeImmutable();
        $dict->set('date2', $immutable);

        $this->assertEquals($dict->get('date1'), $date);
        $this->assertEquals($dict->get('date2'), $immutable);
    }

    /** @test */
    public function it_does_not_allow_adding_objects_that_do_not_implement_the_required_interface()
    {
        $dict = TypedDictionary::ofInterface(DateTimeInterface::class);

        $this->expectException(InvalidArgumentException::class);
        $dict->set('today', new \stdClass());
    }

    /** @test */
    public function it_allows_subclasses_that_do_not_directly_implement_the_interface()
    {
        $dict = TypedDictionary::ofInterface(DateTimeInterface::class);

        $anonymus = new class() extends DateTime {};
        $dict->set('today', $anonymus);

        $this->assertEquals($dict->get('today'), $anonymus);
    }

    /** @test */
    public function it_can_restrict_values_to_be_strings()
    {
        $dict = TypedDictionary::ofString();
        $dict->set('key', 'value');
        $this->assertEquals('value', $dict->get('key'));

        $this->expectException(InvalidArgumentException::class);
        $dict->set('key', 123);
    }

    /** @test */
    public function it_can_restrict_values_to_be_integers()
    {
        $dict = TypedDictionary::ofInteger();
        $dict->set('key', 1234);
        $this->assertEquals(1234, $dict->get('key'));

        $this->expectException(InvalidArgumentException::class);
        $dict->set('key', '1234');
    }

    /** @test */
    public function it_can_restrict_values_to_be_floats()
    {
        $dict = TypedDictionary::ofFloat();
        $dict->set('key', 55.0);
        $this->assertEquals(55.0, $dict->get('key'));

        $this->expectException(InvalidArgumentException::class);
        $dict->set('key', 55);
    }

    /** @test */
    public function it_can_restrict_values_to_be_booleans()
    {
        $dict = TypedDictionary::ofBool();
        $dict->set('key', false);
        $this->assertEquals(false, $dict->get('key'));

        $this->expectException(InvalidArgumentException::class);
        $dict->set('key', 'true');
    }
}
