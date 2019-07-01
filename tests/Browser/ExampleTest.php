<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            // 1. Visit the homepage
            // 2. Press a "Click Me" link
            // 3. See "You've been clicked, punk"
            // 4. Assert that the current url is /feedback
            $browser->visit("/")
                ->clickLink("Click Me")
                ->assertSee("You've been clicked, punk.")
                ->assertPathIs('/feedback');
        });
    }
}
