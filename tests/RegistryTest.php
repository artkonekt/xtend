<?php

declare(strict_types=1);

/**
 * Contains the RegistryTest class.
 *
 * @copyright   Copyright (c) 2023 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-30
 *
 */

namespace Konekt\Extend\Tests;

use Konekt\Extend\Tests\Dummies\NotATestWidget;
use Konekt\Extend\Tests\Dummies\TestWidget;
use Konekt\Extend\Tests\Dummies\TestWidget3;
use Konekt\Extend\Tests\Dummies\TestWidget4;
use Konekt\Extend\Tests\Dummies\TestWidgetRegistry;
use PHPUnit\Framework\TestCase;

class RegistryTest extends TestCase
{
    /** @test */
    public function classes_can_be_added_to()
    {
        $this->assertTrue(TestWidgetRegistry::add('x', TestWidget::class));
    }

    /** @test */
    public function it_returns_false_when_adding_the_same_twice()
    {
        $this->assertTrue(TestWidgetRegistry::add('y', TestWidget::class));
        $this->assertFalse(TestWidgetRegistry::add('y', TestWidget::class));
    }

    /** @test */
    public function it_throws_an_invalid_argument_exception_when_trying_to_add_a_class_that_does_not_implement_the_required_interface()
    {
        $this->expectException(\InvalidArgumentException::class);

        TestWidgetRegistry::add('kaboom', NotATestWidget::class);
    }

    /** @test */
    public function it_can_tell_the_class_of_a_registered_entry_by_id()
    {
        TestWidgetRegistry::add('classy', TestWidget::class);
        $this->assertEquals(TestWidget::class, TestWidgetRegistry::getClassOf('classy'));
    }

    /** @test */
    public function an_entry_can_be_overridden()
    {
        TestWidgetRegistry::add('better', TestWidget::class);
        $this->assertEquals(TestWidget::class, TestWidgetRegistry::getClassOf('better'));

        TestWidgetRegistry::override('better', TestWidget2::class);
        $this->assertEquals(TestWidget2::class, TestWidgetRegistry::getClassOf('better'));
    }

    /** @test */
    public function an_entry_can_be_deleted()
    {
        TestWidgetRegistry::add('fpang', TestWidget::class);
        $this->assertEquals(TestWidget::class, TestWidgetRegistry::getClassOf('fpang'));

        $this->assertTrue(TestWidgetRegistry::delete('fpang'));
        $this->assertNull(TestWidgetRegistry::getClassOf('fpang'));
    }

    /** @test */
    public function delete_returns_false_if_attempting_to_delete_a_non_existing_entry()
    {
        $this->assertFalse(TestWidgetRegistry::delete('nullus'));
    }

    /** @test */
    public function an_entry_can_be_deleted_by_class()
    {
        TestWidgetRegistry::add('xyz', TestWidget3::class);
        $this->assertEquals(TestWidget3::class, TestWidgetRegistry::getClassOf('xyz'));

        $this->assertEquals(1, TestWidgetRegistry::deleteClass(TestWidget3::class));
        $this->assertNull(TestWidgetRegistry::getClassOf('xyz'));
    }

    /** @test */
    public function all_entries_are_deleted_when_deleting_by_class()
    {
        TestWidgetRegistry::add('A1', TestWidget4::class);
        TestWidgetRegistry::add('A2', TestWidget4::class);
        TestWidgetRegistry::add('A3', TestWidget4::class);
        $this->assertEquals(TestWidget4::class, TestWidgetRegistry::getClassOf('A1'));
        $this->assertEquals(TestWidget4::class, TestWidgetRegistry::getClassOf('A2'));
        $this->assertEquals(TestWidget4::class, TestWidgetRegistry::getClassOf('A3'));

        $this->assertEquals(3, TestWidgetRegistry::deleteClass(TestWidget4::class));
        $this->assertNull(TestWidgetRegistry::getClassOf('A1'));
        $this->assertNull(TestWidgetRegistry::getClassOf('A2'));
        $this->assertNull(TestWidgetRegistry::getClassOf('A3'));
    }

    /** @test */
    public function can_make_an_instance_of_the_desired_object_but_honestly_this_is_userland_code_but_anyway()
    {
        TestWidgetRegistry::add('inst', TestWidget::class);

        $this->assertInstanceOf(TestWidget::class, TestWidgetRegistry::make('inst'));
    }
}
