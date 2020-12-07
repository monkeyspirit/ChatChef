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


?>


@extends('utils.base_page')

@section('title', 'Settings')

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
                    @include('utils.rightnavbar', ['active'=>"3"])
                    <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>
@endsection

@section('body')

    <script> // questo aggiunge la classe active all'elemento "le mie ricette" nel menu
        $('#navbar2-settings').addClass('active');
    </script>

    <!-- Header -->
    <div id="parent-setting" class="container text-center p-4">
       {{-- <img src="{{asset('image/doodle/doodle1.jpg')}}" width="200" height="60" alt="">--}}

        <div class="d-flex justify-content-center">
           {{-- <div class="row  align-self-center pr-5">
                <lottie-player id="setf-lottie"
                               src="{{asset('/icons/settings.json')}}"
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
            <h1 class="h-title">@lang('labels.settings')</h1>
            {{--<div class="row align-self-center pl-5">
                <lottie-player id="secs-lottie"
                               src="{{asset('/icons/paint-roller.json')}}"
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



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header text-center ">
                        @lang('labels.changeInfo')
                    </div>
                    <div class="card-body">
                        <script>
                            function changeImage() {

                            }
                        </script>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="post" action="{{route('changeImageUser')}}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <input name="id" id="id" hidden value="{{$user->id}}">


                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title text-center" id="exampleModalLabel">@lang('labels.changePicProfile')</h5>

                                            <div class="input-group mb-3 p-3">
                                                <div class="custom-file">
                                                    <script>
                                                        function readURL(input) {
                                                            if (input.files && input.files[0]) {
                                                                var reader = new FileReader();

                                                                reader.onload = function (e) {
                                                                    $('#profilepic')
                                                                        .attr('src', e.target.result);
                                                                };

                                                                reader.readAsDataURL(input.files[0]);
                                                            }
                                                        }
                                                    </script>
                                                    <input required type="file" accept="image/*"
                                                           class="custom-file-input"
                                                           name="profile_input" id="profile_input"
                                                           onchange="readURL(this);">
                                                    <script>
                                                        $(".custom-file-input").on("change", function () {
                                                            var fileName = $(this).val().split("\\").pop();
                                                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                                        });
                                                    </script>
                                                    <label class="custom-file-label" for="profile_input">@lang('labels.chooseFile')</label>
                                                </div>
                                            </div>
                                            <div class="container pl-4 pr-4 pb-3">
                                                <div class="small card border-info">
                                                    <div class="card-body text-center">
                                                        @lang('labels.square')
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="container ">
                                                <div class="row justify-content-center">

                                                        @if($user->image_profile == NULL)
                                                            <img id="profilepic"
                                                                 src="{{asset('image/default_user/paw.jpg')}}"
                                                                 alt="your image">

                                                        @else
                                                            <img id="profilepic" src="{{asset($user->image_profile)}}"
                                                                 alt="your image">


                                                        @endif


                                                </div>

                                            </div>


                                        </div>


                                        <div class="modal-footer justify-content-around">
                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">
                                                @lang('labels.close')
                                            </button>
                                            <input type="submit" class="btn my-btn-outline-primary save"
                                                   value=@lang('labels.save')>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <a data-toggle="modal" data-target="#exampleModal" class="profile-pic" id="imgClickAndChange"
                           onclick="changeImage()">
                            <div class="profile-pic"
                                 @if($user->image_profile == NULL)
                                    style="background-image: url({{asset('image/default_user/paw.jpg')}})"
                                 @else
                                    style="background-image: url({{asset($user->image_profile)}})"
                                @endif
                            >
                                <span><svg class="bi bi-camera" width="1em" height="1em" viewBox="0 0 16 16"
                                           fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M9 5C7.343 5 5 6.343 5 8a4 4 0 0 1 4-4v1z"/>
                                          <path fill-rule="evenodd"
                                                d="M14.333 3h-2.015A5.97 5.97 0 0 0 9 2a5.972 5.972 0 0 0-3.318 1H1.667C.747 3 0 3.746 0 4.667v6.666C0 12.253.746 13 1.667 13h4.015c.95.632 2.091 1 3.318 1a5.973 5.973 0 0 0 3.318-1h2.015c.92 0 1.667-.746 1.667-1.667V4.667C16 3.747 15.254 3 14.333 3zM1.5 5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1zM9 13A5 5 0 1 0 9 3a5 5 0 0 0 0 10z"/>
                                          <path d="M2 3a1 1 0 0 1 1-1h1a1 1 0 0 1 0 2H3a1 1 0 0 1-1-1z"/>
                                </svg></span>

                                <span>@lang('labels.changeImage')</span>

                            </div>
                        </a>

                        <form id="edit_info_form" action="{{route('change_information',['id'=>$user->id])}}" method="post">
                            @csrf
                            <div class="input-group pt-3 pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.modalLoginUsername')</span>
                                </div>
                                <input disabled type="text" class="form-control" name="username" value="{{$user->username}}">
                            </div>
                            <div class="input-group pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.modalRegFirstname')</span>
                                </div>
                                <input required type="text" class="form-control" name="firstname" value="{{$user->firstname}}">
                            </div>
                            <div class="input-group pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.modalRegLastname')</span>
                                </div>
                                <input required type="text" class="form-control" name="lastname" value="{{$user->lastname}}">
                            </div>
                            <div class="input-group  pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.modalRegBirthday')</span>
                                </div>

                                <input required type="date" class="form-control" name="birthday" value="{{$user->birthday}}">
                            </div>
                            <div class="input-group  pb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.modalRegEmail')</span>
                                </div>
                                <input required type="text" class="form-control" name="email" value="{{$user->email}}">
                            </div>

                            <div class="form-group">
                                <div class="container text-center col-sm-4">
                                    <input type="submit" class="form-control btn my-btn-outline-primary" value=@lang('labels.change')>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

        <div class="row justify-content-center pt-2 pb-1">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header text-center ">
                        @lang('labels.changePassword')
                    </div>
                    <div class="card-body text-center">

                        <script>
                            function validateChangePassword() {
                                var old_password = document.forms['edit_user_form']['old_password'].value;
                                var new_password = document.forms['edit_user_form']['new_password'].value;
                                var confirm_password = document.forms['edit_user_form']['newc_password'].value;

                                var data_p = <?php echo json_encode($user->password); ?>;

                                if(data_p !== md5(old_password)){
                                    swal("There is an error!", "The old password is wrong.", "error");
                                    return false;
                                }

                                if(new_password !== confirm_password){
                                    swal("There is an error!", "The passwords don't match.", "error");
                                    return false;
                                }

                                return true;

                            }
                        </script>

                        <form id="edit_user_form" onsubmit="return validateChangePassword()" action="{{route('change_password', ['id'=>$user->id])}}" method="post">
                            @csrf
                                <div class="input-group pb-3" id="show_old_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('labels.oldpassword')</span>
                                    </div>
                                    <input required type="password" class="form-control" data-toggle="old_password"
                                           name="old_password">
                                    <div class="input-group-append">
                                        <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                       aria-hidden="true"></i></a>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            $("#show_old_password a").on('click', function (event) {
                                                event.preventDefault();
                                                if ($('#show_old_password input').attr("type") == "text") {
                                                    $('#show_old_password input').attr('type', 'password');
                                                    $('#show_old_password i').addClass("fa-eye-slash");
                                                    $('#show_old_password i').removeClass("fa-eye");
                                                } else if ($('#show_old_password input').attr("type") == "password") {
                                                    $('#show_old_password input').attr('type', 'text');
                                                    $('#show_old_password i').removeClass("fa-eye-slash");
                                                    $('#show_old_password i').addClass("fa-eye");
                                                }
                                            });
                                        });
                                    </script>
                                </div>




                                <div class="input-group pb-3" id="show_new_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('labels.newpassword')</span>
                                    </div>
                                    <input required type="password" class="form-control" data-toggle="new_password"
                                           name="new_password">
                                    <div class="input-group-append">
                                        <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                       aria-hidden="true"></i></a>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            $("#show_new_password a").on('click', function (event) {
                                                event.preventDefault();
                                                if ($('#show_new_password input').attr("type") == "text") {
                                                    $('#show_new_password input').attr('type', 'password');
                                                    $('#show_new_password i').addClass("fa-eye-slash");
                                                    $('#show_new_password i').removeClass("fa-eye");
                                                } else if ($('#show_new_password input').attr("type") == "password") {
                                                    $('#show_new_password input').attr('type', 'text');
                                                    $('#show_new_password i').removeClass("fa-eye-slash");
                                                    $('#show_new_password i').addClass("fa-eye");
                                                }
                                            });
                                        });
                                    </script>
                                </div>

                                <div class="input-group pb-3" id="show_c_new_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@lang('labels.confirmnewPassword')</span>
                                    </div>
                                    <input required type="password" class="form-control" data-toggle="newc_password"
                                           name="newc_password">
                                    <div class="input-group-append">
                                        <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                       aria-hidden="true"></i></a>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            $("#show_c_new_password a").on('click', function (event) {
                                                event.preventDefault();
                                                if ($('#show_c_new_password input').attr("type") == "text") {
                                                    $('#show_c_new_password input').attr('type', 'password');
                                                    $('#show_c_new_password i').addClass("fa-eye-slash");
                                                    $('#show_c_new_password i').removeClass("fa-eye");
                                                } else if ($('#show_c_new_password input').attr("type") == "password") {
                                                    $('#show_c_new_password input').attr('type', 'text');
                                                    $('#show_c_new_password i').removeClass("fa-eye-slash");
                                                    $('#show_c_new_password i').addClass("fa-eye");
                                                }
                                            });
                                        });
                                    </script>
                                </div>



                        <div class="form-group">
                            <div class="container text-center col-sm-4">
                                <input type="submit" class="form-control btn my-btn-outline-primary" value=@lang('labels.change')>
                            </div>
                        </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="row content">
            <br/>
        </div>
    </div>

@endsection
