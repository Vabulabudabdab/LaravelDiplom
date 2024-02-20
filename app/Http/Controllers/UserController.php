<?php
namespace App\Http\Controllers;
session_start();

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

        $session = DB::table('users')->select('email')->where('email', $email)->get();

        $ts = Session::put('email', $email);
        $test = Session::get('email');
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            echo "true";
            return redirect('/');
        } else {
            $request->session()->flash('notValid', 'Неверный логин или пароль');
            return redirect('/login');
        }

    }
}
