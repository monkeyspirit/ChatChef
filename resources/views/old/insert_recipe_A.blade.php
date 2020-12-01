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

                    <!-- Title -->
                    <div class="input-group mb-3">
                        <input placeholder="@lang('labels.title') *" required id="title" name="title" type="text" class="form-control" aria-label="Title" aria-describedby="title">
                    </div>

                    <small id="charNumI">0</small><small>/350</small>
                    <!-- Description -->
                    <div class="input-group mb-3">
                        <textarea placeholder="@lang('labels.description')" rows="5" class="form-control" onkeyup="countCharIns(this)" id="description" name="description" aria-label="description" aria-describedby="description"></textarea>

                        <script>
                            function countCharIns(val) {
                                var len = val.value.length;
                                if (len >= 350) {
                                    $('#charNumI').text(350);
                                    val.value = val.value.substring(0, 350);
                                } else {
                                    $('#charNumI').text(len);
                                }
                            }
                        </script>
                    </div>


                    <!-- Difficult -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" ><img src="{{asset('image/icons_View/recipe-book.png')}}" alt="" class="icon">  @lang('labels.difficult')</span>
                        </div>
                        <input name="difficult" id="difficult" required type="text" class="form-control" aria-label="Difficulty" aria-describedby="difficulty">
                    </div>

                    <!-- Preparation time -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" ><img src="{{asset('image/icons_View/hand_kitchen_mixer_icon.png')}}" alt="" class="icon">  @lang('labels.preptime')</span>
                        </div>
                        <input name="preptime" id="preptime" type="text"  required class="form-control" aria-label="Preparation time" aria-describedby="prep">
                    </div>

                    <!-- Cooking time -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" ><img src="{{asset('image/icons_View/kitchen_pot_restaurant_icon.png')}}" alt=""  class="icon">  @lang('labels.cookingtime')</span>
                        </div>
                        <input name="cookingtime" id="cookingtime" type="text" required class="form-control" aria-label="Cooking time" aria-describedby="cook">
                    </div>

                    <!-- Doses -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><img src="{{asset('image/icons_View/kitchen_scale_machine_icon.png')}}" alt=""  class="icon">  @lang('labels.doses')</span>
                        </div>
                        <input name="doses" id="doses" required type="text" class="form-control" aria-label="Doses" aria-describedby="doses">
                    </div>





                    <!-- List of ingredients with quantity and unit -->


                    <label> @lang('labels.insertIng')</label>
                    <div id="dynamicIngredient" class="form-row">
                        <!-- Name -->
                        <div class="col">
                            <input type="text" required class="form-control" placeholder= @lang('labels.ingredients') name="ingredients[0]">
                        </div>

                        <!-- Quantity -->
                        <div class="col">
                            <input type="number" required step="0.01" min="0" class="form-control" placeholder= @lang('labels.quantity') name="quantities[]">
                        </div>

                        <!-- Unit -->
                        <div class="col">
                            <select required class="custom-select" name="units[]">
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
                                        '                                        <input required type="text" class="form-control" placeholder=@lang('labels.ingredients') name="ingredients['+x+']">\n' +
                                        '                                    </div>\n' +
                                        '\n' +
                                        '                                    <!-- Quantity -->\n' +
                                        '                                    <div class="col">\n' +
                                        '                                        <input required type="number" step="0.01" min="0" class="form-control" placeholder=@lang('labels.quantity') name="quantities[]">\n' +
                                        '                                    </div>\n' +
                                        '\n' +
                                        '                                    <!-- Unit -->\n' +
                                        '                                    <div class="col">\n' +
                                        '                                        <select required class="custom-select" name="units[]">\n' +
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

                    <br/>

                    <!-- Picture for cover -->

                    <label>@lang('labels.insertCover')</label>
                    <div id="dynamicImage" class="form-row">
                        <div class="custom-file">
                            <input required type="file"  accept="image/*" class="custom-file-input form-control" name="imageCover[]" aria-describedby="imageCover">
                            <label class="custom-file-label" for="imageCover">@lang('labels.chooseFile')</label>
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
                        <button class="btn btn-outline-secondary " id="add_form_field2">@lang('labels.addField') &nbsp;
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
                                        '<input required  type="file" accept="image/*" class="custom-file-input form-control" name="imageCover[]" aria-describedby="imageCover">\n'+
                                        '<label class="custom-file-label" for="imageCover">@lang('labels.chooseFile')</label>\n'+
                                        '</div>'+
                                        '<a href="#" class="delete pt-2 pl-1"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">'+
                                        '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>'+
                                        '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>'+
                                        '</svg></a></div>'); //add input box
                                    $(".custom-file-input").on("change", function() {
                                        var fileName = $(this).val().split("\\").pop();
                                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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

                    <br/>
                    <!-------------------------------->


                    <!-- Steps for the preparation -->
                    <label>@lang('labels.insertStep')</label>
                    <div id="dynamicStepSlot">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@lang('labels.step') </span>
                            </div>
                            <textarea rows="4" required class="form-control" name="steps[]" aria-label="steps" aria-describedby="steps"></textarea>
                        </div>



                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input required type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>
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
                                        '<textarea rows="4" required class="form-control" name="steps[]" aria-label="step" aria-describedby="step"></textarea>'+
                                        '</div>'+
                                        '<div class="input-group mb-3">'+
                                        '<div class="custom-file">'+
                                        ' <input required type="file" accept="image/*" class="custom-file-input" name="stepsImage[]"/>'+
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

                    <!-------------------------------->

                    <!-- Tags -->

                    <br/>
                    <label>@lang('labels.inserTag')</label>
                    <div id="dynamicTags" class="col-sm-12 text-center">
                        <select  required class="custom-select" name="tags[]">
                            <option disabled value="" selected>@lang('labels.chooseTag')</option>
                            <option value="1">@lang('labels.firstDish')</option>
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
                                        '<select required class="custom-select" name="tags[]">'+
                                        '<option disabled value="" selected>@lang('labels.chooseTag')</option>'+
                                        '<option value="1">@lang('labels.firstDish')</option>'+
                                       ' <option value="2">@lang('labels.mainCourse')</option>'+
                                       ' <option value="3">@lang('labels.dessert')</option>'+
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

                    <!-- Button -->
                    <div class="form-inline justify-content-around">
                        <div class="form-group mb-2">
                            <a type="button" class="btn btn-danger" href="{{route("account_all_recipes")}}">@lang('labels.cancel')</a>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="submit" name="register_form" class="form-control btn btn-primary" value=@lang('labels.save')>
                        </div>
                    </div>


                </form>


                <br/>

            </div>

        </div>
    </div>



@endsection


