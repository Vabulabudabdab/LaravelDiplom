<?php
namespace App\Http\Controllers;
session_start();

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $user;

    private $usermodel;

    public function __construct(UserService $userService, User $user) {
        $this -> user = $userService;
        $this -> usermodel = $user;
    }

    function register(Request $request) {
        $this->usermodel->register($request);
        return redirect('/login');
    }


    function loginUser(Request $request) {
        $this->usermodel->loginUser($request);
        return redirect('/');
    }

    function logout() {
        $this->usermodel->logout();
        return redirect('/');
    }

    function deleteUser($id) {
        $this->usermodel->deleteUser($id);
        return redirect('/');
    }

    function statusEdit(Request $request, $id) {
        $this->usermodel->statusEdit($request, $id);
        return redirect('/');
    }

    function editMail(Request $request, $id) {
        $this->usermodel->editMail($request, $id);
        return redirect('/');
    }

    function editdate(Request $request, $id) {
        $this->usermodel->editdate($request, $id);
        return redirect('/');
    }

    function newUser(Request $request) {
        $this->usermodel->newUser($request);
        return redirect('/');
    }

}

