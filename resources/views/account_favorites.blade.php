<?php
$dl = new \App\DataLayer();
$user = $dl->getUserbyUsername($_SESSION['loggedName']);
$favorites_id = $dl->getFavoritesArray($user->favorites);
$favorite_list = explode("_", $favorites_id[0]);
array_pop($favorite_list);

$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

?>

@extends('utils.base_page')

@section('title', 'Favorites')

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
                    @include('utils.rightnavbar', ['active'=>"2"])
                    <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>
@endsection

@section('body')


    <script> // questo aggiunge la classe active all'elemento "le mie ricette" nel menu
        $('#navbar2-favorites').addClass('active');
    </script>

    <!-- Header -->
    <div id="parent-setting" class="container text-center p-4">
        {{--<img src="{{asset('image/doodle/doodle1.jpg')}}" width="200" height="60" alt="">--}}

        <div class="d-flex justify-content-center">
            {{--<div class="row  align-self-center pr-5">
                <lottie-player id="setf-lottie"
                               src="{{asset('/icons/bookmark-in-book.json')}}"
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

            </div>--}}
            <h1 class="h-title">@lang('labels.recipeFav')</h1>
            {{--<div class="row align-self-center pl-5">
                <lottie-player id="secs-lottie"
                               src="{{asset('/icons/heart-in-hand.json')}}"
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

            </div>--}}
        </div>

        <img src="{{asset('image/doodle/doodle2.jpg')}}" width="200" height="60">
    </div>

<!-- Card recipes in groups-->

@if($favorites_id[0]==NULL)
    <div class="container ">
        <div class="text-center" style="font-family: 'Amatic SC', cursive; font-size: 40px; color: #6c757d">
            @lang('labels.nothingHere')
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <lottie-player src="https://assets5.lottiefiles.com/packages/lf20_QIvVpl.json"  background="transparent"  speed="1" hover autoplay></lottie-player>
            </div>
        </div>

    </div>
    <div class="content">
        <br/>
        <br/>
        <br/>
    </div>
@else
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
            @foreach($favorite_list as $id)
                <?php
                $recipe = $dl->getRecipeByID($id);
                $firstCover = $dl->getFirstCoverImage($id);
                $author = $dl->getUserByID($recipe->user_id);
                ?>
                     <div class="col mb-3" onclick="window.location.href='{{route('recipe_view',['id'=>$recipe->id])}}'">

                        <div  class="container-card" >
                            <div class="column">
                                <!-- Post-->
                                <div class="post-module">
                                    <!-- Thumbnail-->
                                    <div class="thumbnail">
                                        <img src="{{asset($firstCover)}}"  alt="...">
                                    </div>
                                    <!-- Post Content-->
                                    <div class="post-content">

                                        <h1 class="title link pb-0">{{$recipe->title}}</h1>
                                        <div class="text-center pt-0">
                                            <img src="{{asset('image/doodle/doodle-home.jpg')}}" width="250" height="40" alt="">
                                        </div>

                                        <h2 class="sub_title">@lang('labels.labelCardHome') {{$author->firstname}} {{$author->lastname}}</h2>
                                        <p style="height:140px; overflow-y: scroll;" class="description">{{$recipe->description}}<p class="description text-center"><a class="btn my-btn-outline-primary" href="{{route('recipe_view',['id'=>$recipe->id])}}">@lang('labels.buttonGoto')</a></p></p>

                                        <!--<div class="post-meta"><span class="timestamp"><i class="fa fa-clock-">o</i> 6 mins ago</span><span
                                                class="comments"><i class="fa fa-comments"></i><a href="#"> 39 comments</a></span></div>-->
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

            @endforeach

        </div>
    </div>

    <div class="content">
        <br/>
        <br/>
        <br/>
    </div>
@endif



<script>
    $(window).load(function() {
        $('.post-module').hover(function() {
            $(this).find('.description').stop().animate({
                height: "toggle",
                opacity: "toggle"
            }, 300);
        });

    });
</script>


@endsection
