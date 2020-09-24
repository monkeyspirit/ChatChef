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

$list_ingredients = $dl->getAllIngredients();

$list_tags = array("First dish","Main course","Dessert","Appetizer", "Side dish" ,"Meat", "Fish", "Vegetarian", "Vegan", "Gluten Free", "Without allergens");

$users = $dl->getAllUsername();


?>

@extends('utils.base_page')

@section('title', 'Advanced search')


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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginRegModal">
                @lang('labels.loginButton')
            </button>
        </li>
    @endif
@endsection

@section('body')

 <!-- Header -->
    <div id="parent-title" class="container text-center p-4">
        <img src="{{asset('image/doodle/doodle10.jpg')}}" width="350" height="60">
        <div class="d-flex justify-content-center">
            <div class="row  align-self-center pr-4">
                <lottie-player id="fir-lottie"
                               src="{{asset('/icons/light-on.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;position: relative;"

                >
                </lottie-player>
                <script>
                    var fir_animation = document.getElementById("fir-lottie");
                    $("#parent-title").mouseover(function () {
                        fir_animation.play();
                    });
                    $("#parent-title").mouseleave(function () {
                        fir_animation.stop();
                    });

                </script>

            </div>
            <h1 class="h-title">
                @lang('labels.advancedsearch')
            </h1>
            <div class="row align-self-center pl-4">
                <lottie-player id="sec-lottie"
                               src="{{asset('/icons/searching.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>
                    var sec_animation = document.getElementById("sec-lottie");
                    $("#parent-title").mouseover(function () {
                        sec_animation.play();
                    });
                    $("#parent-title").mouseleave(function () {
                        sec_animation.stop();
                    });

                </script>

            </div>
        </div>

        <img src="{{asset('image/doodle/doodle10.jpg')}}" width="350" height="60">
    </div>

    <div class="container col-lg-6 col-md-8 col-sm-12">
        <div class="card border-info">
            <div class="card-body">
                @lang('labels.advanceSearchdescription')
            </div>
        </div>
    </div>

    <form action="{{route('search_advanced')}}" method="post">
        @csrf
        <div class="container text-center p-4">
            <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                @lang('labels.chooseMethodSearch')
            </p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="custom-control custom-switch custom-control-inline">
                                <span class="pr-5">@lang('labels.atleast')</span>
                                <input type="checkbox" class="custom-control-input" name="method__research__toggle" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">@lang('labels.everything')</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Ingredients checkboxes-->
        <div class="container text-center p-4">
            <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                @lang('labels.chooseIngredients')
            </p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($list_ingredients as $item)
                                <div class="custom-control custom-control-inline custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" name="{{$item}}" id="{{$item}}">
                                    <label class="custom-control-label" for="{{$item}}">{{$item}}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container text-center p-4">
            <p style="font-family: 'Amatic SC', cursive; font-size: 40px">
                @lang('labels.chooseTags')
            </p>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach($list_tags as $tag)
                                <div class="custom-control custom-control-inline custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" name="{{$tag}}" id="{{$tag}}">
                                    <label class="custom-control-label" for="{{$tag}}">{{$tag}}</label>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container pt-4 pb-4">
            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary">@lang('labels.searchPlaceholder')</button>
            </div>
        </div>



    </form>





@endsection
