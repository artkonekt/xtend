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

use Konekt\Extend\Tests\Dummies\NamedEntry1;
use Konekt\Extend\Tests\Dummies\NamedEntry2;
use Konekt\Extend\Tests\Dummies\NoNameEntry1;
use Konekt\Extend\Tests\Dummies\NoNameEntry2;
use Konekt\Extend\Tests\Dummies\NotATestWidget;
use Konekt\Extend\Tests\Dummies\RegistryOfEntriesHavingNames;
use Konekt\Extend\Tests\Dummies\RegistryOfEntriesWithoutNames;
use Konekt\Extend\Tests\Dummies\RegistryOfRegisterables;
use Konekt\Extend\Tests\Dummies\TestResetableRegistry;
use Konekt\Extend\Tests\Dummies\TestWidget;
use Konekt\Extend\Tests\Dummies\TestWidget2;
use Konekt\Extend\Tests\Dummies\TestWidget3;
use Konekt\Extend\Tests\Dummies\TestWidget4;
use Konekt\Extend\Tests\Dummies\TestWidget5;
use Konekt\Extend\Tests\Dummies\TestWidget6;
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
    public function it_can_tell_the_id_of_a_registered_entry_by_class()
    {
        TestWidgetRegistry::add('test5', TestWidget5::class);
        TestWidgetRegistry::add('test6', TestWidget6::class);
        $this->assertEquals('test5', TestWidgetRegistry::getIdOf(TestWidget5::class));
        $this->assertEquals('test6', TestWidgetRegistry::getIdOf(TestWidget6::class));
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

    /** @test */
    public function it_can_be_reset_to_zero_items()
    {
        TestResetableRegistry::add('R1', TestWidget::class);
        TestResetableRegistry::add('R2', TestWidget::class);

        $this->assertCount(2, TestResetableRegistry::ids());
        TestResetableRegistry::reset();

        $this->assertCount(0, TestResetableRegistry::ids());
    }

    /** @test */
    public function choices_returns_the_names_of_registerables()
    {
        RegistryOfRegisterables::add('N3', TestWidget3::class);
        RegistryOfRegisterables::add('N4', TestWidget4::class);

        $choices = RegistryOfRegisterables::choices();
        $this->assertEquals(TestWidget3::getName(), $choices['N3']);
        $this->assertEquals(TestWidget4::getName(), $choices['N4']);
    }

    /** @test */
    public function choices_returns_the_names_of_entries_with_get_name_method()
    {
        RegistryOfEntriesHavingNames::add('NE1', NamedEntry1::class);
        RegistryOfEntriesHavingNames::add('NE2', NamedEntry2::class);

        $choices = RegistryOfEntriesHavingNames::choices();
        $this->assertEquals(NamedEntry1::getName(), $choices['NE1']);
        $this->assertEquals(NamedEntry2::getName(), $choices['NE2']);
    }

    /** @test */
    public function choices_returns_the_classnames_of_entries_without_get_name_method()
    {
        RegistryOfEntriesWithoutNames::add('NONAME1', NoNameEntry1::class);
        RegistryOfEntriesWithoutNames::add('NONAME2', NoNameEntry2::class);

        $choices = RegistryOfEntriesWithoutNames::choices();
        $this->assertEquals(NoNameEntry1::class, $choices['NONAME1']);
        $this->assertEquals(NoNameEntry2::class, $choices['NONAME2']);
    }
}
