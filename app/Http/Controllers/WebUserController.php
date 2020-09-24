<?php

namespace App\Http\Controllers;

use App\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Str;class WebUserController extends Controller
{
    public function changePassword($id, Request $request){
        session_start();
        $dl = new DataLayer();
        $new =  $request->input('new_password');
        $new_enc = md5($new);
        $dl->editUserPassword($id, $new_enc);

        return redirect()->back();
    }

    public function changeInformation($id, Request $request){
        session_start();
        $dl = new DataLayer();

        $firstname = $request->input('firstname');
        $lastname =  $request->input('lastname');
        $birthday =  $request->input('birthday');
        $email =  $request->input('email');

        $dl->editUserInformation($id, $firstname, $lastname, $birthday, $email);

        return redirect()->back();
    }


    public function changeRole(Request $request){
        session_start();
        $dl = new DataLayer();
        $user_id =  $request->input('user_id');
        $role = $request->input('role');

        $dl->editUserRole($user_id, $role);

        return redirect()->back();
    }

    public function banUser(Request $request){
        session_start();
        $dl = new DataLayer();
        $user_id =  $request->input('user_id');


        $dl->banUser($user_id);

        return redirect()->back();
    }


    public function unbanUser(Request $request){
        session_start();
        $dl = new DataLayer();
        $user_id =  $request->input('user_id');


        $dl->unbanUser($user_id);

        return redirect()->back();
    }

    public function changeImageUser(){
        session_start();
        $dl = new DataLayer();

        $id = $_POST['id'];
        $user = $dl->getUserByID($id);

        echo "<pre>", print_r($_POST), "</pre>";
        echo $id;
        echo "<pre>", print_r($_FILES), "</pre>";


        $path='user_profile/'. $id.'/';

        if($user->image_profile == NULL){
            mkdir($path,0777,true);
        }


        move_uploaded_file($_FILES['profile_input']['tmp_name'], $path . $_FILES['profile_input']['name']);
        $path_image = $path . $_FILES['profile_input']['name'];

        $dl->changeImageProfile($id, $path_image);

        return redirect()->back();
    }

    public function forgotPassword(Request $request)
    {
        session_start();
        $dl = new DataLayer();

        $subject_lang = array("1" => "ChatChef :: Password recovery", "2" => "ChatChef :: Recupero password");
        $message_lang = array("1" => "This is your new password!\nRemember to change it the first time you log in.\n", "2" => "Questa è la tua nuova password!\nRicordati di cambiarla al tuo primo accesso.\n");

        $username = $request->input('username');

        $user = $dl->getUserbyUsername($username);


        $password_size = 10;
        $new_password = "";

        for ($x = 1; $x <= $password_size; $x++) {
            if ($x % 2) {
                $new_password = $new_password . chr(rand(97, 122));
            } else {
                $new_password = $new_password . rand(0, 9);
            }
        }

        //English default
        $index = 1;
        if (session()->has('language')) {
            if (session('language') == "it") {
                $index = 2;
            }
        }

        $to_email = $user->email;
        $subject = $subject_lang[$index];
        $message = $message_lang[$index] . $new_password;
        $headers = 'From: chatchefmail@gmail.com';
        mail($to_email, $subject, $message, $headers);

        session()->put('send',1);

        $dl->editUserPassword($user->id, md5($new_password));

        return Redirect::route('forgot');

    }

}
