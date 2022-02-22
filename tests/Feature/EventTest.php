<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EventTest extends TestCase
{
    private function user()
    {
        return User::firstWhere('email', 'example@example.com');
    }

    private function search($parameters = []): TestResponse
    {
        return $this->get(route('events.search', $parameters), ["Accept" => "application/json"]);
    }


    public function testSearchWithoutAuthentication()
    {
        $response = $this->search(['term' => 'Greece', 'date' => '2021-04-06']);

        $response->assertJson(["message" => "Unauthenticated."])
            ->assertUnauthorized();
    }

    public function testSearchOnlyTerm()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece']);
        $response->assertJsonFragment(["success" => true])->assertOk();

    }

    public function testSearchOnlyDate()
    {
        $this->actingAs($this->user());
        $response = $this->search(['date' => '2021-04-06']);
        $response->assertJsonFragment(["success" => true])->assertOk();

    }

    public function testSearchOnlyDateNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['date' => '2022-04-06']);
        $response->assertJsonFragment(["success" => false])->assertNotFound();
    }

    public function testSearchOnlyTermNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'xpto']);
        $response->assertJsonFragment(["success" => false])->assertNotFound();
    }

    public function testSearchBothParametersNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-04-06']);
        $response->assertJsonFragment(["success" => false])->assertNotFound();
    }

    public function testSearchBothParameters()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-05-10']);
        $response->assertJsonFragment(["success" => true])->assertOk();
    }

    public function testSearchDateNotValidate()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-13-10']);
        $response->assertJsonValidationErrorFor("date")->assertUnprocessable();
    }
}
