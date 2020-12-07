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



?>

@extends('utils.base_page')

@section('title', 'ChatChef')


@section('body')

    <!-- Header -->
    <div id="parent-title" class="container text-center pt-5 p-4">

        <div class="d-flex justify-content-center">
           {{-- <div class="row  align-self-center pr-4">
                <lottie-player id="fir-lottie"
                               src="{{asset('/icons/unlock.json')}}"
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

            </div>--}}
            <h1 class="h-title">
                @lang('labels.forgotTitle')
            </h1>
            {{--<div class="row align-self-center pl-4">
                <lottie-player id="sec-lottie"
                               src="{{asset('/icons/compass.json')}}"
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

            </div>--}}
        </div>

        {{--<img src="{{asset('image/doodle/doodle-error.jpg')}}" width="350" height="60">--}}
    </div>
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card border-info">
                    <div class="card-body">
                        <p>@lang('labels.descriptionRecovery')</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets8.lottiefiles.com/packages/lf20_GIqo2k.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;" hover   autoplay></lottie-player>
        </div>
    </div>

    @if(!(session()->has('send')))
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <script>
                            function validateFormPassword() {
                                var username = document.forms['forgotPassword_form']['username'].value;

                                var thereis = 1;
                                var token = '{{\Illuminate\Support\Facades\Session::token()}}';

                                var urlUser = '{{route('thereIs')}}';

                                $.ajax({
                                    method: 'POST',
                                    url: urlUser,
                                    data: {username: username, _token: token},
                                    async: false,
                                    success: function(response){
                                        thereis = response ;
                                    }
                                });

                                if (thereis != 1 )  {
                                    @if(session()->has('language'))
                                    @if(session('language') == "it")
                                    swal("C'è un errore!", "Non c'è nessun utente con quel nome.", "error");
                                    return false;
                                    @elseif (session('language') == "en")
                                    swal("There is an error!", "There isn't anybody with that username.", "error");
                                    return false;

                                    @endif
                                    @else
                                    swal("There is an error!", "There isn't anybody with that username.", "error");
                                    return false;
                                    @endif


                                } else {
                                    return true;
                                }


                            }
                        </script>


                        <form id="forgotPassword_form" onsubmit="return validateFormPassword()" action="{{route('forgot')}}"
                              method="post">
                            @csrf
                            <div class="form-group">
                                <label for="username">@lang('labels.modalLoginUsername')</label>
                                <input required type="username" class="form-control" name="username">
                            </div>
                            <div class="text-center">
                                <input style="width: 100px;" class="btn my-btn-primary" type="submit" value=@lang('labels.recovery')>

                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @elseif(session('send') == 1)
        <?php
        session()->forget('send');
        ?>
        <div class="container pb-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-12">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <p>@lang('labels.sendMail')</p>
                            <div class=" pb-3 row justify-content-center">
                                <a href="{{route('home')}}" class="btn btn-outline-success">@lang('labels.goBackHome')</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif



@endsection
