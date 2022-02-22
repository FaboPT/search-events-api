<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
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
        $this->ok($response);
    }

    public function testSearchOnlyDate()
    {
        $this->actingAs($this->user());
        $response = $this->search(['date' => '2021-04-06']);
        $this->ok($response);

    }

    public function testSearchOnlyDateNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['date' => '2022-04-06']);
        $this->notFound($response);
    }

    public function testSearchOnlyTermNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'xpto']);
        $this->notFound($response);
    }

    public function testSearchBothParametersNotFound()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-04-06']);
        $this->notFound($response);
    }

    public function testSearchBothParameters()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-05-10']);
        $this->ok($response);
    }

    public function testSearchDateNotValidate()
    {
        $this->actingAs($this->user());
        $response = $this->search(['term' => 'Greece', 'date' => '2021-13-10']);
        $response->assertJsonValidationErrorFor("date")->assertUnprocessable();
    }

    private function ok(TestResponse $response): void
    {
        $response->assertJsonPath("success", true)
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('success', 'events'))
            ->assertOk();
    }

    private function notFound(TestResponse $response): void
    {
        $response->assertJsonPath("success", false)
            ->assertJson(fn(AssertableJson $json) => $json->hasAll('success', 'message'))
            ->assertNotFound();
    }
}
