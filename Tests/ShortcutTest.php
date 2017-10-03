<?php


namespace Uruloke\LaraCalendar\Test;


class ShortcutTest extends TestCase
{
    public $expectedException;

    protected function setUp ()
    {
        try{
            parent::setUp();
        }
        catch (\Exception $exception)
        {
           $this->expectedException = $exception;
        }

    }


    /** @test */
    public function cannot_boot_when_invalid_shortcut()
    {
        $this->assertInstanceOf(\InvalidArgumentException::class, $this->expectedException);
    }

    protected function getEnvironmentSetUp ($app)
    {
        $app['config']['calendar.shortcuts'] = [
            'test@test@test'
        ];
    }


}