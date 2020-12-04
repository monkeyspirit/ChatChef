<?php
use App\DataLayer;
$dl = new \App\DataLayer();

$user = $dl->getUserbyUsername($_SESSION['loggedName']);
$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if ($recipe_ok->approved == 1 || $recipe_ok->approved == 3) {
        array_push($recipes, $recipe_ok);
    }
}

$all_user = $dl->getAllUsername();
?>


@extends('utils.base_page')

@section('title', 'Gestione degli Account')

{{--@section('right_navbar')
    <li class="nav-item pr-2 pb-1">
        <img style="border-radius: 100px; height: 40px; width: 40px;"
             @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
             src="{{asset('image/default_user/paw.jpg')}}"
             @else
             src="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
            @endif
        >
    </li>
    <li class="nav-item">
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle active " type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $loggedName }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @include('utils.rightnavbar', ['active'=>"5"])
                <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
            </div>
        </div>
    </li>
@endsection--}}

@section('body')

    <script> // questo aggiunge la classe active all'elemento "le mie ricette" nel menu
        $('#navbar2-accounts').addClass('active');
    </script>

    <!-- Header -->
    {{--
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
    --}}

    <h1 class="h-title text-center mt-5 ">@lang('labels.accountManagement')</h1>


    <div class="container-lg">

        <div class="w-100 border-bottom mb-4"></div>

{{--        <div class="justify-content-center pt-2 pb-1">--}}
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">@lang('labels.modalLoginUsername')</th>
                    <th scope="col" class="d-none d-lg-flex">@lang('labels.modalRegEmail')</th>
                    <th scope="col">@lang('labels.role')</th>
                    <th scope="col">@lang('labels.banState')</th>
                </tr>
                </thead>
                <tbody>

                @foreach($all_user as $user_s)
                    <tr>
                        <td>{{$user_s->username}}</td>
                        <td class="d-none d-lg-block">{{($dl->getUserbyUsername($user_s->username))->email}}</td>
                        <td>
                            <div class="form-inline flex-nowrap">
                                <div class="pr-3">
                                    <?php
                                    $id = ($dl->getUserbyUsername($user_s->username))->id;
                                    ?>
                                    <select class="custom-select" id="role_select{{$id}}" name="role_select{{$id}}" {{ ($user_s->username == $user->username) ? 'disabled' : '' }}>
                                    {{-- <?php
                                        $role_name = "";

                                        if (($dl->getUserbyUsername($user_s->username))->isAdmin) {

                                            if (session()->has('language')) {
                                                if (session('language') == "it") {
                                                    $role_name = "Admin";
                                                } elseif (session('language') == "en") {
                                                    $role_name = "Admin";
                                                }
                                            } else {
                                                $role_name = "Admin";
                                            }


                                        } else if (($dl->getUserbyUsername($user_s->username))->isEditor) {
                                            if (session()->has('language')) {
                                                if (session('language') == "it") {
                                                    $role_name = "Editor";
                                                } elseif (session('language') == "en") {
                                                    $role_name = "Editor";
                                                }

                                            } else {
                                                $role_name = "Editor";
                                            }

                                        } else if (($dl->getUserbyUsername($user_s->username))->isModerator) {
                                            if (session()->has('language')) {
                                                if (session('language') == "it") {
                                                    $role_name = "Moderatore";
                                                } elseif (session('language') == "en") {
                                                    $role_name = "Moderator";
                                                }

                                            } else {
                                                $role_name = "Moderatore";
                                            }

                                        } else {
                                            if (session()->has('language')) {
                                                if (session('language') == "it") {
                                                    $role_name = "Utente Normale";
                                                } elseif (session('language') == "en") {
                                                    $role_name = "Normal user";
                                                }
                                            } else {
                                                $role_name = "Utente Normale";
                                            }
                                        }
                                        ?>--}}
{{--                                        <option disabled selected>{{$role_name}}</option>--}}
                                        <option value="0" >@lang('labels.normalUser')</option>
                                        <option value="1" {{ ($dl->getUserbyUsername($user_s->username))->isAdmin ? 'selected' : ''  }}>@lang('labels.admin')</option>
                                        <option value="2" {{ ($dl->getUserbyUsername($user_s->username))->isEditor ? 'selected' : ''  }}>@lang('labels.editor')</option>
                                        <option value="3" {{ ($dl->getUserbyUsername($user_s->username))->isModerator ? 'selected' : ''  }}>@lang('labels.moderator')</option>
                                    </select>
                                </div>

                                <button name="{{$id}}" class="btn btn-outline-primary change" {{ ($user_s->username == $user->username) ? 'disabled' : '' }}>
                                    @lang('labels.save')
                                </button>
                            </div>
                        </td>
                        <td class="d-flex flex-nowrap">
                            <label for="customSwitch-{{ $user_s->username }}">@lang('labels.unbanned')</label>
                            <label class="switch mx-2">
                                <input class="ban-switch" name="{{$id}}" type="checkbox" id="customSwitch-{{ $user_s->username }}" {{ ($dl->getUserbyUsername($user_s->username))->ban ? 'checked' : '' }} >
                                <span class="slider round bg-red"></span>
                            </label>
                            <label for="customSwitch-{{ $user_s->username }}">@lang('labels.banned')</label>
                        </td>

                        {{--@if(($dl->getUserbyUsername($user_s->username))->ban)
                            <td>
                                <button name="{{$id}}"
                                        class="btn btn-outline-success unban">@lang('labels.unban')</button>
                            </td>
                        @else
                            <td>
                                <button name="{{$id}}" class="btn btn-outline-danger ban">@lang('labels.ban')</button>
                            </td>
                        @endif--}}

                    </tr>
                    {{--
                    <script>
                        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
                        var urlChange = '{{route('change_role')}}';
                        var urlBan = '{{route('ban')}}';
                        var urlUnban = '{{route('unban')}}';


                        $(".change").click(function (event) {
                            event.preventDefault();
                            var select_id = "role_select" + this.name;

                            $.ajax({
                                method: 'POST',
                                url: urlChange,
                                data: {
                                    user_id: this.name,
                                    role: document.getElementById(select_id).value,
                                    _token: token
                                },
                                success: function (response) {
                                    window.location.reload();

                                }
                            })


                        });

                        $(".ban").click(function (event) {
                            event.preventDefault();
                            $.ajax({
                                method: 'POST',
                                url: urlBan,
                                data: {user_id: this.name, _token: token},
                                success: function (response) {
                                    window.location.reload();

                                }
                            })


                        });
                        $(".unban").click(function (event) {
                            event.preventDefault();

                            $.ajax({
                                method: 'POST',
                                url: urlUnban,
                                data: {user_id: this.name, _token: token},
                                success: function (response) {
                                    window.location.reload();

                                }
                            })


                        });
                    </script> --}}

                @endforeach
                </tbody>
            </table>

{{--        </div>--}}

        <script>
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var urlChange = '{{route('change_role')}}';
            var urlBan = '{{route('ban')}}';
            var urlUnban = '{{route('unban')}}';

            $(".change").click(function (event) {
                event.preventDefault();
                var select_id = "role_select" + this.name;

                $.ajax({
                    method: 'POST',
                    url: urlChange,
                    data: {
                        user_id: this.name,
                        role: document.getElementById(select_id).value,
                        _token: token
                    },
                    success: function (response) {
                        window.location.reload();

                    }
                })


            });


            $(".ban-switch").click(function (event) {

                $.ajax({
                    method: 'POST',
                    url: (this.checked) ? urlBan : urlUnban,
                    data: {user_id: this.name, _token: token},
                    success: function (response) {
                        window.location.reload();
                    }
                })

            });

        </script>


{{--        <div class="row content">--}}
{{--            <div class="custom-control custom-switch">--}}
{{--                <input type="checkbox" class="custom-control-input" id="customSwitch1">--}}
{{--                <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label>--}}
{{--            </div>--}}
{{--            <div class="custom-control custom-switch">--}}
{{--                <input type="checkbox" class="custom-control-input" id="customSwitch2">--}}
{{--                <label class="custom-control-label" for="customSwitch2">Toggle this switch element</label>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

@endsection

