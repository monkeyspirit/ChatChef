<!-- This is the html code for the rappresentation of the cards in the home screen.
     The cards are described by a:
     - title
     - tiny descripton
     - picture
     - last update
     - author
     -->

<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$firstCover = $dl->getFirstCoverImage($recipe->id);
$user = $dl->getUserByID($recipe->user_id);
$date = $recipe->date;
$date_array = date_parse($date);
$day = $date_array['day'];
$n_month = $date_array['month'];


$array_month_en = array("1"=>"Gen","2"=>"Feb","3"=>"Mar","4"=>"Apr","5"=>"May","6"=>"Jun","7"=>"Jul","8"=>"Aug","9"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec");
$array_month_it= array("1"=>"Gen","2"=>"Feb","3"=>"Mar","4"=>"Apr","5"=>"Mag","6"=>"Giu","7"=>"Lug","8"=>"Ago","9"=>"Set","10"=>"Ott","11"=>"Nov","12"=>"Dic");

$array_tag_en = array("1"=>"First dish","2" => "Main", "3" => "Dessert", "4" => "Appetizer", "5" => "Side dish", "6" => "Meat", "7" => "Fish", "8" => "Vegetarian", "9" => "Vegan", "10" => "Gluten Free", "11" => "Without allergens");
$array_tag_it = array("1"=>"Primo","2" => "Secondo", "3" => "Dolce", "4" => "Antipasto", "5" => "Contorno", "6" => "Carne", "7" => "Pesce", "8" => "Vegetariano", "9" => "Vegano", "10" => "Senza glutine", "11" => "Senza allergeni");


if(session()->has('language')){
    if(session('language') == "it"){
        $month = $array_month_it[$n_month];
        $tag = $array_tag_it[$recipe->tags[1]];
    }
    elseif (session('language') == "en"){
        $month = $array_month_en[$n_month];
        $tag = $array_tag_en[$recipe->tags[1]];
    }
}
else {
    $month = $array_month_en[$n_month];
    $tag = $array_tag_en[$recipe->tags[1]];
}


?>


<div class="col mb-3">

    <div  class="container-card">
        <div class="column">
            <!-- Post-->
            <div class="post-module">
                <!-- Thumbnail-->
                <div class="thumbnail">
                    <div class="date">
                        <div class="day">{{$day}}</div>
                        <div class="month">{{$month}}</div>
                    </div>
                    <img src="{{asset($firstCover)}}"  alt="...">
                </div>
                <!-- Post Content-->
                <div class="post-content">
                    <div class="category">{{$tag}}</div>
                    <h1 class="title link pb-0">{{$recipe->title}}</h1>
                    <div class="text-center pt-0">
                        <img src="{{asset('image/doodle/doodle-home.jpg')}}" width="250" height="40" alt="">
                    </div>

                    <h2 class="sub_title">@lang('labels.labelCardHome') {{$user->firstname}} {{$user->lastname}}</h2>

                    <p style="height:140px; overflow-y: scroll;" class="description">{{$recipe->description}}
                        <p class="description text-center">
                            <a class="btn btn-outline-primary" href="{{route('recipe_view',['id'=>$recipe->id])}}">@lang('labels.buttonGoto')</a>
                        </p>
                    </p>

                    <!--<div class="post-meta"><span class="timestamp"><i class="fa fa-clock-">o</i> 6 mins ago</span><span
                            class="comments"><i class="fa fa-comments"></i><a href="#"> 39 comments</a></span></div>-->
                </div>
            </div>
        </div>
    </div>


</div>
