<?php
use App\DataLayer;
$dl = new \App\DataLayer();


?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title> @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSS -->
    <!-- style.css -->
    <link href="{{url('/css/style.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{url('/css/bootstrap.css')}}" rel="stylesheet" type="text/css" >
{{--    <link href="{{url('/Cirrus-0.6.0/dist/cirrus.css')}}" rel="stylesheet" type="text/css" >--}}


   <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{url('css/bootstrap.css')}}">
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{url('/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}">
    <!-- Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{url('/fontawesome-free-5.15.1-web/css/all.css')}}">
    <!-- line awsome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- JS -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- popper.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <!-- bootstrap.min.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- md5 -->
    <script src="{{url('/js/md5.js')}}"></script>
    <!-- OwlCarousel -->
    <script src="{{url('/OwlCarousel2-2.3.4/dist/owl.carousel.js')}}"></script>





</head>
<body >

    <nav id="nav_parent" class="navbar navbar-expand-md navbar-light bg-light d-flex flex-column flex-md-row justify-content-md-between">

        <ul class="navbar-nav d-flex flex-row">
            <a class="navbar-brand" href="{{route('home')}}">
                <lottie-player id="nav-lottie"
                               src="{{asset('/icons/maneki.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 40px; height: 40px;">
                </lottie-player>

                <script>
                    var nav_animation = document.getElementById("nav-lottie");
                    $("#nav_parent").mouseover(function () {
                        nav_animation.play();
                    });
                    $("#nav_parent").mouseleave(function () {
                        nav_animation.stop();
                    });
                </script>
            </a>
            <li class="nav-item align-items-center">
                <a class="nav-link active mt-2"  href="{{route('home')}}">@lang('labels.allRecipes')</a>
            </li>
        </ul>

        <form class="form-inline my-2 my-md-0 w-100">
            <div class="container px-md-5">
                <div class="input-group w-100">
                    <input class="searcher form-control" placeholder=@lang('labels.searchPlaceholder') aria-label="Search">

                    <div class="input-group-append">
                        <a class="btn btn-outline-secondary my-0" href="{{route('search')}}">@lang('labels.advancedsearch')</a>
                    </div>
                </div>

                <div class="suggestions tendina" style="display: block;">
                </div>
            </div>
            <script type="text/javascript">

                var recipes = <?php echo json_encode($recipes) ?>;

                const searchInput = document.querySelector('.searcher');
                const suggestionPanel = document.querySelector('.suggestions');

                searchInput.addEventListener("keyup", function () {
                    const input = searchInput.value.toString().toUpperCase();

                    suggestionPanel.innerHTML = '';
                    const suggestions = recipes.filter(function (recipe) {
                        return recipe.title.toUpperCase().includes(input);
                    });
                    suggestions.forEach(function (suggested) {
                        const div = document.createElement('div');


                        div.innerHTML = "<li class='pt-2 pb-2'><a href='/recipe_view/" + suggested.id + "'>" + suggested.title + "</a></li>";

                        suggestionPanel.appendChild(div);
                    });

                    if (input == '') {
                        suggestionPanel.innerHTML = '';
                    }

                });
            </script>
        </form>

        <ul class="navbar-nav d-flex flex-row">
            @if($logged)
                <li class="nav-item">
                    <a class="nav-link disabled" href="{{route('logout')}}">{{ $loggedName }}</a>
                </li>
                <li class="nav-item pr-2 pb-1">
                </li>
                <img style="height: 40px; width: 40px; border-radius: 100px; border-style: solid; border-width: thin"
                     @if(($dl->getUserbyUsername($loggedName))->image_profile == NULL)
                     src="{{asset('image/default_user/paw.jpg')}}"
                     @else
                     src ="{{asset(($dl->getUserbyUsername($loggedName))->image_profile)}}"
                    @endif
                >
            @else
                <li class="nav-item">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginRegModal">
                        @lang('labels.loginButton')
                    </button>
                </li>
            @endif
            {{--            @yield('right_navbar')--}}
        </ul>

    </nav>

    @if($logged)
{{--    Barra di navigazione secondaria--}}
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top align-content-center">
        <ul class="navbar-nav">
            <li class="navbar-text">
                Il mio Account
            </li>
        </ul>
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbar2NavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar2NavDropdown">
        <ul class="navbar-nav ml-sm-auto">
            <li class="nav-item">
                <a class="nav-link" id="navbar2-myrecipes" href="{{route('account_all_recipes')}}">@lang('labels.recipeAll')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="navbar2-favorites" href="{{route('account_favorites')}}">@lang('labels.recipeFav')</a>
            </li>
            <?php $user = ($dl->getUserbyUsername($loggedName)); ?>
            @if($user->isEditor)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-recentlyadded" href="{{route('review')}}">@lang('labels.recentlyAdded')</a>
                </li>
            @endif
            @if($user->isModerator)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-revised" href="{{route('approved')}}">@lang('labels.revised')</a>
                </li>
            @endif
            @if($user->isAdmin)
                <li class="nav-item">
                    <a class="nav-link" id="navbar2-accounts" href="{{route('account_management')}}">@lang('labels.accountManagement')</a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link" id="navbar2-settings" href="{{route('account_settings')}}">@lang('labels.settings')</a>
            </li>
            <li>
                <a class="nav-link" id="navbar2-logout" href="{{route('logout')}}">@lang('labels.logout')</a>
            </li>
        </ul>
        </div>

    </nav>
    @endif



   <!-- Modal form -->
    <div class="modal fade" id="loginRegModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <div class="container">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#login"
                                   role="tab" aria-controls="login" aria-selected="true">@lang('labels.logInModaltab')</a>
                                <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#register"
                                   role="tab" aria-controls="register" aria-selected="false">@lang('labels.registerModaltab')</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <br/>
                            <div class="tab-pane fade show active" id="login" role="tabpanel"
                                 aria-labelledby="nav-login-tab">

                                <script>
                                    function validateFormLogin() {
                                        var username = document.forms['login_form']['username'].value;
                                        var password = document.forms['login_form']['password'].value;

                                        var auth = 1;
                                        var token = '{{\Illuminate\Support\Facades\Session::token()}}';

                                        var urlAuth = '{{route('auth')}}';

                                        $.ajax({
                                            method: 'POST',
                                            url: urlAuth,
                                            data: {username: username, password: password, _token: token},
                                            async: false,
                                            success: function(response){
                                                auth = response ;
                                            }
                                        });

                                        if (auth != 1) {
                                            @if(session()->has('language'))

                                                @if(session('language') == "it")
                                                    swal("C'è un errore!", "Il nome utente o la password sono sbagliati.", "error");
                                                    return false;
                                                @elseif (session('language') == "en")
                                                    swal("There is an error!", "The username or the password is wrong.", "error");
                                                    return false;

                                                @endif
                                            @else
                                                swal("C'è un errore!", "Il nome utente o la password sono sbagliati.", "error");
                                                    return false;
                                            @endif


                                        }
                                    }
                                </script>


                                <form id="login_form" onsubmit="return validateFormLogin()"
                                      action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">@lang('labels.modalLoginUsername')</label>
                                        <input required type="username" class="form-control" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input required type="password" class="form-control" data-toggle="password" name="password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#show_hide_password a").on('click', function(event) {
                                                        event.preventDefault();
                                                        if($('#show_hide_password input').attr("type") == "text"){
                                                            $('#show_hide_password input').attr('type', 'password');
                                                            $('#show_hide_password i').addClass( "fa-eye-slash" );
                                                            $('#show_hide_password i').removeClass( "fa-eye" );
                                                        }else if($('#show_hide_password input').attr("type") == "password"){
                                                            $('#show_hide_password input').attr('type', 'text');
                                                            $('#show_hide_password i').removeClass( "fa-eye-slash" );
                                                            $('#show_hide_password i').addClass( "fa-eye" );
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>


                                    <div class="form-group pt-2">
                                        <div class="container text-center col-sm-4">
                                            <input type="submit" name="login-submit"
                                                   class="form-control btn btn-outline-primary" value=@lang('labels.loginButton')>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="text-center">
                                            <a href="{{route('forgot')}}">@lang('labels.modalLoginForgot')</a>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="nav-register-tab">

                                <script>
                                    function validateForm() {
                                        var username = document.forms['register_form']['username'].value;
                                        var password = document.forms['register_form']['password'].value;
                                        var confirmPassword = document.forms['register_form']['confirm-password'].value;

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

                                        if (thereis == 1 ) {
                                            @if(session()->has('language'))

                                                @if(session('language') == "it")
                                                    swal("Controlla il nome utente!", "Questo nome utente è già stato utilizzato.", "error");
                                                    return false;
                                                @elseif (session('language') == "en")
                                                    swal("Check the username!", "This username was already taken.", "error");
                                                    return false;

                                                @endif
                                            @else
                                                swal("Controlla il nome utente!", "Questo nome utente è già stato utilizzato.", "error");
                                                    return false;
                                            @endif

                                        }


                                        if (password !== confirmPassword) {
                                            @if(session()->has('language'))

                                                @if(session('language') == "it")
                                                    swal("Controlla la password!", "Le password non coincidono.", "error");
                                                    return false;
                                                @elseif (session('language') == "en")
                                                    swal("Check the password!", "Passwords do not match.", "error");
                                                    return false;
                                                @endif
                                            @else
                                                swal("Controlla la password!", "Le password non coincidono.", "error");
                                                    return false;
                                            @endif

                                        }
                                        return true;
                                    }
                                </script>


                                <form id="register_form" onsubmit="return validateForm()" action="{{route('register')}}"
                                      method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">@lang('labels.modalLoginUsername')</label>
                                        <input required type="text" class="form-control" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="firstname">@lang('labels.modalRegFirstname')</label>
                                        <input required type="text" class="form-control" name="firstname">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">@lang('labels.modalRegLastname')</label>
                                        <input required type="text" class="form-control" name="lastname">
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday">@lang('labels.modalRegBirthday')</label>
                                        <input required type="date" class="form-control" name="birthday">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">@lang('labels.modalRegEmail')</label>
                                        <input required type="email" class="form-control" name="email">
                                    </div>
                                    <div id="insert_password" class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group" id="insert_password">
                                            <input required type="password" class="form-control" name="password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                               aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#insert_password a").on('click', function (event) {
                                                        event.preventDefault();
                                                        if ($('#insert_password input').attr("type") == "text") {
                                                            $('#insert_password input').attr('type', 'password');
                                                            $('#insert_password i').addClass("fa-eye-slash");
                                                            $('#insert_password i').removeClass("fa-eye");
                                                        } else if ($('#insert_password input').attr("type") == "password") {
                                                            $('#insert_password input').attr('type', 'text');
                                                            $('#insert_password i').removeClass("fa-eye-slash");
                                                            $('#insert_password i').addClass("fa-eye");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm-password">@lang('labels.modalRegConfimPassword')</label>
                                        <div class="input-group" id="check_password">
                                            <input required type="password" class="form-control"
                                                   name="confirm-password">
                                            <div class="input-group-append">
                                                <a class="input-group-text"><i class="fa fa-eye-slash"
                                                                               aria-hidden="true"></i></a>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    $("#check_password a").on('click', function (event) {
                                                        event.preventDefault();
                                                        if ($('#check_password input').attr("type") == "text") {
                                                            $('#check_password input').attr('type', 'password');
                                                            $('#check_password i').addClass("fa-eye-slash");
                                                            $('#check_password i').removeClass("fa-eye");
                                                        } else if ($('#check_password input').attr("type") == "password") {
                                                            $('#check_password input').attr('type', 'text');
                                                            $('#check_password i').removeClass("fa-eye-slash");
                                                            $('#check_password i').addClass("fa-eye");
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="container text-center col-sm-4">
                                            <input type="submit" name="register-submit"
                                                   class="form-control btn btn-outline-primary" value=@lang('labels.registerModaltab')>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    @yield('body')


    <div class="footer">


        <div class="container">
            <div class="dropdown">
            Lingua:
            @if(session()->has('language') && session('language') == "en")
                    <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> English</a>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'it'])}}"><img
                                src="{{asset('image/flags/it.jpg')}}" class="flag-icon"> Italiano</a>

                    </div>
                @else
                    <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        <a href="{{route('setLang',['lang'=>'it'])}}"><img
                                src="{{asset('image/flags/it.jpg')}}" class="flag-icon"> Italiano</a>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> English</a>

                    </div>
                @endif
        </div>


        </div>

        <div class="text-center small">
            <br/>
            <p>@lang('labels.designBy')</p>
            <a href="{{route('credits')}}">@lang('labels.creditsLink')</a>
        </div>
    </div>


    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>
</html>
