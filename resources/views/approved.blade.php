<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}


$count_waiting = 0;

foreach ($recipes_all as $recipe_state) {
    if($recipe_state->approved == 0){
        $count_waiting++;
    }
}
$count_added = 0;

foreach ($recipes as $recipe_state) {
    if($recipe_state->approved == 3){
        $count_added++;
    }
}

$count_approved = 0;
$count_denied = 0;
foreach ($recipes_all as $recipe) {
    if( ($recipe->user_id == ($dl->getUserbyUsername($loggedName))->id) && ( ($recipe->approved == 3) ) ){
        $count_approved++;
    }
    elseif ( ($recipe->user_id == ($dl->getUserbyUsername($loggedName))->id) && ( ($recipe->approved == 2) ) ){
        $count_denied++;
    }
}


?>

@extends('utils.base_page')

@section('title', 'Approved')

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
            <button class="btn btn-outline-secondary dropdown-toggle " type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $loggedName }}
            </button>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- No idea why include doesn't work -->
                <a class="dropdown-item " href="{{route('account_all_recipes')}}">@lang('labels.recipeAll') <span class="badge badge-success">{{$count_approved}}</span> <span class="badge badge-danger">{{$count_denied}}</span></a>
                <a class="dropdown-item " href="{{route('account_favorites')}}">@lang('labels.recipeFav')</a>
                <a class="dropdown-item " href="{{route('account_settings')}}">@lang('labels.settings')</a>
                 @if(($dl->getUserbyUsername($loggedName))->isModerator)
	 				<a class="dropdown-item active" href="{{route('approved')}}">@lang('labels.revised') <span class="badge badge-primary">{{$count_waiting}}</span></a>
                @endif
                @if(($dl->getUserbyUsername($loggedName))->isAdmin)
                    <a class="dropdown-item " href="{{route('account_management')}}">@lang('labels.accountManagement')</a>
                @endif
                @if(($dl->getUserbyUsername($loggedName))->isEditor)
                   <a class="dropdown-item " href="{{route('review')}}">@lang('labels.recentlyAdded') <span class="badge badge-primary">{{$count_added}}</span></a>
				@endif
                <!-- -->
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
                               src="{{asset('/icons/open-letter.json')}}"
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
            <h1 class="h-title">@lang('labels.revised')</h1>
            <div class="row align-self-center pl-5">
                <lottie-player id="secs-lottie"
                               src="{{asset('/icons/document.json')}}"
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
            @foreach($recipes_all as $recipe)
                @if($recipe->approved==0)
                    @include('utils.card_view_recipe_home',['recipe'=>$recipe])
                @endif
            @endforeach
        </div>
    </div>


    <script type="text/javascript">
        $(window).load(function () {
            $('.post-module').hover(function () {
                $(this).find('.description').stop().animate({
                    height: "toggle",
                    opacity: "toggle"
                }, 300);
            });

        });
    </script>


    <div class="content">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>

    </div>
@endsection

