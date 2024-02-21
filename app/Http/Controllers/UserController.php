<?php
namespace App\Http\Controllers;
session_start();

use App\Models\User;
use App\Services\ImageService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use function Laravel\Prompts\table;

class UserController extends Controller
{

    function register(Request $request)
    {

        $email = $request->post('email');

        $password = $request->post('password');

        $hashedPassword = Hash::make($password);

        $test = DB::table('users')->select('email')->where('email', $email)->exists();

        if ($test == true) {
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


    function loginUser(Request $request)
    {

        $email = $request->post('email');

        $password = $request->post('password');

        $session = DB::table('users')->select('email')->where('email', $email)->get();

        Session::put('email', $email);
        $test = Session::get('email');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            return redirect('/');
        } else {
            $request->session()->flash('notValid', 'Неверный логин или пароль');
            return redirect('/login');
        }

    }

    function logout()
    {
        Session::forget('email');
        session_destroy();
        return redirect('/');
    }

    function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/');
    }

    function statusEdit(Request $request, $id) {

        $status = $request->post('status');

        $query = DB::table('users')->select('*')->where('id', $id)->get()->first();

        DB::table('users')->where('id', $id)->update(
            ['status' => $status]
        );
        return redirect('/');
    }

    function editMail(Request $request, $id) {

        $email = $request->post('email');

        $oldpass = $request->post('oldpassword');

        $newpass = $request->post('newpassword');

        $query = DB::table('users')->select('*')->where('id', $id)->get()->first();

        $fetchPass = DB::table('users')->select('password')->where('id', $id)->first();
        dd(Hash::check($fetchPass, $newpass));
        $user = User::find($id);
        $user->password = Hash::make($newpass);
        $user->save();

        DB::table('users')->where('id', $id)->update(
            ['email' => $email]
        );

//        DB::table('users')->where('id', $id)->update(
//            [
//             'email' => $email,
//             'password' => $newpass
//            ]
//        );
        return redirect('/');

    }
}

