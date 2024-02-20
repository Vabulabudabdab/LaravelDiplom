<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    function registerPage () {
        return view('page_register');
    }

    function users() {
        return view('users');
    }

    function login() {
        return view('page_login');
    }

    function page_profile() {
        return view('page_profile');
    }

    function security() {
        return view('security');
    }

    function changeStatus() {
        return view('status');
    }

    function media() {
        return view('media');
    }

    function createUser() {
        return view('create_user');
    }

    function editUser() {
        return view('edit');
    }

}
