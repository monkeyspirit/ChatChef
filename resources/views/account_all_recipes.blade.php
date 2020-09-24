<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$user_id = $dl->getUserIDbyUsername( $_SESSION['loggedName']);
$recipes_user = $dl->getUserRecipe($user_id);

$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

?>

@extends('utils.base_page')

@section('title', 'All recipe')

@section('right_navbar')
    <li class="nav-item pr-2 pb-1">
        <img style="border-radius: 100px; height: 40px; width: 40px;"
             @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
             src="{{asset('image/default_user/paw.jpg')}}"
             @else
             src ="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
            @endif
        >
    </li>
        <li class="nav-item">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle active " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $loggedName }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('utils.rightnavbar', ['active'=>"1"])
                    <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>
@endsection

@section('body')

    <!-- Header -->
    <div id="parent-setting" class="container text-center p-4">
        <img src="{{asset('image/doodle/doodle1.jpg')}}" width="200" height="60" alt="">

        <div class="d-flex justify-content-center">
            <div class="row  align-self-center pr-5">
                <lottie-player id="setf-lottie"
                               src="{{asset('/icons/book.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>
                    var setf_animation = document.getElementById("setf-lottie");
                    $("#parent-setting").mouseover(function () {
                        setf_animation.play();
                    });
                    $("#parent-setting").mouseleave(function () {
                        setf_animation.stop();
                    });

                </script>

            </div>
            <h1 class="h-title">@lang('labels.recipeAll')</h1>
            <div class="row align-self-center pl-5">
                <lottie-player id="secs-lottie"
                               src="{{asset('/icons/pencil.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>
                    var sets_animation = document.getElementById("secs-lottie");
                    $("#parent-setting").mouseover(function () {
                        sets_animation.play();
                    });
                    $("#parent-setting").mouseleave(function () {
                        sets_animation.stop();
                    });

                </script>

            </div>
        </div>

        <img src="{{asset('image/doodle/doodle2.jpg')}}" width="200" height="60">
    </div>



    <!-- Card recipes -->
    <div class="container">


        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @if(($dl->getUserbyUsername($loggedName))->ban == 0)
                @include('utils.card_view_insert_recipe')
            @endif
            @foreach($recipes_user as $recipe)
                @include('utils.card_view_recipe_account',['recipe'=>$recipe])
            @endforeach
        </div>
    </div>


    <div class="content">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

    </div>



@endsection
