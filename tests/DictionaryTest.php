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

use Konekt\Extend\Dictionary;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    /** @test */
    public function it_can_be_read_and_written_as_an_array(): void
    {
        $dict = new Dictionary();
        $dict['name'] = 'Andreas';
        $dict['age'] = 30;

        $this->assertEquals('Andreas', $dict['name']);
        $this->assertEquals(30, $dict['age']);
    }

    /** @test */
    public function it_returns_null_for_inexistent_elements(): void
    {
        $dict = new Dictionary();

        $this->assertNull($dict['nonexistent']);
    }

    /** @test */
    public function it_can_be_used_with_isset_as_an_array(): void
    {
        $dict = new Dictionary();
        $dict['key'] = 'value';

        $this->assertTrue(isset($dict['key']));
        $this->assertFalse(isset($dict['nonexistent']));
    }

    /** @test */
    public function elements_can_be_removed_with_unset_as_an_array(): void
    {
        $dict = new Dictionary();
        $dict['key'] = 'value';
        unset($dict['key']);

        $this->assertFalse(isset($dict['key']));
    }

    /** @test */
    public function it_returns_all_the_elements_if_it_gets_casted_as_an_array(): void
    {
        $dict = new Dictionary();
        $dict['key1'] = 'value1';
        $dict['key2'] = 'value2';

        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $this->assertEquals($expected, $dict->toArray());
    }

    /** @test */
    public function keys_can_be_overwritten_as_arrays(): void
    {
        $dict = new Dictionary();
        $dict['key'] = 'value1';
        $this->assertEquals('value1', $dict['key']);

        $dict['key'] = 'value2';
        $this->assertEquals('value2', $dict['key']);
    }

    /** @test */
    public function values_can_be_retrieved_with_the_get_method(): void
    {
        $dict = new Dictionary();

        $this->assertNull($dict->get('nonexistent'));
        $this->assertEquals('default', $dict->get('nonexistent', 'default'));
    }

    /** @test */
    public function it_can_tell_whether_a_key_exists(): void
    {
        $dict = new Dictionary();
        $dict->set('key', 'value');

        $this->assertTrue($dict->has('key'));
        $this->assertFalse($dict->has('nonexistent'));
    }

    /** @test */
    public function entries_can_be_removed_by_key(): void
    {
        $dict = new Dictionary();
        $dict->set('key', 'value');
        $dict->remove('key');

        $this->assertTrue($dict->doesntHave('key'));
        $this->assertFalse($dict->has('key'));
    }

    /** @test */
    public function multiple_entries_can_be_added_with_the_push_method(): void
    {
        $dict = new Dictionary();
        $dict->set('key', 'value');
        $dict->push([
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ]);

        $this->assertCount(4, $dict);
        $this->assertEquals('value', $dict->get('key'));
        $this->assertEquals('value1', $dict->get('key1'));
        $this->assertEquals('value2', $dict->get('key2'));
        $this->assertEquals('value3', $dict->get('key3'));
    }

    /** @test */
    public function the_all_method_returns_all_the_entries_as_an_array(): void
    {
        $dict = new Dictionary();
        $dict->set('key1', 'value1');
        $dict->set('key2', 'value2');

        $expected = ['key1' => 'value1', 'key2' => 'value2'];
        $this->assertEquals($expected, $dict->all());
    }

    /** @test */
    public function it_is_iterable()
    {
        $dict = new Dictionary();
        $dict->set('A', 'value1');
        $dict->set('B', 'value2');

        $check = [];
        foreach ($dict as $key => $value) {
            $check[$key] = $value;
        }

        $this->assertCount(2, $check);
        $this->assertArrayHasKey('A', $check);
        $this->assertArrayHasKey('B', $check);
    }
}

