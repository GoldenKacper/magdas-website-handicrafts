<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        // $response->dumpHeaders();
        // $response->dump();

        $response->assertStatus(302);
    }

    public function test_root_redirects_to_locale(): void
    {
        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect('/pl'); // or assertRedirect('http://localhost:8000/pl')
    }

    public function test_root_following_redirects_returns_ok(): void
    {
        $response = $this->followingRedirects()->get('/');
        $response->assertStatus(200);
        $response->assertSee('Witamy w Rękodziele Magdy'); // optionally check content
    }

    public function test_pl_homepage_returns_ok(): void
    {
        $response = $this->get('/pl');
        $response->assertStatus(200);
    }

    public function test_en_hompage_returns_ok(): void
    {
        $response = $this->get('/en');
        $response->assertStatus(200);
    }
}
