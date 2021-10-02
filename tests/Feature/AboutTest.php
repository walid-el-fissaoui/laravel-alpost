<?php

namespace Tests\Feature;


use Tests\TestCase;

class AboutTest extends TestCase
{
    public function testAboutPage()
    {
        $response = $this->get('/about');

        $response->assertSeeText('About us');
        $response->assertSeeText('this is a post website');
    }
}
