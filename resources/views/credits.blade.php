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

?>

@extends('utils.base_page')

@section('title', 'Credits')

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
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginRegModal">
                @lang('labels.loginButton')
            </button>
        </li>
    @endif
@endsection

@section('body')


    <div class="container text-center p-4">
        <h1 class="h-title">
            @lang('labels.creditsTitle')
        </h1>
    </div>

    <div class="container full-height">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <img src="{{asset('image/credits/composicion-agradecimiento-dibujada-mano-confeti/blur-317644-P931HA-275.jpg')}}" alt="" class="d-block w-100">
            </div>
        </div>
    </div>

    <div class="container ">
        <div class="text-center">
            <br/>
            <h3>@lang('labels.creditsLinkImage')</h3>
            <br/>
        </div>
        <div>
            <a href="http://www.freepik.com">Designed by Freepik</a><br/>
            <a href="http://www.freepik.com">Designed by valeria_aksakova / Freepik</a><br/>
            <a href="http://www.freepik.com">Designed by timolina / Freepik</a><br/>
            <a href="http://www.freepik.com">Designed by rawpixel.com / Freepik</a><br/>
            <a href="https://www.freepik.com/free-photos-vectors/background">Background vector created by rawpixel.com - www.freepik.com</a><br/>
            Icons made by <a href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a><br/>
            Icons made by <a href="https://www.flaticon.com/free-icon/heart_1216575" title="itim2101">itim2101</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a><br/>
            <a href="http://www.freepik.com">Designed by slidesgo / Freepik</a><br/>
            <a href="https://www.freepik.com/free-photos-vectors/food">Food vector created by stories - www.freepik.com</a><br/>
            <a href="http://www.freepik.com">Designed by pikisuperstar / Freepik</a><br/>
            <a href="https://www.freepik.com/free-photos-vectors/technology">Technology vector created by freepik - www.freepik.com</a><br/>
            <a href="https://www.freepik.com/free-photos-vectors/party">Party vector created by freepik - www.freepik.com</a><br/>
            <a href="https://www.icons8.com">Icon made by Icons8</a><br/>
            <span>Article News Card: Made with <i class='fa fa-heart animated infinite pulse'></i> by <a href='http://andy.design'>Andy Tran</a> | Designed by <a href='http://justinkwak.com'>JustinKwak</a></span><br/>
            <a href='https://www.freepik.com/free-photos-vectors/cartoon'>Cartoon vector created by pch.vector - www.freepik.com</a><br/>
            <a href='https://www.freepik.com/free-photos-vectors/background'>Background photo created by freepik - www.freepik.com</a>
            <a href='https://www.freepik.com/vectors/people'>People vector created by pikisuperstar - www.freepik.com</a>
        </div>



    </div>

@endsection
