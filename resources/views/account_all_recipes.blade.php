<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$user_id = $dl->getUserIDbyUsername( $_SESSION['loggedName']);
$recipes_user = $dl->getUserRecipe($user_id);

$recipe_appproved = array();
$recipe_notapproved = array();
$recipe_waiting = array();

foreach ($recipes_user as $recipe_user) {
    if($recipe_user->approved == 0){
        array_push($recipe_waiting, $recipe_user);
    }
    elseif($recipe_user->approved == 2){
        array_push($recipe_notapproved, $recipe_user);
    }
    else{
        array_push($recipe_appproved, $recipe_user);
    }
}

//Questo sotto serve per la tendina
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

@section('right_navbar') {{-- questo non lo usa più --}}
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

    <script> // questo aggiunge la classe active all'elemento "le mie ricette" nel menu
        $('#navbar2-myrecipes').addClass('active');
    </script>

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



        @if(($dl->getUserbyUsername($loggedName))->ban == 0)
            @include('utils.card_view_insert_recipe')
        @endif

        <br>
        <div class="text-center">
            <h2 class="text-center pt-0 pb-0" style="font-family: 'Fredericka the Great', cursive">@lang('labels.waiting recipes')</h2>
            <button value="0" onclick="change_arrow(this)" class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse_waiting" aria-expanded="false" aria-controls="collapseExample">
                <i class="las la-angle-down"></i>
            </button>
        </div>
        <br>
        <div class="collapse" id="collapse_waiting">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach($recipe_waiting as $recipe)
                    @include('utils.card_view_recipe_account',['recipe'=>$recipe])
                @endforeach
            </div>
        </div>
            <hr>
        <br>
            <div class="wrap"><span class="arrow"><span></span><span></span></span><span class="arrow--l-r right"><span></span><span></span><span></span><span></span><span></span></span></div>
            <div class="text-center">
                <h2 class="text-center pt-0 pb-0" style="font-family: 'Fredericka the Great', cursive">@lang('labels.not approved recipes')</h2>
                <button value="0" onclick="change_arrow(this)" class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse_notapproved" aria-expanded="false" aria-controls="collapseExample">
                    <i class="las la-angle-down"></i>
                </button>
            </div>
        <br>

        <div class="collapse" id="collapse_notapproved">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach($recipe_notapproved as $recipe)
                    @include('utils.card_view_recipe_account',['recipe'=>$recipe])
                @endforeach
            </div>
        </div>
        <br>
            <hr>
            <div class="text-center">
                <h2 class="text-center pt-0 pb-0" style="font-family: 'Fredericka the Great', cursive">@lang('labels.approved recipes')</h2>
                <button value="0" onclick="change_arrow(this)" class="btn btn-outline-secondary"  type="button" data-toggle="collapse" data-target="#collapse_approved" aria-expanded="false" aria-controls="collapseExample">
                    <i class="las la-angle-down"></i>
                </button>

            </div>

        <br>

        <div class="collapse" id="collapse_approved">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach($recipe_appproved as $recipe)
                    @include('utils.card_view_recipe_account',['recipe'=>$recipe])
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function change_arrow(btn){
            if (btn.value === "0") {
                btn.innerHTML = "<i class=\"las la-angle-up\"></i>";
                btn.value = "1";
            } else {
                btn.innerHTML = "<i class=\"las la-angle-down\"></i>";
                btn.value = "0";
            }
        }
    </script>

    <div class="content">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

    </div>



@endsection
