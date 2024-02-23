<?php
namespace App\Http\Controllers;
session_start();

use App\Models\User;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $user;
    public function __construct(UserService $userService) {
        $this -> user = $userService;
    }

    function register(Request $request) {
        $email = $request->post('email');

        $password = $request->post('password');

        $hashedPassword = Hash::make($password);

        $adress = "";

        $status = "Онлайн";

        $name = 'Не указано';

        $workplace = 'Не указано';

        $telephone = 'Не указан';

        $vk = 'Не указано';

        $telegram = "Не указано";

        $instagram = "Не указано";

        $image = "kot.jpg";

        $test = DB::table('users')->select('email')->where('email', $email)->exists();

        if ($test == true) {
            $request->session()->flash('alreadyExists', 'Данный пользователь уже существует');
            return redirect('/register');
        } else {
            DB::table('users')->insert(
                ['email' => $email, 'password' => $hashedPassword, 'name' => $name, 'workplace' => $workplace, 'telephone' => $telephone,
                    'adress' => $adress,'status' => $status, 'vk' => $vk, 'telegram' => $telegram, 'instagram' => $instagram,'avatar' => $image, 'updated_at' => date('Y-m-d H:i:s')]
            );

            $request->session()->flash('forLogin', 'Успешная регистрация!');
            return redirect('/login');
        }
    }


    function loginUser(Request $request)
    {

        if(!empty(Session::get('email'))) {
            $request->session()->flash('existsLogin', 'Вы уже вошли');
            return redirect('/login');
        }
        $email = $request->post('email');

        $password = $request->post('password');

        $session = DB::table('users')->select('email')->where('email', $email)->get();

        $permission = DB::table('users')->select('email')->where('email', $email)->where('permissions', 'admin')->exists();


        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            Auth::user()->isAdmin();

            Session::put('email', $email);

            if($permission) {
                Session::put('permission', 'admin');
            }


            return redirect('/');
        } else {
            $request->session()->flash('notValid', 'Неверный логин или пароль');
            return redirect('/login');
        }

    }

    function logout()
    {
        Auth::logout();
        Session::forget('email');
        Session::forget('permission');
        session_destroy();
        return redirect('/');
    }

    function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        Session::put('deleted', 'Пользователь успешно удалён...');
        return redirect('/');
    }

    function statusEdit(Request $request, $id) {

        $status = $request->post('status');

        $query = DB::table('users')->select('*')->where('id', $id)->get()->first();

        DB::table('users')->where('id', $id)->update(
            ['status' => $status]
        );
        Session::put('HasUpdated', 'Профиль успешно обновлён!');
        return redirect('/');
    }

    function editMail(Request $request, $id) {

        $email = $request->post('email');

        $oldpass = $request->post('oldpassword');

        $newpass = $request->post('newpassword');


        $hash = Hash::make($newpass);
        $query = DB::table('users')->select('*')->where('id', $id)->get()->first();

        $existsUser = DB::table('users')->select('*')->where('email', $email)->exists();

        if($existsUser) {
            Session::put('alrexistsemail', 'Данный email уже занят!');
            return redirect('/');
        } else {
            $user = User::find($id);

            $user->password = Hash::make($newpass);

            $user->save();

            DB::table('users')->where('id', $id)->update(
                ['email' => $email]
            );
            Session::put('HasUpdated', 'Профиль успешно обновлён!');
        }



        return redirect('/');

    }

    function editdate(Request $request, $id) {

        $name = $request->post('name');

        $workplace = $request->post('workplace');

        $telephone = $request->post('telephone');

        $adress =  $request->post('adress');

        DB::table('users')->where('id', $id)->update(
            ['name' => $name, 'workplace' => $workplace, 'telephone' => $telephone, 'adress' => $adress]
        );
        Session::put('HasUpdated', 'Профиль успешно обновлён!');
        return redirect('/');
    }

    function newUser(Request $request) {

        $name = $request->post('name');

        $workplace = $request->post('workplace');

        $telephone = $request->post('telephone');

        $adress =  $request->post('adress');

        $email = $request->post('email');

        $password = $request->post('password');

        $status = $request->post('status');

        $avatar = $request->post('avatar');

        $vk = $request->post('vk');

        $telegram = $request->post('telegram');

        $instagram = $request->post('instagram');

        $image = $request->file('avatar');

        $hashedPassword = Hash::make($password);

        $test = DB::table('users')->select('email')->where('email', $email)->exists();

        if ($test) {
            $request->session()->flash('cantcreate', 'Данный пользователь уже существует');
            return redirect('/');
        } else {
            DB::table('users')->insert(
                ['email' => $email, 'password' => $hashedPassword, 'name' => $name, 'workplace' => $workplace, 'telephone' => $telephone,
                 'adress' => $adress,'status' => $status, 'vk' => $vk, 'telegram' => $telegram, 'instagram' => $instagram,'avatar' => $image->store('uploads'), 'updated_at' => date('Y-m-d H:i:s')]
            );

            $request->session()->flash('successCreate', 'Пользователь успешно добавлен!');
            return redirect('/');
        }

    }

}

