<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$recipe = $dl->getRecipeByID($id);
$user = $dl->getUserByID($recipe->user_id);

$ingredients_n = explode("_",$recipe->ingredients_name);
$ingredients_qu = explode("/",$recipe->ingredients_quantity);
$ingredients_q = explode("_",$ingredients_qu[0]);
$ingredients_u = explode("_",$ingredients_qu[1]);
$number_ing = count($ingredients_n);

$array_ing_en=array("1"=>"ml","2"=>"g","3"=>"tbs","4"=>"units", "5"=>"quanto basta");
$array_ing_it=array("1"=>"ml","2"=>"g","3"=>"cucc.","4"=>"unità", "5"=>"quanto basta");

for($i=1; $i<$number_ing; $i++) {
    if(session()->has('language')){
        if(session('language')=="it"){
            $ingredients_u[$i] = $array_ing_it[$ingredients_u[$i]];
        }
        elseif (session('language')=="en"){
            $ingredients_u[$i] = $array_ing_en[$ingredients_u[$i]];
        }
    }
    else{
        $ingredients_u[$i] = $array_ing_it[$ingredients_u[$i]];
    }

}



$step_text = explode("_",$recipe->steps_text);
$step_image_id = explode("_",$recipe->steps_image);
$number_step = count($step_text);
$step_image = array();

for($i=1; $i<$number_step; $i++){
    $path = $dl->getImagePathFromID($step_image_id[$i]);
    array_push($step_image, $path);
}



$array_tag_en = array("1"=>"First dish","2" => "Main", "3" => "Dessert", "4" => "Appetizer", "5" => "Side dish", "6" => "Meat", "7" => "Fish", "8" => "Vegetarian", "9" => "Vegan", "10" => "Gluten Free", "11" => "Without allergens");
$array_tag_it = array("1"=>"Primo","2" => "Secondo", "3" => "Dolce", "4" => "Antipasto", "5" => "Contorno", "6" => "Carne", "7" => "Pesce", "8" => "Vegetariano", "9" => "Vegano", "10" => "Senza glutine", "11" => "Senza allergeni");

$tags = explode("_",$recipe->tags);
$number_tag = count($tags);
for($i=1; $i<$number_tag; $i++) {
    if(session()->has('language')){
        if(session('language')=="it"){
            $tags[$i] = $array_tag_it[$tags[$i]];
        }
        elseif (session('language')=="en"){
            $tags[$i] = $array_tag_en[$tags[$i]];
        }
    }
    else{
        $tags[$i] = $array_tag_it[$tags[$i]];
    }

}


$imageCover = $dl->getRecipeCovers($id);
$number_cover = count($imageCover);



$list_comment = $dl->getCommentByRecipe($id);
$number_comment = count($list_comment);


//modal form login register
$users = $dl->getAllUsername();

$n_user = count($users);




$user_logged = -1;
$istheauthor = false;
$isAEditor = false;
$isFav = false;
$isRewier = false;

if($logged){
    $isFav = $dl->isFavorite($id, $dl->getUserIDbyUsername($loggedName));
    $user_logged = $dl->getUserIDbyUsername($loggedName);
    if($user->id == $user_logged){
        $istheauthor = true;
    }
    $user_role = $dl->getUserbyUsername($loggedName);
    if($user_role->isEditor){
        $isAEditor = true;
    }
    if($user_role->isModerator && $recipe->approved==0){
        $isRewier = true;
    }
}

$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}


?>

@extends('utils.base_page')

@section('title', 'Recipe')

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
                <button class="btn btn-outline-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
    <div >



        <!-- Header -->
        <div class="container text-center p-4">
            <h1 class="h-title">
                {{$recipe->title}}
            </h1>
            <img src="{{asset('image/doodle/doodle-divider.jpg')}}" width="300" height="60">
        </div>
        @if($logged && ($recipe->approved == 1 || $recipe->approved == 3))
            <div class="container pt-5">
                <div class="justify-content-center">
                    <div class="text-center pb-5">

                        @if($isFav)
                            <button id="nofav" class="butt-nofav btn-my btn-outline-my dislike">

                                <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                    <div class="row justify-content-center align-self-center">
                                        @lang('labels.removeFav')
                                    </div>
                                    <div class="row justify-content-center align-self-center">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player id="nofav-lottie"
                                                       src="{{asset('/icons/broken-heart.json')}}"
                                                       background="transparent"
                                                       speed="1"
                                                       style="width: 30px; height: 30px;"
                                                       hover
                                        >
                                        </lottie-player>
                                    </div>
                                </div>

                            </button>
                            <script>
                                var nofavanim = document.getElementById("nofav-lottie");
                                $("#nofav").mouseover(function(){
                                    nofavanim.play();
                                });

                                $("#nofav").mouseleave(function(){
                                    nofavanim.stop();
                                });

                            </script>
                        @else
                            <button id="fav" class="butt-fav btn-my btn-outline-my like">

                                <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                    <div class="row justify-content-center align-self-center">
                                        @lang('labels.addFav')
                                    </div>
                                    <div class="row justify-content-center align-self-center">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player id="fav-lottie"
                                                       src="{{asset('/icons/heart-with-arrow.json')}}"
                                                       background="transparent"
                                                       speed="1"
                                                       style="width: 30px; height: 30px;"
                                                       hover
                                        >
                                        </lottie-player>
                                    </div>
                                </div>

                            </button>
                            <script>
                                var favanim = document.getElementById("fav-lottie");
                                $("#fav").mouseover(function(){
                                    favanim.play();
                                });

                                $("#fav").mouseleave(function(){
                                    favanim.stop();
                                });

                            </script>



                        @endif
                            <script>
                                $(".like").click(function (event) {
                                    event.preventDefault();

                                    $.ajax({
                                        method: 'POST',
                                        url: urlFavAdd,
                                        data: {user_id: {{ $user_logged }}, recipe_id: {{$id}}, _token: token},
                                        success: function(response){
                                           window.location.reload();

                                        }
                                    })


                                } );
                                $(".dislike").click(function (event) {
                                    event.preventDefault();
                                    $.ajax({
                                        method: 'POST',
                                        url: urlFavRemove,
                                        data: {user_id: {{ $user_logged }}, recipe_id: {{$id}}, _token: token},
                                        success: function(response){
                                            window.location.reload();


                                        }
                                    })
                                } );


                            </script>


                    </div>

                </div>


            </div>
        @endif

        @if($isRewier)
            <div class="container pb-5">
                <div class="text-center">
                    <label for="comment">@lang('labels.insertCommentAdmin')</label><br/>
                    <textarea rows="3" class="col-md-6" name="comment" id="comment"></textarea>

                </div>
                <div class="pt-2 row justify-content-around">

                        <button id="accept-button" class="butt-accept btn-my btn-outline-success-my accept">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                    @lang('labels.accept')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="accept-lottie"
                                                   src="{{asset('/icons/edit-ok.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 30px; height: 30px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </button>
                        <script>
                            var acceptanimation = document.getElementById("accept-lottie");

                            $("#accept-button").mouseover(function () {
                                acceptanimation.play();
                            });
                            $("#accept-button").mouseleave(function () {
                                acceptanimation.stop();
                            });


                        </script>



                        <button id="decline-button" class="butt-decline btn-my btn-outline-danger-my decline">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                  @lang('labels.decline')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="decline-lottie"
                                                   src="{{asset('/icons/edit-cancel.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 30px; height: 30px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </button>
                        <script>
                            var declineanimation = document.getElementById("decline-lottie");

                            $("#decline-button").mouseover(function () {
                                declineanimation.play();
                            });
                            $("#decline-button").mouseleave(function () {
                                declineanimation.stop();
                            });


                        </script>


                </div>

            </div>
            <script>
                $(".accept").click(function (event) {
                    event.preventDefault();

                    $.ajax({
                        method: 'POST',
                        url: urlAccept,
                        data: {recipe_id: {{$id}}, comment: $('#comment').val(),  _token: token},
                        success: function(response){
                            window.location.href = "{{url('/approved')}}";

                        }
                    })


                } );
                $(".decline").click(function (event) {
                    event.preventDefault();
                    $.ajax({
                        method: 'POST',
                        url: urlDecline,
                        data: {recipe_id: {{$id}},  comment: document.getElementById('comment').value , _token: token},
                        success: function(response){
                            window.location.href = "{{url('/approved')}}";


                        }
                    })
                } );


            </script>

        @elseif($istheauthor || $isAEditor )

            @if($istheauthor &&  $recipe->approved==2)
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-sm-12">
                            <div class="card border-danger text-center">
                                <div class="card-header text-danger">
                                    @lang('labels.viewComment')
                                </div>
                                <div class="card-body">
                                    <p>{{$recipe->comment}}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endif

            <div class="container pt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center pb-5">
                        @if($recipe->approved!=0)
                        <a id="edit{{$recipe->id}}" class="butt-edit btn-my btn-outline-my"
                           href="{{route('edit',['id'=>$recipe->id])}}">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                    @lang('labels.editTitle')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="edit-lottie{{$recipe->id}}"
                                                   src="{{asset('/icons/edit.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 30px; height: 30px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>


                            </div>

                        </a>
                        <script>
                            var editanimation{{$recipe->id}} = document.getElementById("edit-lottie{{$recipe->id}}");

                            $("#edit{{$recipe->id}}").mouseover(function () {
                                editanimation{{$recipe->id}}.play();
                            });
                            $("#edit{{$recipe->id}}").mouseleave(function () {
                                editanimation{{$recipe->id}}.stop();
                            });


                        </script>
                        @endif

                    </div>
                </div>
            </div>

        @endif




    <!-- Carousel-->
    <div class="container justify-content-center" style="display:flex;">
        <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel" >
            <ol class="carousel-indicators">
            <?php

            for($i=0; $i<$number_cover; $i++){
                if($i==0){
                    echo '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>';
                }
                else{
                    echo ' <li data-target="#carouselExampleIndicators" data-slide-to="'.$i.'"></li>';
                }
            }
            ?>
            </ol>
            <div class="carousel-inner">
                <?php

                for($i=0; $i<$number_cover; $i++){
                    if($i==0){
                        echo '<div class="carousel-item active ">
                                    <div class="contorno-bianco">
                                        <img src="'.asset($imageCover[$i]->picture_path).'" class="d-block altezza" alt="...">
                                    </div>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5></h5>
                                    </div>
                                </div>';
                    }
                    else{
                        echo '<div class="carousel-item ">
                                    <div class="contorno-bianco">
                                        <img src="'.asset($imageCover[$i]->picture_path).'" class="d-block altezza" alt="...">
                                    </div>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5></h5>
                                    </div>
                                </div>';
                    }
                }

                ?>


            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <!-- Description -->

    <div class="container pt-4 pb-4">
        <h3 class="h-title text-center" style="font-size: 50px">
            @lang('labels.description')
        </h3>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <p>{{$recipe->description}}</p>
            </div>
        </div>

    </div>


        <!-- Informazioni e card-->
    <div class="container pt-3">

        <div id="parent" class="card border-0 pb-3">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                <div class="col">
                    <div class="card border-0 mb-3 ">
                        <div  class="card-body">
                            <!-- Informazioni autore e data -->
                            <div class="d-flex justify-content-center">
                                <div class="row  align-self-center pr-4 pb-4">
                                    <lottie-player id="info-lottie"
                                                   src="{{asset('/icons/book.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 40px; height: 40px;"

                                    >
                                    </lottie-player>
                                    <script>
                                        var info_animation = document.getElementById("info-lottie");
                                        $("#parent").mouseover(function () {
                                            info_animation.play();
                                        });
                                        $("#parent").mouseleave(function () {
                                            info_animation.stop();
                                        });

                                    </script>

                                </div>

                                <p class="text-center" style="font-family: 'Amatic SC', cursive; font-size: 30px"> @lang('labels.information') <br></p>
                            </div>
                            <p class="pl-5" >@lang('labels.labelCardHome') {{$user->firstname}} {{$user->lastname}}
                                <img style="border-radius: 100px; height: 30px; width: 30px;"
                                     @if($user->image_profile == NULL)
                                     src="{{asset('image/default_user/paw.jpg')}}"
                                     @else
                                     src ="{{asset($user->image_profile)}}"
                                    @endif
                                >
                            </p>
                            <p class="pl-5">{{$recipe->date}}</p>
                            <p class="pl-5">
                                <?php
                                for ($i = 1; $i < $number_tag; $i++) {
                                    echo '<strong>'.$tags[$i].'</strong><br/> ';
                                }
                                ?>
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col ">

                    <div class="card border-0 mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <div class="row  align-self-center pr-4 pb-4">
                                    <lottie-player id="know-lottie"
                                                   src="{{asset('/icons/down-arrow.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 40px; height: 40px;"

                                    >
                                    </lottie-player>
                                    <script>
                                        var know_animation = document.getElementById("know-lottie");
                                        $("#parent").mouseover(function () {
                                            know_animation.play();
                                        });
                                        $("#parent").mouseleave(function () {
                                            know_animation.stop();
                                        });

                                    </script>

                                </div>
                                <p class="text-center" style="font-family: 'Amatic SC', cursive; font-size: 30px"> @lang('labels.toKnow') <br/>
                            </div>
                            <!--Informazioni ricetta -->
                            <p class="pl-5"><img src="{{asset('image/icons_View/recipe-book.png')}}" class="icon">  @lang('labels.difficult'):
                                <strong>@if($recipe->difficult == 1) @lang('labels.easy') @elseif($recipe->difficult == 1) @lang('labels.mid') @else @lang('labels.expert') @endif</strong>
                            </p>
                            <p class="pl-5"><img src="{{asset('image/icons_View/hand_kitchen_mixer_icon.png')}}" class="icon">  @lang('labels.preptime'):  <strong>{{$recipe->preparation_time}}</strong> min.</p>
                            <p class="pl-5"><img src="{{asset('image/icons_View/kitchen_pot_restaurant_icon.png')}}" class="icon">   @lang('labels.cookingtime'):   <strong>{{$recipe->cooking_time}}</strong> min.</p>
                            <p class="pl-5"><img src="{{asset('image/icons_View/kitchen_scale_machine_icon.png')}}" class="icon">  @lang('labels.doses'):  <strong> {{$recipe->doses}}</strong> @lang('labels.people')</p>

                        </div>
                    </div>

                </div>
                <div class="col ">
                    <div class="card border-0 mb-3">
                        <div class="card-body ">

                            <div class="d-flex justify-content-center">
                                <div class="row  align-self-center pr-4 pb-4">
                                    <lottie-player id="ing-lottie"
                                                   src="{{asset('/icons/list-is-empty.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 35px; height: 35px;"

                                    >
                                    </lottie-player>
                                    <script>
                                        var ing_animation = document.getElementById("ing-lottie");
                                        $("#parent").mouseover(function () {
                                            ing_animation.play();
                                        });
                                        $("#parent").mouseleave(function () {
                                            ing_animation.stop();
                                        });

                                    </script>

                                </div>
                                <p class="text-center" style="font-family: 'Amatic SC', cursive; font-size: 30px"> @lang('labels.ingr')</p> <br/>
                            </div>

                            <!-- Ingredienti -->

                            <p class="pl-5">
                                @for($i=1; $i<$number_ing; $i++)

                                    - @if($ingredients_u[$i] != "quanto basta") {{$ingredients_q[$i]}} @endif {{$ingredients_u[$i]}} @lang('labels.conj') {{$ingredients_n[$i]}} <br/>
                                @endfor
                            </p>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="container pt-3">

        <div class="container text-center pt-4 pb-4">
            <h3 class="h-title" style="font-size: 50px">
                @lang('labels.method')
            </h3>
            <img  src="{{asset('image/doodle/doodle-divider2.jpg')}}" width="220" height="20" alt="">
        </div>
        <div class="card border-0 ">
            <div class="card-body">


                <!-- card del procedimento, ognuna dotata di immagine -->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3">

                    @for($i=1; $i<$number_step; $i++)
                        <div class="col mb-4">
                            <div class="card">
                                <img src="{{asset($step_image[$i-1])}}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{$i}}</h5>
                                    <p class="card-text">{{$step_text[$i]}}</p>

                                </div>
                            </div>
                        </div>

                    @endfor

                </div>

            </div>
        </div>
    </div>

    @if($logged && $isAEditor && $recipe->approved == 3)
            <div class="container pt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center pb-5">
                        <button id="correct-button" class="butt-correct btn-my btn-outline-success-my correct">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                   @lang('labels.sign')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="correct-lottie"
                                                   src="{{asset('/icons/edit-ok.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 30px; height: 30px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </button>
                        <script>
                            var setcorrectanimation = document.getElementById("correct-lottie");

                            $("#correct-button").mouseover(function () {
                                setcorrectanimation.play();
                            });
                            $("#correct-button").mouseleave(function () {
                                setcorrectanimation.stop();
                            });


                        </script>
                        <script>
                            $(".correct").click(function (event) {
                                event.preventDefault();

                                $.ajax({
                                    method: 'POST',
                                    url: urlcorrect,
                                    data: {recipe_id: {{$id}}, _token: token},
                                    success: function(response){
                                        window.location.reload();

                                    }
                                })


                            } );
                        </script>
                    </div>
                </div>
            </div>


    @endif





    <div class="container text-center pt-4 pb-4">
        <h3 class="h-title" style="font-size: 50px">
            @lang('labels.commentTitle')
        </h3>
        <img  src="{{asset('image/doodle/doodle-comment.jpg')}}" width="250" height="60" alt="">
    </div>

        @if($logged && ($recipe->approved == 1 || $recipe->approved == 3))
            <div class="container pt-5">
                <div class="justify-content-center">
                    {{--<div class="col-md-6 text-center pb-5">

                        @if($isFav)
                            <button id="nofav" class="butt-nofav btn-my btn-outline-my dislike">

                                <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                    <div class="row justify-content-center align-self-center">
                                        @lang('labels.removeFav')
                                    </div>
                                    <div class="row justify-content-center align-self-center">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player id="nofav-lottie"
                                                       src="{{asset('/icons/broken-heart.json')}}"
                                                       background="transparent"
                                                       speed="1"
                                                       style="width: 30px; height: 30px;"
                                                       hover
                                        >
                                        </lottie-player>
                                    </div>
                                </div>

                            </button>
                            <script>
                                var nofavanim = document.getElementById("nofav-lottie");
                                $("#nofav").mouseover(function(){
                                    nofavanim.play();
                                });

                                $("#nofav").mouseleave(function(){
                                    nofavanim.stop();
                                });

                            </script>
                        @else
                            <button id="fav" class="butt-fav btn-my btn-outline-my like">

                                <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                    <div class="row justify-content-center align-self-center">
                                        @lang('labels.addFav')
                                    </div>
                                    <div class="row justify-content-center align-self-center">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player id="fav-lottie"
                                                       src="{{asset('/icons/heart-with-arrow.json')}}"
                                                       background="transparent"
                                                       speed="1"
                                                       style="width: 30px; height: 30px;"
                                                       hover
                                        >
                                        </lottie-player>
                                    </div>
                                </div>

                            </button>
                            <script>
                                var favanim = document.getElementById("fav-lottie");
                                $("#fav").mouseover(function(){
                                    favanim.play();
                                });

                                $("#fav").mouseleave(function(){
                                    favanim.stop();
                                });

                            </script>



                        @endif
                            <script>
                                $(".like").click(function (event) {
                                    event.preventDefault();

                                    $.ajax({
                                        method: 'POST',
                                        url: urlFavAdd,
                                        data: {user_id: {{ $user_logged }}, recipe_id: {{$id}}, _token: token},
                                        success: function(response){
                                           window.location.reload();

                                        }
                                    })


                                } );
                                $(".dislike").click(function (event) {
                                    event.preventDefault();
                                    $.ajax({
                                        method: 'POST',
                                        url: urlFavRemove,
                                        data: {user_id: {{ $user_logged }}, recipe_id: {{$id}}, _token: token},
                                        success: function(response){
                                            window.location.reload();


                                        }
                                    })
                                } );


                            </script>


                    </div>--}}

                    @include('utils.modal_comment')
                    <div class="text-center pb-5">
                        @if(($dl->getUserbyUsername($loggedName))->ban == 0)
                            <button id="comment" class="butt-comment btn-my btn-outline-my"  data-toggle="modal" data-target="#commentmodal">

                                <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                    <div class="row justify-content-center align-self-center">
                                        @lang('labels.addCommentRecipe')
                                    </div>
                                    <div class="row justify-content-center align-self-center">
                                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                        <lottie-player id="comment-lottie"
                                                       src="{{asset('/icons/speech.json')}}"
                                                       background="transparent"
                                                       speed="1"
                                                       style="width: 30px; height: 30px;"
                                                       hover
                                        >
                                        </lottie-player>
                                    </div>
                                </div>

                            </button>
                            <script>
                                var commentanim = document.getElementById("comment-lottie");
                                $("#comment").mouseover(function(){
                                    commentanim.play();
                                });

                                $("#comment").mouseleave(function(){
                                    commentanim.stop();
                                });

                            </script>
                        @endif

                    </div>

                </div>


            </div>
    @endif

    <!-- Commenti -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12">
            @for($i=0; $i<$number_comment; $i++)
                <?php
                $user = $list_comment[$i]->user_id;
                $username = $dl->getUserByID($user)->username;
                $date = $list_comment[$i]->date;
                $text =  $list_comment[$i]->text;

                ?>


                <div class="conteiner pt-3 pb-3">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text"><strong>{{$username}}</strong> {{$date}}<br>{{$text}}</p>
                        </div>
                    </div>
                </div>


            @endfor
            </div>
        </div>

        </div>
    </div>
    </div>

    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var urlFavAdd = '{{route('favoriteAdd')}}';
        var urlFavRemove = '{{route('favoriteRemove')}}';
        var urlAccept = '{{route('acceptRecipe')}}';
        var urlDecline = '{{route('declineRecipe')}}';
        var urlcorrect = '{{route('correctRecipe')}}';
    </script>


@endsection
