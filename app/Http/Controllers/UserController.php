<?php
namespace App\Http\Controllers;
session_start();

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller {


    function register(Request $request) {

        $email = $request->post('email');

        $password = $request->post('password');

        $hashedPassword = Hash::make($password);

        $test = DB::table('users')->select('email')->where('email', $email)->exists();

        if($test == true) {
            $request->session()->flash('alreadyExists', 'Данный пользователь уже существует');
            return redirect('/register');
        } else {
            DB::table('users')->insert(
                ['email' => $email, 'password' => $hashedPassword]
            );

            $request->session()->flash('forLogin', 'Успешная регистрация!');
            return redirect('/login');
        }
    }


    function loginUser(Request $request) {

        $email = $request->post('email');

        $password = $request->post('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            echo "true";
            return redirect('/');
        } else {
            $request->session()->flash('notValid', 'Неверный логин или пароль');
            return redirect('/login');
        }
    }
}
