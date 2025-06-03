<?php

namespace Tests\Feature;

use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_no_token_returns_401()
    {
        $response = $this->getJson('/api/me');
        $response->assertStatus(401);
    }

    public function test_invalid_token_returns_401()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalidtoken'
        ])->getJson('/api/me');

        $response->assertStatus(401);
    }

    public function test_valid_token_but_wrong_role_returns_403()
    {
        $token = $this->createTestToken('seeker'); // seeker không phải admin

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->getJson('/api/admin/jobs'); // route cần 'admin'

        $response->assertStatus(403);
    }

    public function test_valid_token_with_admin_role_returns_200()
    {
        $token = $this->createTestToken('admin');

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->getJson('/api/admin/jobs');

        $response->assertStatus(200); // Giả sử route đang hoạt động
    }

    private function createTestToken($role)
    {
        $payload = [
            'id'    => 1,
            'email' => "$role@example.com",
            'role'  => $role,
            'exp'   => time() + 3600
        ];

        return \Firebase\JWT\JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
