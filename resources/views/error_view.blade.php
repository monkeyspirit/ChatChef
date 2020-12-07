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



?>

@extends('utils.base_page')

@section('title', 'Error')

@section('right_navbar')
    @if($logged)
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
                    @include('utils.rightnavbar', ['active'=>"0"])
                    <a class="dropdown-item" href="{{route('logout')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>
    @else
        <li class="nav-item">
            <button type="button" class="btn my-btn-primary" data-toggle="modal" data-target="#loginRegModal">
                @lang('labels.loginButton')
            </button>
        </li>
    @endif
@endsection


@section('body')


    <div class="container text-center p-4">
        <h1 class="h-title">
           @lang('labels.wentWrong')
        </h1>
        {{--<img src="{{asset('image/doodle/doodle-error.jpg')}}" width="200" height="60" alt="">--}}
    </div>
    <div class="container text-center p-1">
        <a href="{{route('home')}}" class="btn my-btn-outline-primary">@lang('labels.goBackHome')</a>
    </div>


    <div class="container col-sm-4">
        <img src="{{asset('image/error/concepto-landing-page-fallo-tecnico/2668387.jpg')}}" width="100%" alt="">
    </div>



@endsection
