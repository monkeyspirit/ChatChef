<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$recipes_all = $dl->getAllRecipeAZ();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

$recipes_allDate= $dl->getAllRecipeDate();

$recipesDate = array();
foreach ($recipes_allDate as $recipe_okDate) {
    if($recipe_okDate->approved == 1 || $recipe_okDate->approved == 3){
        array_push($recipesDate, $recipe_okDate);
    }
}

// choosing daily recipes advices
$numRecipes = count($recipes);
$rand1 = rand(1, $numRecipes);
do {
    $rand2 = rand(1, $numRecipes);
} while($rand2 == $rand1);
do {
    $rand3 = rand(1, $numRecipes);
} while($rand3 == $rand1 || $rand3 == $rand2);

$recipes_carousel = array();
$recipes_carousel[0] = $recipes[$rand1-1];
$recipes_carousel[1] = $recipes[$rand2-1];
$recipes_carousel[2] = $recipes[$rand3-1];

$numRecipesPerPage = 3; // poi nella versione finale facciamo 6

?>

@extends('utils.base_page')

@section('title', 'ChatChef')

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
        <li class="nav-item pr-2 pb-1">
            <img style="border-radius: 100px; height: 40px; width: 40px;"
                 @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
                 src="{{asset('image/default_user/paw.jpg')}}"
                 @else
                 src ="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
                @endif
            >
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

    <div class="container text-center my-3">
        <h1 class="h-title mt-5">I consigli del giorno</h1>
        <div class="d-flex justify-content-center mb-4">
            <img src="{{asset('image/doodle/doodle3.jpg')}}" width="400" height="60" alt="">
        </div>
        <div id="carousel" class="carousel slide" data-ride="carousel" style="background-color: darkslategrey">
            {{-- <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol> --}}
            <div class="carousel-inner">
                <div class="carousel-item active" onclick="window.location.href='{{route('recipe_view',['id'=>$recipes_carousel[0]->id])}}'">
                    <?php
                    $cover1 = $dl->getFirstCoverImage($recipes_carousel[0]->id)
                    ?>
                    <img class="d-block w-100 home-carousel-image" src="{{ asset($cover1) }}" alt="First slide" >
                    <div class="carousel-caption d-block px-2" style="background: rgba(0, 0, 0, 0.3)">
                        <h2>{{ $recipes_carousel[0]->title }}</h2>
                        <p>{{ $recipes_carousel[0]->description }}</p>
                    </div>
                </div>
                <div class="carousel-item" onclick="window.location.href='{{route('recipe_view',['id'=>$recipes_carousel[1]->id])}}'">
                    <?php
                    $cover2 = $dl->getFirstCoverImage($recipes_carousel[1]->id)
                    ?>
                    <img class="d-block w-100 home-carousel-image" src="{{ asset($cover2) }}" alt="First slide" >
                    <div class="carousel-caption d-block px-2" style="background: rgba(0, 0, 0, 0.3)">
                        <h2>{{ $recipes_carousel[1]->title }}</h2>
                        <p>{{ $recipes_carousel[1]->description }}</p>
                    </div>
                </div>
                <div class="carousel-item" onclick="window.location.href='{{route('recipe_view',['id'=>$recipes_carousel[2]->id])}}'">
                    <?php
                    $cover3 = $dl->getFirstCoverImage($recipes_carousel[2]->id)
                    ?>
                    <img class="d-block w-100 home-carousel-image" src="{{ asset($cover3) }}" alt="First slide" >
                    <div class="carousel-caption d-block px-2" style="background: rgba(0, 0, 0, 0.3)">
                        <h2>{{ $recipes_carousel[2]->title }}</h2>
                        <p>{{ $recipes_carousel[2]->description }}</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>




    <div class="container pt-4 pb-4">
        {{-- OLD SORTING SECTION--}}
        {{--
        <div class="d-flex justify-content-center">
            <div id="click" onclick="fadeAZ()" class="row  align-self-center pr-5">
                <lottie-player background="transparent"
                               hover
                               id="az-lottie"
                               speed="1"
                               src="{{asset('/icons/AZ.json')}}"
                               style="width: 50px; height: 50px;position: relative;"

                >
                </lottie-player>
            </div>
            <script>


                function fadeAZ() {
                    document.getElementById("date").hidden = true;
                    document.getElementById("dateI").hidden = true;

                        if(document.getElementById("AZ").hidden) {
                            $(document.getElementById("ZA")).fadeOut();
                            document.getElementById("AZ").hidden = false;
                            $(document.getElementById("AZ")).fadeIn();
                            document.getElementById("ZA").hidden = true;

                        }
                        else{
                            $(document.getElementById("AZ")).fadeOut();
                            document.getElementById("ZA").hidden = false;
                            $(document.getElementById("ZA")).fadeIn();
                            document.getElementById("AZ").hidden = true;
                        }



                }

            </script>
            <h3 class="h-title">
                @lang('labels.homeTitle')
            </h3>
            <div onclick="fadeDate()" class="row align-self-center pl-5">
                <lottie-player id="date-lottie"
                               src="{{asset('/icons/calendar.json')}}"
                               background="transparent"
                               speed="1"
                               hover
                               style="width: 50px; height: 50px;"

                >
                </lottie-player>
                <script>

                    function fadeDate() {
                        document.getElementById("ZA").hidden = true;
                        document.getElementById("AZ").hidden = true;

                        if(document.getElementById("date").hidden) {
                            $(document.getElementById("dateI")).fadeOut();
                            document.getElementById("date").hidden = false;
                            $(document.getElementById("date")).fadeIn();
                            document.getElementById("dateI").hidden = true;
                        }
                        else{
                            $(document.getElementById("date")).fadeOut();
                            document.getElementById("dateI").hidden = false;
                            $(document.getElementById("dateI")).fadeIn();
                            document.getElementById("date").hidden = true;
                        }
                    }

                </script>

            </div>
        </div>
        <img src="{{asset('image/doodle/doodle6.jpg')}}" width="250" height="60" alt="">
        {{-- --}}

        <h1 class="h-title text-center mt-5 ">@lang('labels.homeTitle')</h1>
        <div class="d-flex justify-content-center">
        <img src="{{asset('image/doodle/doodle6.jpg')}}" width="250" height="60" alt="">
        </div>

        <form class="form-inline d-flex justify-content-end">
            <div class="form-group ">
                <label for="order-select" class="mx-3">@lang('labels.orderby')</label>
                <select class="form-control" id="order-select" onchange="changeOrder()">
                    <option >
                        @lang('labels.alphabeticalAZ')
                    </option>
                    <option>
                        @lang('labels.alphabeticalZA')
                    </option>
                    <option>
                        @lang('labels.date')
                    </option>
                    <option>
                        @lang('labels.dateInverse')
                    </option>
                </select>
            </div>

            <script>
                function changeOrder(){
                    switch(document.getElementById("order-select").selectedIndex) {
                        case 0:
                            document.getElementById("date").hidden = true;
                            document.getElementById("dateI").hidden = true;
                            $(document.getElementById("ZA")).fadeOut();
                            document.getElementById("ZA").hidden = true;
                            document.getElementById("AZ").hidden = false;
                            $(document.getElementById("AZ")).fadeIn();
                            break;
                        case 1:
                            document.getElementById("date").hidden = true;
                            document.getElementById("dateI").hidden = true;
                            $(document.getElementById("AZ")).fadeOut();
                            document.getElementById("AZ").hidden = true;
                            document.getElementById("ZA").hidden = false;
                            $(document.getElementById("ZA")).fadeIn();
                            break;
                        case 2:
                            document.getElementById("ZA").hidden = true;
                            document.getElementById("AZ").hidden = true;
                            $(document.getElementById("date")).fadeOut();
                            document.getElementById("date").hidden = true;
                            document.getElementById("dateI").hidden = false;
                            $(document.getElementById("dateI")).fadeIn();
                            break;
                        case 3:
                            document.getElementById("ZA").hidden = true;
                            document.getElementById("AZ").hidden = true;
                            $(document.getElementById("dateI")).fadeOut();
                            document.getElementById("dateI").hidden = true;
                            document.getElementById("date").hidden = false;
                            $(document.getElementById("date")).fadeIn();
                            break;
                    }
                }

            </script>
        </form>

        <div class="container my-3 border-bottom"></div>

        <!-- Card recipes IDate-->
        <div id="fade" class="container">
            <div id="AZ" class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach($recipes as $recipe)

                        @include('utils.card_view_recipe_home',['recipe'=>$recipe])

                @endforeach
            </div>
            <div id="ZA" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach(array_reverse($recipes) as $recipeZA)

                        @include('utils.card_view_recipe_home',['recipe'=>$recipeZA])

                @endforeach
            </div>
            <div id="date" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach( $recipesDate as $recipeDate)

                    @include('utils.card_view_recipe_home',['recipe'=>$recipeDate])

                @endforeach
            </div>
            <div id="dateI" hidden class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                @foreach(array_reverse($recipesDate) as $recipeDateI)

                    @include('utils.card_view_recipe_home',['recipe'=>$recipeDateI])

                @endforeach
            </div>

        </div>

        <!-- Pagination -->
        <script type="text/javascript">
            var currentPage;
            const numRecipesPerPage = {{ $numRecipesPerPage }};

            function changePage(numPage) {
                currentPage = numPage;
                $('#pagination-menu li').removeClass("active");
                $("#pag-"+numPage).addClass("active");

                $('#fade > div').each(function () {
                    let countRecipes = 0;
                    $(this).children().each(function () {
                        $(this).hide();
                        if (countRecipes >= (currentPage-1)*numRecipesPerPage && countRecipes < (currentPage)*numRecipesPerPage)
                            $(this).show();
                        countRecipes++;
                    });
                })

                if ( currentPage == 1 )
                    $('#pag-prev').addClass('disabled');
                else
                    $('#pag-prev').removeClass('disabled');


                if ( currentPage >= $('#pagination-menu > li').length-2 )
                    $('#pag-next').addClass('disabled');
                else
                    $('#pag-next').removeClass('disabled');
            }

            function nextPage() {
                changePage(currentPage+1);
            }

            function prevPage() {
                changePage(currentPage-1);
            }

            $(document).ready(function () {
                changePage(1);
            })

        </script>
        <div class="container d-flex justify-content-end my-2">
            <nav aria-label="Page navigation example">
                <ul id="pagination-menu" class="pagination">
                    <li class="page-item" id="pag-prev"><a class="my-page-link" href="#this" onclick="prevPage()" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a></li>
                    <?php
                        for ($i=1; $i < ($numRecipes/$numRecipesPerPage)+1; $i++) {
                            echo '<li class="page-item" id="pag-' . $i . '"><a class="page-link" href="#this" onclick="changePage(' . $i . ')">'. ($i) .'</a></li>';
                        }
                    ?>
                    <li class="page-item" id="pag-next"><a class="my-page-link" href="#this" onclick="nextPage()" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a></li>
                </ul>
            </nav>
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

@endsection
