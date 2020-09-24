<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataLayer;
use Illuminate\Support\Facades\Redirect;


class AuthController extends Controller
{

    public function registration(Request $request){
        $dl = new DataLayer();

        $dl->addUser($request->input('username'),$request->input('firstname'),$request->input('lastname'), $request->input('birthday'),$request->input('email'),$request->input('password'));

        //Se tutto va a buon fine
        session_start();
        $_SESSION['logged'] = true;
        $_SESSION['loggedName'] = $request->input('username');


        //return Redirect::to(route('home'));
        return redirect()->back();
    }



    public function login(Request $request)
    {

        session_start();
        $dl = new DataLayer();

        $_SESSION['logged'] = true;
        $_SESSION['loggedName'] = $request->input('username');



        return redirect()->back();
    }



    public function logout() {

        session_start();

        session_destroy();

        //return Redirect::to(route('home'));
        return redirect()->back();
    }

    public function logoutHome() {

        session_start();
        session_destroy();

        return Redirect::to(route('home'));
    }


    public function auhtenticateUser(Request $request){
        session_start();
        $dl = new DataLayer();

        return $dl->validateUser($request->username, $request->password);
    }

    public function thereIsThatUser(Request $request){
        session_start();
        $dl = new DataLayer();

        return $dl->thereIsUser($request->username);
    }

}
