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


$recipes_searched = array();
$id = json_decode($array);


foreach ($id as $id_recipe) {
    $rec = $dl->getRecipeByID($id_recipe);
    array_push($recipes_searched, $rec);
}

?>

@extends('utils.base_page')

@section('title', 'Advanced search')


@section('right_navbar')
    @if($logged)
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

{{--

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
--}}

    <div class="container">
        <h1 class="h-title text-center my-5">
            @lang('labels.searchResults')
        </h1>
{{--
        <div class="row justify-content-around">
            <div class="pb-2 pr-5 pl-5">
                <a href="{{route('search')}}" class="btn btn-outline-primary">@lang('labels.goBackSearch')</a>
            </div>
            <div class=" pr-5 pl-5">
                <a href="{{route('home')}}" class="btn btn-outline-primary">@lang('labels.goBackHome')</a>
            </div>
        </div>
        --}}
    </div>


    <div id="doggie-parent" class="container pt-5">

        @if(count($recipes_searched) != 0)
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach($recipes_searched as $recipe_searched)

                    @include('utils.card_view_recipe_home',['recipe'=>$recipe_searched])

                @endforeach
            </div>
        @else

            <div class="row justify-content-center">
                <div class="col-md-4 col-sm-12">
                    <lottie-player id="doggie-lottie" src="https://assets3.lottiefiles.com/packages/lf20_C31OHO.json" background="transparent"
                                   speed="1" style="width: 400px; height: 400px;" autoplay></lottie-player>
                    <script>
                        var doggie_animation = document.getElementById("doggie-lottie");
                        $("#doggie-parent").mouseover(function () {
                            doggie_animation.play();
                        });
                        $("#doggie-parent").mouseleave(function () {
                            doggie_animation.stop();
                        });

                    </script>

                </div>

            </div>

        @endif

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


    <div class="row content">
        <br/>
        <br/>
    </div>
@endsection
