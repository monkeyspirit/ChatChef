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
    <!-- Fogli di stile -->

    <link href="{{url('/css/style.css')}}" rel="stylesheet" type="text/css" >
    <link href="{{url('/css/bootstrap.css')}}" rel="stylesheet" type="text/css" >


    <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jQuery e plugin JavaScript -->
    <script src="{{url('http://code.jquery.com/jquery.js')}}"></script>
    <script src="{{url('/js/popper.min.js')}}"></script>
    <script src="{{url('/js/bootstrap.min.js')}}"></script>
    <script src="{{url('/js/md5.js')}}"></script>





</head>
<body >



    <nav id="nav_parent" class="navbar navbar-expand-lg navbar-light bg-light align-content-center">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">

            <a class="navbar-brand " href="{{route('home')}}">
                <lottie-player id="nav-lottie"
                               src="{{asset('/icons/maneki.json')}}"
                               background="transparent"
                               speed="1"
                               style="width: 40px; height: 40px;"

                >
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


            <ul class="navbar-nav ml-auto">
                <li>
                    @if(session()->has('language'))

                        @if(session('language') == "it")
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <a href="{{route('setLang',['lang'=>'it'])}}"><img
                                            src="{{asset('image/flags/it.jpg')}}" class="flag-icon"></a>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                            src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> English</a>

                                </div>
                            </div>
                        @elseif (session('language') == "en")
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <a href="{{route('setLang',['lang'=>'en'])}}"><img
                                            src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"></a>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('setLang',['lang'=>'it'])}}"><img
                                            src="{{asset('image/flags/it.jpg')}}" class="flag-icon"> Italiano</a>

                                </div>
                            </div>
                        @endif
                    @else
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary-my dropdown-toggle" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <a href="{{route('setLang',['lang'=>'it'])}}"><img
                                        src="{{asset('image/flags/it.jpg')}}" class="flag-icon"></a>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{route('setLang',['lang'=>'en'])}}"><img
                                        src="{{asset('image/flags/uk.jpg')}}" class="flag-icon"> Italiano</a>

                            </div>
                        </div>
                    @endif


                </li>

                <li class="nav-item">
                    <a class="nav-link active" style="padding-top: 8%" href="{{route('home')}}">@lang('labels.allRecipes')</a>
                </li>
                <li class="nav-item ">


                    <form class="form-inline">
                        <div class="container">
                            <input class="searcher form-control mr-sm-2" placeholder=@lang('labels.searchPlaceholder') aria-label="Search">
                            <a class="btn btn-outline-secondary my-2 my-sm-0" href="{{route('search')}}">@lang('labels.advancedsearch')</a>

                            <div class="suggestions tendina" style="display: block;">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </form>


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
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('labels.searchBytag')
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{route('searchType',['n'=>1])}}">@lang('labels.firstDish')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>2])}}">@lang('labels.mainCourse')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>3])}}">@lang('labels.dessert')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>4])}}">@lang('labels.appetiser')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>5])}}">@lang('labels.sideDish')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>6])}}">@lang('labels.meat')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>7])}}">@lang('labels.fish')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>8])}}">@lang('labels.vegetarian')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>9])}}">@lang('labels.vegan')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>10])}}">@lang('labels.glutenFree')</a>
                            <a class="dropdown-item" href="{{route('searchType',['n'=>11])}}">@lang('labels.withoutAll')</a>
                        </div>
                    </div>
                </li>

            </ul>



            <ul class="navbar-nav ml-auto">
                @yield('right_navbar')
            </ul>
        </div>
    </nav>



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



    <div class="footer ">
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
