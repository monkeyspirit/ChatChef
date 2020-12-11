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

    <script> // questo aggiunge la classe active all'elemento "le mie ricette" nel menu
        $('#navbar2-insertrecipe').addClass('active');
    </script>

    <div class="container text-center p-4">
        <h1 class="h-title">
        @lang('labels.insertRecipe')
    </div>


    <div class="container pb-5">
        <div class="tab-content" id="nav-tabContent">
            <br/>
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="nav-login-tab">

                <!-- FORM INSERT RECIPE -->



                <form id="register_form" action="{{route('insert_recipe')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="progressbar-container">
                        <ul class="progressbar">
                            <li class="step">@lang('labels.information')</li>
                            <li class="step">@lang('labels.toKnow')</li>
                            <li class="step">@lang('labels.ingredient_list')</li>
                            <li class="step">@lang('labels.method')</li>
                            <li class="step">@lang('labels.tag')</li>
                            <li class="step">@lang('labels.save')</li>
                        </ul>
                    </div>

                    <br>
                        <!-- One "tab" for each step in the form: -->
                        <div class="col col-lg-8 col-md-10 col-sm-12 card" style="margin: 0 auto; float: none; margin-bottom: 10px;">
                            <div class="card-body">
                                <div class="tab">


                                    <div class="text-center">
                                        <h2>@lang('labels.information')</h2>
                                    </div>
                                    <label style="color: darkred">*</label><label><strong>@lang('labels.title'):</strong></label>
                                    <p><input id="title" name="title" type="text" class="form-control" aria-label="Title" aria-describedby="title"></p>
                                    <label><strong>@lang('labels.description'):</strong></label>
                                    <p><textarea rows="5" class="form-control" onkeyup="countCharI(this)" id="description" name="description" aria-label="description" aria-describedby="description"></textarea></p>
                                    <script>
                                        function countCharI(val) {
                                            var len = val.value.length;
                                            if (len >= 350) {
                                                $('#charNumI').text(350);
                                                val.value = val.value.substring(0, 350);

                                            } else {
                                                $('#charNumI').text(len);
                                            }
                                        }
                                    </script>
                                    <small id="charNumI">0</small><small>/350</small>

                                    <br>
                                    <br>
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
                                                        '<input id="file_upload"  type="file" accept="image/*"  class="custom-file-input form-control" name="imageCover[]" aria-describedby="imageCover">\n'+
                                                        '<label class="custom-file-label" for="imageCover">@lang('labels.chooseFile')</label>\n'+
                                                        '</div>'+
                                                        '<a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a></div>'); //add input box
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


                                <div class="tab ">
                                    <br>
                                    <div class="text-center">
                                        <h2>@lang('labels.toKnow')</h2>
                                    </div>


                                    </label><label style="color: darkred">*</label><label><img src="{{asset('image/icons_View/recipe-book.png')}}" alt="" class="icon"> <strong>@lang('labels.difficult'):</strong></label>
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

                                    <br>

                                    <div class="row">
                                        <div class="col-auto">
                                            </label><label style="color: darkred">*</label><img src="{{asset('image/icons_View/hand_kitchen_mixer_icon.png')}}" alt="" class="icon">
                                            <label><strong>@lang('labels.preptime'):</strong>
                                        </div>
                                        <div class="col-auto">
                                            <input style="width: 150px" min=0 max=200 name="preptime" id="preptime" type="number"  class="form-control" aria-label="Preparation time" aria-describedby="prep">
                                        </div>
                                        <div class="col-auto">
                                            <label>(min.)</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label style="color: darkred">*</label><img src="{{asset('image/icons_View/kitchen_pot_restaurant_icon.png')}}" alt=""  class="icon">
                                            <label> <strong>@lang('labels.cookingtime'):</strong></label>
                                        </div>
                                        <div class="col-auto">
                                            <input style="width: 150px" min=0 max=200 name="cookingtime" id="cookingtime" type="number" class="form-control" aria-label="Cooking time" aria-describedby="cook">
                                        </div>
                                        <div class="col-auto">
                                            <label>(min.)</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <label style="color: darkred">*</label><img src="{{asset('image/icons_View/kitchen_scale_machine_icon.png')}}" alt=""  class="icon">
                                            <label> <strong>@lang('labels.doses'):</strong></label>
                                        </div>
                                        <div class="col-auto">
                                            <input style="width: 150px" min=0 max=200 name="doses" id="doses" type="number" class="form-control" aria-label="Doses" aria-describedby="doses">
                                        </div>
                                        <div class="col-auto">
                                            <label>@lang('labels.people')</label>
                                        </div>

                                    </div>
                                    <br>


                                    </div>

                                <div class="tab">
                                    <div class="text-center">
                                        <h2>@lang('labels.ingredient_list')</h2>
                                    </div>

                                    <div id="dynamicIngredient" class="form-row">
                                        <!-- Name -->
                                        <div class="col-auto">
                                            <span style="color: darkred"><strong>*</strong></span>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="@lang('labels.ingredients')" name="ingredients[0]">
                                        </div>

                                        <!-- Quantity -->
                                        <div class="col-auto">
                                            <span style="color: darkred"><strong>*</strong></span>
                                        </div>
                                        <div class="col">
                                            <input type="number" step="0.01" min="0" class="form-control" placeholder="@lang('labels.quantity')" name="quantities[]">
                                        </div>

                                        <!-- Unit -->

                                        <div class="col">
                                            <select class="custom-select" name="units[]">
                                                <option value="1" selected>@lang('labels.ml')</option>
                                                <option value="2">@lang('labels.g')</option>
                                                <option value="3">@lang('labels.tablespoon')</option>
                                                <option value="4">@lang('labels.littleunit')</option>
                                                <option value="5">@lang('labels.qb')</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="addIng"></div>

                                    <br/>
                                    <div class="text-center pb-2">
                                        <button class="btn btn-outline-secondary " id="add_form_field1">@lang('labels.add_ingredient')
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
                                                        '                                    <div class="col-auto">\n' +
                                                        '                                            <span style="color: darkred"><strong>*</strong></span>\n' +
                                                        '                                        </div>' +
                                                    '                                        <div class="col">\n' +
                                                        '                                        <input type="text" class="form-control" placeholder=@lang('labels.ingredients') name="ingredients[]">\n' +
                                                        '                                    </div>\n' +
                                                        '\n' +
                                                        '                                    <!-- Quantity -->\n' +
                                                        '                                    <div class="col-auto">\n' +
                                                        '                                            <span style="color: darkred"><strong>*</strong></span>\n' +
                                                        '                                        </div><div class="col">\n' +
                                                        '                                        <input type="number" step="0.01" min="0" class="form-control" placeholder=@lang('labels.quantity') name="quantities[]">\n' +
                                                        '                                    </div>\n' +
                                                        '\n' +
                                                        '                                    <!-- Unit -->\n' +
                                                        '                                    <div class="col">\n' +
                                                        '                                        <select class="custom-select" name="units[]">\n' +
                                                        '                                            <option value="1" selected>@lang('labels.ml')</option>\n' +
                                                        '                                            <option value="2">@lang('labels.g')</option>\n' +
                                                        '                                            <option value="3">@lang('labels.tablespoon')</option>\n'+
                                                        '                                            <option value="4">@lang('labels.littleunit')</option>'+
                                                                                                    '<option value="5">@lang('labels.qb')</option>\n'+
                                                        '                                        </select></div>\n' +
                                                        '                                    <a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a></div>'); //add input box

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

                                <div class="tab">

                                    <div class="text-center">
                                        <h2>@lang('labels.method')</h2>
                                    </div>
                                    <label>@lang('labels.insertStep')</label>
                                    <div id="dynamicStepSlot">
                                        <label><strong>@lang('labels.step'):</strong></label><label style="color: darkred"> *</label>
                                        <textarea rows="4" class="form-control" name="steps[]" aria-label="steps" aria-describedby="steps"></textarea>
                                        <br>

                                       <div class="custom-file">
                                            <input type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>
                                            <label class="custom-file-label" for="stepsImage">@lang('labels.chooseFile')</label>
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
                                        <button class="btn btn-outline-secondary " id="add_form_field3">@lang('labels.addStep') &nbsp;
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

                                                    $(wrapper).append('<div id="dynamicStepSlot">'+
                                                                            '<br><label><strong>@lang('labels.step'):</strong></label><label style="color: darkred"> *</label>\n' +
                                                        '                                        <textarea rows="4" class="form-control" name="steps[]" aria-label="steps" aria-describedby="steps"></textarea>\n' +
                                                        '                                        <br>\n' +

                                                        '                                           <div class="custom-file">\n' +
                                                        '                                            <input type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>\n' +
                                                        '                                            <label class="custom-file-label" for="stepsImage">@lang("labels.chooseFile")</label>\n' +
                                                        '                                        </div>' +
                                                        '           <a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang("labels.remove")</a></div>'); //add input box
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

                                <div class="tab">
                                    <div class="text-center">
                                        <h2>@lang('labels.tags')</h2>
                                    </div>
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
                                        <button class="btn btn-outline-secondary " id="add_form_field4">@lang('labels.addTag') &nbsp;
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

                                                        '<a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a></div>'); //add input box
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

                                <div class="tab">
                                    <div class="container">
                                        <div class="text-center">
                                            <h2>@lang('labels.success')!</h2>
                                        </div>
                                        <label class="text-center">@lang('labels.save_text')</label>
                                        <div class="row justify-content-center">
                                            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                            <lottie-player src="https://assets10.lottiefiles.com/private_files/lf30_womtqnns.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
                                        </div>
                                    </div>



                                </div>
                                <div  class="text-center">
                                    <div class="pt-3  ">
                                        <input style="width: auto" type="submit" id="submit" name="register_form" class="form-control btn btn-success" value=@lang('labels.save')>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="pt-3">
                                       {{-- <a type="button" class="btn btn-danger" href="{{route("account_all_recipes")}}">@lang('labels.cancel')</a>--}}

                                            <button type="button" class="btn btn-outline-secondary" id="prevBtn" onclick="nextPrev(-1)">@lang('labels.prev')</button>

                                            <button type="button" class="btn btn-outline-primary" id="nextBtn" onclick="nextPrev(1)">@lang('labels.next')</button>


                                    </div>
                                </div>

                            </div>
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

                                document.getElementById("nextBtn").style.display = "none";
                                document.getElementById("submit").style.display = "inline";
                            } else {

                                document.getElementById("nextBtn").style.display = "inline";
                                document.getElementById("submit").style.display = "none";
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
                                if (y[i].value === "" && y[i].type !== "file") {
                                    // add an "invalid" class to the field:
                                    y[i].className += " invalid";
                                    // and set the current valid status to false:
                                    valid = false;
                                }

                                if (y[i].type === "checkbox"){
                                    if (y[i].checked){
                                        y[i].value = "1";
                                    }
                                    else{
                                        y[i].checked = true;
                                        y[i].value = "0";
                                    }
                                }

                                if (y[i].type === "file") {
                                    if (y[i].value === "") {

                                    }
                                }

                            }

                            for (i = 0; i < z.length; i++) {
                                // If a field is empty...
                                if (z[i].value === "" && z[i].name !== "description") {
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
                                x[i].className = x[i].className.replace(" focus", "");
                            }
                            //... and adds the "active" class to the current step:

                            for (i = 0; i < n-1; i++) {
                                x[i].className  += " active";
                            }

                            x[n-1].className += " active";
                            x[n].className += " focus";
                        }



                    </script>
                </form>


            </div>

        </div>
    </div>



@endsection


