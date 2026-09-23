<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_form_publik_bisa_diakses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Form Cuci Alat Berat');
    }

    public function test_halaman_login_admin_bisa_diakses(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public function test_halaman_dashboard_admin_perlu_login(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/admin/login');
    }
}
