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


$count_wainting = 0;
foreach ($recipes_all as $recipe_state) {
    if($recipe_state->approved == 0){
        $count_wainting++;
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
<a class="dropdown-item <?php if($active == "1"){ echo "active";} ?> " href="{{route('account_all_recipes')}}">@lang('labels.recipeAll') <span class="badge badge-success">{{$count_approved}}</span> <span class="badge badge-danger">{{$count_denied}}</span></a>
<a class="dropdown-item <?php if($active == "2"){ echo "active";} ?>" href="{{route('account_favorites')}}">@lang('labels.recipeFav')</a>
<a class="dropdown-item <?php if($active == "3"){ echo "active";} ?>" href="{{route('account_settings')}}">@lang('labels.settings')</a>
@if(($dl->getUserbyUsername($loggedName))->role == 1)
    <a class="dropdown-item <?php if($active == "4"){ echo "active";} ?>" href="{{route('approved')}}">@lang('labels.revised') <span class="badge badge-primary">{{$count_wainting}}</span></a>
    <a class="dropdown-item <?php if($active == "5"){ echo "active";} ?>" href="{{route('account_management')}}">@lang('labels.accountManagement')</a>
@endif
@if(($dl->getUserbyUsername($loggedName))->role == 2)
    <a class="dropdown-item <?php if($active == "6"){ echo "active";} ?>" href="{{route('review')}}">@lang('labels.recentlyAdded') <span class="badge badge-primary">{{$count_added}}</span></a>
@endif

