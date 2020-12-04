<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$recipe = $dl->getRecipeByID($id);
$user = $dl->getUserByID($recipe->user_id);

$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

?>

@extends('utils.base_page')

@section('title', 'Delete recipe')

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
                <button class="btn btn-outline-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $loggedName }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('utils.rightnavbar', ['active'=>"0"])
                    <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>

@endsection

@section('body')
<div class="container" id="move">



    <div class="container text-center p-4">
       {{-- <img src="{{asset('image/doodle/square-line1.jpg')}}" width="450" height="40" alt="">--}}
        <h1 class="h-title">
            @lang('labels.delteButtonMyRec')
        </h1>
        {{--<img src="{{asset('image/doodle/square-line1.jpg')}}" width="450" height="40" alt="">--}}
    </div>

    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="card w-75">
                <div class="card-body">
                    <h5 class="card-title">@lang('labels.delete1') <strong>{{$recipe->title}}</strong>?</h5>
                    <p class="card-text">@lang('labels.delete2')</p>
                    <div class="row justify-content-around">
                        <a href="{{route('account_all_recipes')}}" class="btn btn-outline-primary">@lang('labels.cancel')</a>
                        <a href="{{route('delete_recipe',['id'=>$recipe->id])}}" class="btn btn-danger">@lang('labels.delteButtonMyRec')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <lottie-player id="moveme-lottie" src="https://assets6.lottiefiles.com/private_files/lf30_GjhcdO.json"  background="transparent"  speed="1"  style="width: 400px; height: 400px;" hover   autoplay></lottie-player>
                <script>
                    var animation = document.getElementById("moveme-lottie");
                    $("#move").mouseover(function(){
                        animation.play();
                    });
                    $("#move").mouseleave(function(){
                        animation.stop();
                    });

                </script>
            </div>
        </div>
    </div>

</div>


    <div class="content">
        <br/>

        <br/>
        <br/>
        <br/>
    </div>



@endsection

