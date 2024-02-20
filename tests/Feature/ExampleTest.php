<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\UserController;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase {
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/'); //Путь, где будем проводить сам тест, а теперь осталось скачать саму разметку

        $response->assertStatus(200); //Всё работает
    }


    public function testget_user(): void {

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testlogin(): void {

        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function testanotherRegister(): void {
        $response = $this->get('/loginUser');

    }
    public function testanotherLogin(Request $request): void {
        $email = $request->post('email');

        $password = $request->post('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            echo "true";

        } else {
            $request->session()->flash('notValid', 'Неверный логин или пароль');

        }
    }


}
