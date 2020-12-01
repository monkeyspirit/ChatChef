<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$user_id = $dl->getUserIDbyUsername( $_SESSION['loggedName']);
$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}


?>

@extends('utils.base_page')

@section('title', 'Insert recipe')


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
                @include('utils.rightnavbar', ['active'=>"0"])
                <a class="dropdown-item" href="{{route('logout')}}">@lang('labels.logout')</a>
            </div>
        </div>
    </li>
@endsection

@section('body')


    <div class="container text-center p-4">
        <h1 class="h-title">
        @lang('labels.insertRecipe')
    </div>


    <div class="container">
        <div class="tab-content" id="nav-tabContent">
            <br/>
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="nav-login-tab">

                <!-- FORM INSERT RECIPE -->



                <form id="register_form" action="{{route('insert_recipe')}}" method="post" enctype="multipart/form-data">
                    @csrf


                    <h1>Register:</h1>

                    <!-- One "tab" for each step in the form: -->
                    <div class="tab">Name:
                        <p><input placeholder="@lang('labels.title') *" id="title" name="title" type="text" class="form-control" aria-label="Title" aria-describedby="title" oninput="this.className = ''"></p>
                        <p><textarea placeholder="@lang('labels.description')" rows="5" class="form-control" onkeyup="countCharIns(this)" id="description" name="description" aria-label="description" aria-describedby="description"></textarea></p>
                        <small id="charNumI">0</small><small>/350</small>

                        <label>@lang('labels.insertCover')</label>
                        <div id="dynamicImage" class="form-row">

                        </div>

                        <br>

                        <div style="text-align: center; border: 0px solid">
                            <button class="btn btn-outline-secondary" id="add_form_field2">@lang('labels.addImage') &nbsp;
                                <span style="font-size:16px; font-weight:bold;">+ </span>
                            </button>
                        </div>




                        <script>
                            $(document).ready(function() {
                                var max_fields = 10;
                                var wrapper = $("#dynamicImage");
                                var add_button = $("#add_form_field2");

                                var x = 1;
                                $(add_button).click(function(e) {
                                    e.preventDefault();
                                    if (x < max_fields) {
                                        x++;

                                        $(wrapper).append(' <div id="dynamicImage" class="input-group mb-3 pt-2">\n'+
                                            '<div class="custom-file">\n'+
                                            '<input id="file_upload"  type="file" accept="image/png, image/jpeg" class="custom-file-input form-control" name="imageCover[]" aria-describedby="imageCover">\n'+
                                            '<label class="custom-file-label" for="imageCover">@lang('labels.chooseFile')</label>\n'+
                                            '</div>'+
                                            '<a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fa fa-trash" aria-hidden="true"></i> @lang('labels.remove')</a></div>'); //add input box
                                        $(".custom-file-input").on("change", function() {
                                            if(this.files[0].size > 2000000){
                                                alert("File is too big!");
                                                this.value = "";
                                            }
                                            else{
                                                var fileName = $(this).val().split("\\").pop();
                                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);

                                            }


                                        });
                                    } else {
                                        alert(@lang('labels.reachLimit'))
                                    }
                                });

                                $(wrapper).on("click", ".delete", function(e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                    x--;

                                })
                            });
                        </script>

                    </div>

                    <div class="tab">Contact Info:
                        <br>
                        {{--<p><input placeholder="E-mail..." oninput="this.className = ''"></p>
                        <p><input placeholder="Phone..." oninput="this.className = ''"></p>--}}

                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" value="1" name="difficult" class="custom-control-input" checked="checked">
                            <label class="custom-control-label" for="customRadio1">@lang('labels.easy')</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" value="2" name="difficult" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">@lang('labels.mid')</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio3" value="3" name="difficult" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio3">@lang('labels.expert')</label>
                        </div>

                        <p><input placeholder=" @lang('labels.preptime')" name="preptime" id="preptime" type="number"  class="form-control" aria-label="Preparation time" aria-describedby="prep" oninput="this.className = ''"></p>
                        <p><input placeholder="@lang('labels.cookingtime')" name="cookingtime" id="cookingtime" type="number" class="form-control" aria-label="Cooking time" aria-describedby="cook" oninput="this.className = ''"></p>
                        <p><input placeholder="@lang('labels.doses')" name="doses" id="doses" type="number" class="form-control" aria-label="Doses" aria-describedby="doses" oninput="this.className = ''"></p>
                    </div>

                    <div class="tab">Birthday:
                        <div id="dynamicIngredient" class="form-row">
                            <!-- Name -->
                            <div class="col">
                                <input type="text" class="form-control" placeholder= @lang('labels.ingredients') name="ingredients[0]" oninput="this.className = ''">
                            </div>

                            <!-- Quantity -->
                            <div class="col">
                                <input type="number" step="0.01" min="0" class="form-control" placeholder= @lang('labels.quantity') name="quantities[]" oninput="this.className = ''">
                            </div>

                            <!-- Unit -->
                            <div class="col">
                                <select class="custom-select" name="units[]">
                                    <option disabled value="" selected> @lang('labels.unit')</option>
                                    <option value="1"> @lang('labels.ml')</option>
                                    <option value="2"> @lang('labels.g')</option>
                                    <option value="3">  @lang('labels.tablespoon')</option>

                                </select>
                            </div>
                        </div>

                        <div id="addIng"></div>

                        <br/>
                        <div class="text-center pb-2">
                            <button class="btn btn-outline-secondary " id="add_form_field1">@lang('labels.addField')
                                <span style="font-size:16px; font-weight:bold;">+ </span>
                            </button>
                        </div>

                        <script>
                            $(document).ready(function() {
                                var max_fields = 100;
                                var wrapper = $("#addIng");
                                var add_button = $("#add_form_field1");

                                var x = 1;
                                $(add_button).click(function(e) {
                                    e.preventDefault();
                                    if (x < max_fields) {
                                        x++;
                                        e = x;
                                        $(wrapper).append('<div id="dynamicIngredient" class=" p-2 form-row">' +
                                            '<!-- Name -->\n' +
                                            '                                    <div class="col">\n' +
                                            '                                        <input oninput="this.className = \'\'" type="text" class="form-control" placeholder=@lang('labels.ingredients') name="ingredients['+x+']">\n' +
                                            '                                    </div>\n' +
                                            '\n' +
                                            '                                    <!-- Quantity -->\n' +
                                            '                                    <div class="col">\n' +
                                            '                                        <input oninput="this.className = \'\'" type="number" step="0.01" min="0" class="form-control" placeholder=@lang('labels.quantity') name="quantities[]">\n' +
                                            '                                    </div>\n' +
                                            '\n' +
                                            '                                    <!-- Unit -->\n' +
                                            '                                    <div class="col">\n' +
                                            '                                        <select class="custom-select" name="units[]">\n' +
                                            '                                            <option disabled value="" selected> @lang('labels.unit')</option>\n' +
                                            '                                            <option value="1">@lang('labels.ml')</option>\n' +
                                            '                                            <option value="2">@lang('labels.g')</option>\n' +
                                            '                                            <option value="3">@lang('labels.tablespoon')</option>\n'+
                                            '<option value="4">  @lang('labels.littleunit')</option>'+
                                            '                                        </select></div>\n' +
                                            '                                    <a href="#" class="delete pt-2"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'+
                                            '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>'+
                                            '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>'+
                                            '</svg></a></div>'); //add input box
                                    }
                                });

                                $(wrapper).on("click", ".delete", function(e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                    x--;

                                })
                            });
                        </script>

                    </div>

                    <div class="tab">Login Info:
                        <label>@lang('labels.insertStep')</label>
                        <div id="dynamicStepSlot">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@lang('labels.step') </span>
                                </div>
                                <textarea rows="4" class="form-control" name="steps[]" aria-label="steps" aria-describedby="steps"></textarea>
                            </div>



                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>
                                    <label class="custom-file-label" for="stepsImage">@lang('labels.chooseFile')</label>
                                </div>
                            </div>

                        </div>
                        <script>
                            $(".custom-file-input").on("change", function() {
                                var fileName = $(this).val().split("\\").pop();
                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                            });
                        </script>


                        <br/>
                        <div class="text-center pb-2">
                            <button class="btn btn-outline-secondary " id="add_form_field3">@lang('labels.addField') &nbsp;
                                <span style="font-size:16px; font-weight:bold;">+ </span>
                            </button>

                        </div>
                        <script>
                            $(document).ready(function() {
                                var max_fields = 30;
                                var wrapper = $("#dynamicStepSlot");
                                var add_button = $("#add_form_field3");

                                var x = 1;
                                $(add_button).click(function(e) {
                                    e.preventDefault();
                                    if (x < max_fields) {
                                        x++;

                                        $(wrapper).append(' <div id="dynamicStepSlot">'+
                                            '  <div class="input-group mb-3">'+
                                            '<div class="input-group-prepend">'+
                                            ' <span class="input-group-text">@lang('labels.step')  </span>'+
                                            ' </div>'+
                                            '<textarea rows="4" class="form-control" name="steps[]" aria-label="step" aria-describedby="step"></textarea>'+
                                            '</div>'+
                                            '<div class="input-group mb-3">'+
                                            '<div class="custom-file">'+
                                            ' <input type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>'+
                                            '<label class="custom-file-label" for="stepsImage">@lang('labels.chooseFile')</label>'+
                                            ' </div>'+
                                            '</div>'+
                                            '<a href="#" class="delete text-center"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'+
                                            '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>'+
                                            '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>'+
                                            '</svg> Delete step </a></div>'); //add input box
                                        $(".custom-file-input").on("change", function() {
                                            var fileName = $(this).val().split("\\").pop();
                                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                        });
                                    }
                                });

                                $(wrapper).on("click", ".delete", function(e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                    x--;

                                })
                            });
                        </script>

                    </div>

                    <div class="tab">Login Info:
                        <label>@lang('labels.inserTag')</label>
                        <div id="dynamicTags" class="col-sm-12 text-center">
                            <select class="custom-select" name="tags[]">
                                <option value="1" selected>@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            </select>
                        </div>

                        <br/>
                        <div class="text-center pb-2">
                            <button class="btn btn-outline-secondary " id="add_form_field4">@lang('labels.addField') &nbsp;
                                <span style="font-size:16px; font-weight:bold;">+ </span>
                            </button>

                        </div>

                        <script>
                            $(document).ready(function() {
                                var max_fields = 30;
                                var wrapper = $("#dynamicTags");
                                var add_button = $("#add_form_field4");

                                var x = 1;

                                $(add_button).click(function(e) {
                                    e.preventDefault();
                                    if (x < max_fields) {
                                        x++;

                                        $(wrapper).append('<div id="dynamicTags" class="input-group col-sm-12 text-center p-2">' +
                                            '<select class="custom-select" name="tags[]">'+
                                            '<option value="1" selected>@lang('labels.firstDish')</option>'+
                                            '<option value="2">@lang('labels.mainCourse')</option>'+
                                            '<option value="3">@lang('labels.dessert')</option>'+
                                            '<option value="4">@lang('labels.appetiser')</option>' +
                                            '<option value="5">@lang('labels.sideDish')</option>'+
                                            '<option value="6">@lang('labels.meat')</option>'+
                                            '<option value="7">@lang('labels.fish')</option>'+
                                            '<option value="8">@lang('labels.vegetarian')</option>'+
                                            '<option value="9">@lang('labels.vegan')</option>'+
                                            '<option value="10">@lang('labels.glutenFree')</option>'+
                                            '<option value="11">@lang('labels.withoutAll')</option>'+
                                            '</select>'+

                                            '<a href="#" class="delete pt-2 pl-2"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'+
                                            '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>'+
                                            '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>'+
                                            '</svg></a></div>'); //add input box
                                    }
                                });

                                $(wrapper).on("click", ".delete", function(e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                    x--;

                                })
                            });

                        </script>

                        <br/>

                    </div>

                    <div class="tab">Login Info:
                        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                        <lottie-player src="https://assets5.lottiefiles.com/temp/lf20_4Jjg2l.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
                    </div>

                    <div style="overflow:auto;">
                        <div style="float: left">
                            <a type="button" class="btn btn-danger" href="{{route("account_all_recipes")}}">@lang('labels.cancel')</a>
                        </div>
                        <div style="float:right;">

                            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            <input type="submit" id="submit" name="register_form" class="form-control btn btn-primary" style="visibility:hidden;" value=@lang('labels.save')>
                        </div>
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>

                    </div>

                    <script>
                        var currentTab = 0; // Current tab is set to be the first tab (0)
                        showTab(currentTab); // Display the current tab

                        function showTab(n) {
                            // This function will display the specified tab of the form ...
                            var x = document.getElementsByClassName("tab");
                            x[n].style.display = "block";
                            // ... and fix the Previous/Next buttons:
                            if (n == 0) {
                                document.getElementById("prevBtn").style.display = "none";
                            } else {
                                document.getElementById("prevBtn").style.display = "inline";
                            }
                            if (n == (x.length - 1)) {
                                document.getElementById("nextBtn").innerHTML = "Submit";
                                document.getElementById("nextBtn").style = "visibility:hidden";
                                document.getElementById("submit").style =  "visibility:visible";
                            } else {
                                document.getElementById("nextBtn").innerHTML = "Next";
                            }
                            // ... and run a function that displays the correct step indicator:
                            fixStepIndicator(n)
                        }

                        function nextPrev(n) {
                            // This function will figure out which tab to display
                            var x = document.getElementsByClassName("tab");
                            // Exit the function if any field in the current tab is invalid:
                            if (n == 1 && !validateForm()) return false;
                            // Hide the current tab:
                            x[currentTab].style.display = "none";
                            // Increase or decrease the current tab by 1:
                            currentTab = currentTab + n;
                            // if you have reached the end of the form... :
                            if (currentTab >= x.length) {
                                //...the form gets submitted:
                                document.getElementById("regForm").submit();
                                return false;
                            }
                            // Otherwise, display the correct tab:
                            showTab(currentTab);
                        }

                        function validateForm() {
                            // This function deals with validation of the form fields
                            var x, y, i, z, valid = true;
                            x = document.getElementsByClassName("tab");
                            y = x[currentTab].getElementsByTagName("input");
                            z = x[currentTab].getElementsByTagName("textarea");
                            // A loop that checks every input field in the current tab:
                            for (i = 0; i < y.length; i++) {
                                // If a field is empty...
                                if (y[i].value == "") {
                                    // add an "invalid" class to the field:
                                    y[i].className += " invalid";
                                    // and set the current valid status to false:
                                    valid = false;
                                }
                            }

                            for (i = 0; i < z.length; i++) {
                                // If a field is empty...
                                if (z[i].value == "") {
                                    // add an "invalid" class to the field:
                                    z[i].className += " invalid";
                                    // and set the current valid status to false:
                                    valid = false;
                                }
                            }
                            // If the valid status is true, mark the step as finished and valid:
                            if (valid) {
                                document.getElementsByClassName("step")[currentTab].className += " finish";
                            }
                            return valid; // return the valid status
                        }

                        function fixStepIndicator(n) {
                            // This function removes the "active" class of all steps...
                            var i, x = document.getElementsByClassName("step");
                            for (i = 0; i < x.length; i++) {
                                x[i].className = x[i].className.replace(" active", "");
                            }
                            //... and adds the "active" class to the current step:
                            x[n].className += " active";
                        }
                    </script>
                </form>


            </div>

        </div>
    </div>



@endsection


