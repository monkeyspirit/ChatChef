<?php
use App\DataLayer;
$dl = new \App\DataLayer();

$user = $dl->getUserbyUsername( $_SESSION['loggedName']);
$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}

$all_user = $dl->getAllUsername();
?>


@extends('utils.base_page')

@section('title', 'Account management')

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
                @include('utils.rightnavbar', ['active'=>"5"])
                <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
            </div>
        </div>
    </li>
@endsection

@section('body')
    <!-- Header -->
    <div id="parent-setting" class="container text-center p-5">
        <img src="{{asset('image/doodle/doodle1.jpg')}}" width="200" height="60" alt="">

        <div class="d-flex justify-content-center">
            <div class="row  align-self-center pr-5">
                <lottie-player id="setf-lottie"
                               src="{{asset('/icons/tea.json')}}"
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

            </div>
            <h1 class="h-title">@lang('labels.accountManagement')</h1>
            <div class="row align-self-center pl-5">
                <lottie-player id="secs-lottie"
                               src="{{asset('/icons/photo-gallery.json')}}"
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

            </div>
        </div>

        <img src="{{asset('image/doodle/doodle2.jpg')}}" width="200" height="60">
    </div>



    <div class="container">

        <div class="row justify-content-center pt-2 pb-1">
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('labels.modalLoginUsername')</th>
                    <th scope="col">@lang('labels.modalRegEmail')</th>
                    <th scope="col">@lang('labels.role')</th>
                    <th scope="col">@lang('labels.banState')</th>
                </tr>
                </thead>
                <tbody>

                    @foreach($all_user as $user_s)
                        <tr>
                            <td>{{$user_s->username}}</td>
                            <td>{{($dl->getUserbyUsername($user_s->username))->email}}</td>
                            <td>
                                <div class="form-inline">
                                    <div class="pr-3">
                                    <?php
                                    $id = ($dl->getUserbyUsername($user_s->username))->id;
                                    ?>
                                        <select class="custom-select" id="role_select{{$id}}" name="role_select{{$id}}" >
                                            <?php
                                            $role_name = "";

                                            switch (($dl->getUserbyUsername($user_s->username))->role){

                                                case 0: {
                                                    if(session()->has('language')){
                                                        if(session('language')=="it"){
                                                            $role_name = "Utente Normale";
                                                        }
                                                        elseif(session('language')=="en"){
                                                            $role_name = "Normal user";
                                                        }
                                                    }
                                                    else{
                                                        $role_name = "Normal user";
                                                    }

                                                    break;
                                                }
                                                case 1: {
                                                    if(session()->has('language')){
                                                        if(session('language')=="it" || session('language')=="en"){
                                                            $role_name = "Admin";
                                                        }
                                                    }
                                                    else{
                                                        $role_name = "Admin";
                                                    }

                                                    break;
                                                }
                                                case 2: {
                                                    if(session()->has('language')){
                                                        if(session('language')=="it" || session('language')=="en"){
                                                            $role_name = "Editor";
                                                        }

                                                    }
                                                    else{
                                                        $role_name = "Editor";
                                                    }
                                                    break;
                                                }
                                            }
                                            ?>
                                            <option disabled selected>{{$role_name}}</option>
                                            <option value="0">@lang('labels.normalUser')</option>
                                            <option value="1">@lang('labels.admin')</option>
                                            <option value="2">@lang('labels.editor')</option>
                                        </select>
                                    </div>

                                    <button <?php if($user_s->username == $user->username){ echo "disabled"; }?> name="{{$id}}" class="btn btn-outline-primary change">Change role</button>
                                </div>
                            </td>
                            @if(($dl->getUserbyUsername($user_s->username))->ban)
                                <td><button name="{{$id}}" class="btn btn-outline-success unban">@lang('labels.unban')</button></td>
                            @else
                                <td><button name="{{$id}}" class="btn btn-outline-danger ban">@lang('labels.ban')</button></td>
                            @endif

                        </tr>
                        <script>
                            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
                            var urlChange = '{{route('change_role')}}';
                            var urlBan = '{{route('ban')}}';
                            var urlUnban = '{{route('unban')}}';


                            $(".change").click(function (event) {
                                event.preventDefault();
                                var select_id ="role_select"+this.name;

                                $.ajax({
                                    method: 'POST',
                                    url: urlChange,
                                    data: {user_id: this.name, role: document.getElementById(select_id).value , _token: token},
                                    success: function(response){
                                        window.location.reload();

                                    }
                                })


                            } );

                            $(".ban").click(function (event) {
                                event.preventDefault();
                                 $.ajax({
                                    method: 'POST',
                                    url: urlBan,
                                    data: {user_id: this.name, _token: token},
                                    success: function(response){
                                        window.location.reload();

                                    }
                                })


                            } );
                            $(".unban").click(function (event) {
                                event.preventDefault();

                                $.ajax({
                                    method: 'POST',
                                    url: urlUnban,
                                    data: {user_id: this.name, _token: token},
                                    success: function(response){
                                        window.location.reload();

                                    }
                                })


                            } );



                        </script>


                    @endforeach
                </tbody>
            </table>

        </div>



        <div class="row content">
            <br/>
            <br/>
            <br/>
        </div>
    </div>

@endsection

