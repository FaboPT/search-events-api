<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    //** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function headers(): array
    {
        return [
            "Accept" => "application/json"
        ];
    }

    public function testLogin()
    {
        $user = $this->userLogin();
        $response = $this->post(route('login'), $user, $this->headers());
        $response->assertJsonFragment(['success' => true]);
        $response->assertJsonFragment(['type' => 'Bearer']);
        $response->assertOk();

    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function userLogin(): array
    {
        return [
            'email' => 'example@example.com',
            'password' => 'password'
        ];
    }

    public function testErrorLogin()
    {
        $response = $this->post(route('login'), [], $this->headers());
        $response->assertJsonValidationErrorFor("email");
        $response->assertJsonValidationErrorFor("password");
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testErrorPasswordLogin()
    {
        $userError = $this->userError();
        $response = $this->post(route('login'), $userError, $this->headers());
        $response->assertJsonFragment(["message" => trans('auth.failed')]);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function userError(): array
    {
        return [
            'email' => 'example@example.com',
            'password' => 'password12'
        ];
    }
}
