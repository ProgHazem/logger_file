<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoggerTest extends TestCase
{
    public function test_authenticate()
    {
        Session::remove("auth");
        $this->visit('/register')
            ->type('admin', 'username')
            ->type('admin', 'password')
            ->press('Login')
            ->seePageIs('/');
    }


    public function test_not_found()
    {
        $this->visit('/')
            ->type('/log/gjngjk.txt', 'path')
            ->press('preview')
            ->see('file(/log/gjngjk.txt): Failed to open stream: No such file or directory');
    }

    public function test_empty_file()
    {
        $this->visit('/')
            ->type('/var/log/apache2/error.log', 'path')
            ->press('preview')
            ->see('No data available in table');
    }

    public function test_file()
    {
        $this->visit('/')
            ->type('/var/log/apache2/hazem.error.log', 'path')
            ->press('preview')
            ->see('Showing 1 to 10 of 85 entries');
    }
}
