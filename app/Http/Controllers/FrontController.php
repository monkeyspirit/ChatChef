<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataLayer;

class FrontController extends Controller
{
    public function getHome()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('home')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('home')->with('logged',false);
        }
    }

    public function getCredits()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('credits')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('credits')->with('logged',false);
        }
    }

    public function getAll()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('account_all_recipes')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('error_view')->with('logged',false);
        }
    }
    public function getFav()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('account_favorites')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('error_view')->with('logged',false);
        }
    }
    public function getSetting()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('account_settings')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('error_view')->with('logged',false);
        }
    }
    public function getRecipe($id)
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            $dl = new DataLayer();
            $recipes = $dl->getAllRecipe();
            foreach ($recipes as $recipe){
                if($id == $recipe->id){
                    if($recipe->approved == 1 || $recipe->approved == 3){
                        return view('recipe_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('id', $id);
                    }
                    else if($recipe->approved == 0 && ($dl->getUserbyUsername($_SESSION['loggedName']))->role == 1) {
                        return view('recipe_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('id', $id);
                    }
                    else if($recipe->user_id == ($dl->getUserIDbyUsername($_SESSION['loggedName']))) {
                        return view('recipe_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('id', $id);
                    }
                    return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
                }
            }
            return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);


        } else {
            $dl = new DataLayer();
            $recipes = $dl->getAllRecipe();
            foreach ($recipes as $recipe){
                if($id == $recipe->id){
                    if($recipe->approved == 1 || $recipe->approved == 3){
                        return view('recipe_view')->with('logged',false)->with('id', $id);
                    }
                    else{
                        return view('error_view')->with('logged',false);
                    }
                }
            }
            return view('error_view')->with('logged',false);
        }
    }



    public function getInsert()
    {
        session_start();
        $dl = new DataLayer();
        if(isset($_SESSION['logged'])) {
            if(($dl->getUserbyUsername($_SESSION['loggedName']))->ban == 0){
                return view('insert_recipe')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
            else{
                return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
        } else {
            return view('error_view')->with('logged',false);
        }
    }
    public function getEdit($id)
    {
        session_start();
        $dl = new DataLayer();
        $rec = $dl->getRecipeByID($id);

        if(isset($_SESSION['logged'])) {
            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if ($user->id == $rec->user_id || $user->role == 2){
                return view('edit_recipe')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('id', $id);
            }
            else{
                return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
        } else {
            return view('error_view')->with('logged',false);
        }
    }

    public function getDelete($id)
    {
        session_start();
        $dl = new DataLayer();
        $rec = $dl->getRecipeByID($id);

        if(isset($_SESSION['logged'])) {
            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if ($user->id == $rec->user_id){
                return view('delete_recipe')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('id', $id);

            }
            else{
                return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
        } else {
            return view('error_view')->with('logged',false);
        }
    }

    public function getSearch()
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('search')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        } else {
            return view('search')->with('logged',false);
        }
    }

    public function getSearchResult($array)
    {
        session_start();
        if(isset($_SESSION['logged'])) {
            return view('search_result')->with('logged',true)->with('loggedName', $_SESSION['loggedName'])->with('array',$array);
        } else {
            return view('search_result')->with('logged',false)->with('array',$array);
        }
    }

    public function getApproved(){
        session_start();
        $dl = new DataLayer();

        if(isset($_SESSION['logged'])) {

            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if($user->role==1){
                return view('approved')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
            return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        }
        else {
            return view('error_view')->with('logged',false);
        }
    }

    public function getReview(){
        session_start();
        $dl = new DataLayer();

        if(isset($_SESSION['logged'])) {
            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if($user->role==2){
                return view('review')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
            return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        }
        else {
            return view('error_view')->with('logged',false);
        }
    }


    public function getManagement(){
        session_start();
        $dl = new DataLayer();

        if(isset($_SESSION['logged'])) {
            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if($user->role==1){
                return view('account_management')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
            return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        }
        else {
            return view('error_view')->with('logged',false);
        }
    }


    public function error(){
        session_start();
        $dl = new DataLayer();

        if(isset($_SESSION['logged'])) {
            return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        }
        else {
            return view('error_view')->with('logged',false);
        }
    }

    public function getForgotScreen(){
        session_start();
        $dl = new DataLayer();

        if(isset($_SESSION['logged'])) {
            return view('forgot')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
        }
        else {
            return view('forgot')->with('logged',false);
        }
    }

}
