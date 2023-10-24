<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    /**
     * A basic login test.
     *
     * @return void
     */
    public function testBasicLogin()
    {
    // Mengambil akun pengguna yang sudah ada di database
    $existingUser = User::where('email','khamimthohari50@gmail.com')->first();
    dd($existingUser);

    // Melakukan login sebagai pengguna yang sudah ada
    $response = $this->actingAs($existingUser)->post('/login', [
        'email' => 'khamimthohari50@gmail.com',
        'password' => 'khamim123',
    ]);

    // Lakukan asertasi sesuai dengan kebutuhan Anda
    $response->assertStatus(302); // Contoh asertasi pengalihan
        $response->assertRedirect('/superadmin'); // Periksa pengalihan ke halaman dashboard
        
    }

    /**
     * A login test with incorrect credentials.
     *
     * @return void
     */
    public function testLoginWithIncorrectCredentials()
    {
        $existingUser = User::where('email', 'anitadevi33@gmail.com')->first();

        // Melakukan login sebagai pengguna yang sudah ada
        $response = $this->actingAs($existingUser)->post('/login', [
            'email' => 'anitadevi33@gmail.com',
            'password' => 'khamim123',
        ]);

        // Memeriksa bahwa login gagal dan pengguna tidak diautentikasi
        $response->assertStatus(302); // Periksa pengalihan
        $response->assertRedirect('/login'); // Periksa pengalihan kembali ke halaman login
    }
}
