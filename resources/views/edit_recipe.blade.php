<?php
use App\DataLayer;
$dl = new \App\DataLayer();

$recipe = $dl->getRecipeByID($id);
$user = $dl->getUserByID($recipe->user_id);

$ingredients_n = explode("_", $recipe->ingredients_name);
$ingredients_qu = explode("/", $recipe->ingredients_quantity);
$ingredients_q = explode("_", $ingredients_qu[0]);
$ingredients_u = explode("_", $ingredients_qu[1]);
$number_ing = count($ingredients_n);

$step_text = explode("_", $recipe->steps_text);
$step_image_id = explode("_", $recipe->steps_image);
$number_step = count($step_text);

$step_image = array();

for ($i = 1; $i < $number_step; $i++) {
    $path = $dl->getImagePathFromID($step_image_id[$i]);
    array_push($step_image, $path);
}


$tags = explode("_", $recipe->tags);
$number_tag = count($tags);

$imageCover = $dl->getRecipeCovers($recipe->id);
$number_cover = count($imageCover);

$recipes_all = $dl->getAllRecipe();

$recipes = array();
foreach ($recipes_all as $recipe_ok) {
    if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
        array_push($recipes, $recipe_ok);
    }
}


?>

@extends('utils.base_page')

@section('title', 'Edit recipe')

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
                <button class="btn btn-outline-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $loggedName }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @include('utils.rightnavbar', ['active'=>"0"])
                    <a class="dropdown-item" href="{{route('logout_home')}}">@lang('labels.logout')</a>
                </div>
            </div>
        </li>

@endsection

@section('body')

    <div class="container text-center p-4">
        <h1 class="h-title">
            @lang('labels.editTitle')
        </h1>
    </div>


<div class="container">
    <div class="tab-content" id="nav-tabContent">
        <br/>
        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="nav-login-tab">
            <!-- FORM INSERT RECIPE -->

            <form id="edit_form{{$recipe->id}}" action="{{route('edit_recipe',['id'=>$recipe->id])}}" method="post"
                  enctype="multipart/form-data">
            @csrf



            <!-- Title -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@lang('labels.title')</span>
                    </div>
                    <input required value="{{$recipe->title}}" name="title_edit" type="text" class="form-control"
                           aria-label="Title_edit" aria-describedby="title_edit">
                </div>

                <!-- Difficult -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img src="{{asset('image/icons_View/recipe-book.png')}}" alt=""
                                                            class="icon"> @lang('labels.difficult')</span>
                    </div>
                    <input required value="{{$recipe->difficult}}" name="difficult_edit" type="text" class="form-control"
                           aria-label="Difficulty_edit" aria-describedby="difficulty_edit">
                </div>

                <!-- Preparation time -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img
                                src="{{asset('image/icons_View/hand_kitchen_mixer_icon.png')}}" alt="" class="icon"> @lang('labels.preptime')</span>
                    </div>
                    <input required value="{{$recipe->preparation_time}}" name="preptime_edit" type="text" class="form-control"
                           aria-label="Preparation time_edit" aria-describedby="prep_edit">
                </div>

                <!-- Cooking time -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img
                                src="{{asset('image/icons_View/kitchen_pot_restaurant_icon.png')}}" alt="" class="icon"> @lang('labels.cookingtime') </span>
                    </div>
                    <input required value="{{$recipe->cooking_time}}" name="cookingtime_edit" type="text" class="form-control"
                           aria-label="Cooking time_edit" aria-describedby="cook_edit">
                </div>

                <!-- Doses -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img
                                src="{{asset('image/icons_View/kitchen_scale_machine_icon.png')}}" alt="" class="icon"> @lang('labels.doses')</span>
                    </div>
                    <input required value="{{$recipe->doses}}" name="doses_edit" type="text" class="form-control"
                           aria-label="Doses_edit" aria-describedby="doses_edit">
                </div>


                <!-- Description -->
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">@lang('labels.description')</span>
                        <span class="input-group-text"><small
                                id="charNumE">{{strlen($recipe->description)}}</small><small>/350</small></span>
                    </div>
                    <textarea required rows="5" class="form-control" name="description_edit" onkeyup="countCharE(this)"
                              aria-label="description_edit"
                              aria-describedby="description_edit">{{$recipe->description}}</textarea>


                    <script>
                        function countCharE(val) {
                            var len = val.value.length;
                            if (len >= 350) {
                                $('#charNumE').text(350);
                                val.value = val.value.substring(0, 350);

                            } else {
                                $('#charNumE').text(len);
                            }
                        }
                    </script>
                </div>


                <!-- List of ingredients with quantity and unit -->
                <label>@lang('labels.insertIng')</label>

                @for($i=1; $i<$number_ing; $i++)

                    <div id="dynamicIngredient_edit{{$i}}" class="form-row p-2">
                        <!-- Name -->
                        <div class="col">
                            <input required value="{{$ingredients_n[$i]}}" type="text" class="form-control"
                                   name="ingredients_edit[]">

                        </div>

                        <!-- Quantity -->
                        <div class="col">
                            <input required value={{$ingredients_q[$i]}} type="number" step="0.01" min="0" class="form-control"
                                   name="quantities_edit[]">
                        </div>

                        <!-- Unit -->
                        <div class="col">
                            <select required class="custom-select" name="units_edit[]">';
                                @if($ingredients_u[$i]==1)
                                    <option disabled value=""> @lang('labels.unit')</option>
                                    <option selected value="1">@lang('labels.ml')</option>
                                    <option value="2"> @lang('labels.g')</option>
                                    <option value="3">@lang('labels.tablespoon')</option>
                                    <option value="4">  @lang('labels.littleunit')</option>

                                @elseif ($ingredients_u[$i]==2)
                                    <option disabled value=""> @lang('labels.unit')</option>
                                    <option value="1">@lang('labels.ml')</option>
                                    <option selected value="2"> @lang('labels.g')</option>
                                    <option value="3">@lang('labels.tablespoon')</option>
                                    <option value="4">  @lang('labels.littleunit')</option>
                                @else
                                    <option disabled value=""> @lang('labels.unit')</option>
                                    <option value="1">@lang('labels.ml')</option>
                                    <option value="2"> @lang('labels.g')</option>
                                    <option selected value="3">@lang('labels.tablespoon')</option>
                                    <option value="4">  @lang('labels.littleunit')</option>
                                @endif
                            </select>
                        </div>


                        @if($i>=2)
                            <a href="#" class="delete pt-2">
                                <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16"
                                     fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>

                            <script>
                                $(document).ready(function () {

                                    var wrapper = $("#dynamicIngredient_edit{{$i}}");

                                    $(wrapper).on("click", ".delete", function (e) {
                                        e.preventDefault();
                                        $(this).parent('div').remove();

                                    })
                                });
                            </script>
                        @endif

                    </div>
                @endfor

                <div id="addingIng"></div>


                <br/>
                <div class="text-center pb-2">
                    <button class="btn btn-outline-secondary " id="add_edit_field1">@lang('labels.addField') &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </button>

                </div>

                <script>
                    $(document).ready(function () {
                        var max_fields = 100;
                        var wrapper = $("#addingIng");
                        var add_button = $("#add_edit_field1");

                        var x = 1;
                        $(add_button).click(function (e) {
                            e.preventDefault();
                            if (x < max_fields) {
                                x++;
                                $(wrapper).append('<div id="dynamicIngredient_edit" class=" p-2 form-row">' +
                                    '<!-- Name -->\n' +
                                    '                                    <div class="col">\n' +
                                    '                                        <input required type="text" class="form-control" placeholder=@lang('labels.ingredients') name="ingredients_edit[]">\n' +
                                    '                                    </div>\n' +
                                    '\n' +
                                    '                                    <!-- Quantity -->\n' +
                                    '                                    <div class="col">\n' +
                                    '                                        <input required type="number" min="0" class="form-control" placeholder= @lang('labels.quantity') name="quantities_edit[]">\n' +
                                    '                                    </div>\n' +
                                    '\n' +
                                    '                                    <!-- Unit -->\n' +
                                    '                                    <div class="col">\n' +
                                    '                                        <select required class="custom-select" name="units_edit[]">\n' +
                                    '                                            <option selected disabled value="" > @lang('labels.unit')</option>\n' +
                                    '                                            <option value="1">@lang('labels.ml')</option>\n' +
                                    '                                            <option value="2">@lang('labels.g')</option>\n' +
                                    '                                            <option value="3">@lang('labels.tablespoon')</option>\n' +
                                                                                '<option value="4">  @lang('labels.littleunit')</option>'+
                                    '                                        </select></div>\n' +
                                    '                                    <a href="#" class="delete pt-2"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                                    '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>' +
                                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>' +
                                    '</svg></a></div>'); //add input box
                            }
                        });

                        $(wrapper).on("click", ".delete", function (e) {
                            e.preventDefault();
                            $(this).parent('div').remove();
                            x--;
                        })
                    });
                </script>

                <br/>

                <!-- Picture for cover -->
                <label>@lang('labels.editCover')</label>


                @for($i=0; $i<$number_cover; $i++)

                    <div id="dynamicCover_edit{{$i}}">
                        <a>{{$imageCover[$i]->picture_path}}</a>


                        <a href="#" onclick="decrementCover({{$i}})" class="delete pt-2 pl-1">
                            <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <script>
                            $(document).ready(function () {

                                var wrapper = $("#dynamicCover_edit{{$i}}");

                                $(wrapper).on("click", ".delete", function (e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();
                                })


                            });
                        </script>


                    </div>
                @endfor

                <div id="addingCover">

                </div>


                <br/>
                <div class="text-center pb-1">
                    <button class="btn btn-outline-secondary " id="add_edit_field2">@lang('labels.addField') &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </button>

                </div>
                <script>
                    $(document).ready(function () {
                        var max_fields = 10;
                        var wrapper = $("#addingCover");
                        var add_button = $("#add_edit_field2");

                        var x = 1;
                        $(add_button).click(function (e) {
                            e.preventDefault();
                            if (x < max_fields) {
                                x++;
                                $(wrapper).append(' <div id="dynamicImage_edit" class="input-group mb-3 pt-2">\n' +
                                    '<div class="custom-file">\n' +
                                    '<input required type="file" accept="image/*" class="custom-file-input form-control" name="imageCover_edit[]" aria-describedby="imageCover_edit">\n' +
                                    '<label class="custom-file-label" for="imageCover_edit">@lang('labels.chooseFile')</label>\n' +
                                    '</div>' +
                                    '<a href="#" class="delete pt-2 pl-1"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                                    '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>' +
                                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>' +
                                    '</svg></a></div>'); //add input box
                                $(".custom-file-input").on("change", function () {
                                    var fileName = $(this).val().split("\\").pop();
                                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                });
                            }
                        });

                        $(wrapper).on("click", ".delete", function (e) {
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
                @for($i=1; $i<$number_step; $i++)
                    <div id="dynamicStepSlot{{$i}}">
                        <div class="input-group mb-3 pt-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@lang('labels.step')</span>
                            </div>
                            <textarea rows="4" required class="form-control" name="steps_edit[]" aria-label="steps_edit"
                                      aria-describedby="steps_edit">{{$step_text[$i]}}</textarea>
                        </div>
                        <div id="appendUpload{{$i}}" class="input-group mb-3">
                            <div id="stepSlot{{$i}}" class="custom-file">
                                <a>{{$step_image[$i-1]}}</a>
                                <a href="#" onclick="decrementStep({{$i}})" class="delete pt-2 pl-1">
                                    <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16"
                                         fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                        <path fill-rule="evenodd"
                                              d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                                <script>
                                    $(document).ready(function () {

                                        var wrapper = $("#stepSlot{{$i}}");

                                        $(wrapper).on("click", ".delete", function (e) {
                                            e.preventDefault();
                                            $(this).parent('div').remove();
                                            $($("#appendUpload{{$i}}")).append(
                                                '<div class="custom-file">' +
                                                ' <input required type="file" accept="image/*" class="custom-file-input" name="stepsImage_edit[]"/>' +
                                                '<label class="custom-file-label" for="stepsImage_edit">@lang('labels.chooseFile')</label>' +
                                                ' </div>'); //add input box
                                            $(".custom-file-input").on("change", function () {
                                                var fileName = $(this).val().split("\\").pop();
                                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                            });
                                        });


                                    });
                                </script>


                            </div>
                        </div>


                        <a href="#" onclick="decrementStep({{$i}})" class="delete pt-2 pl-1">
                            <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                      clip-rule="evenodd"/>
                            </svg>
                            @lang('labels.deleteStep')</a>
                        <script>
                            $(document).ready(function () {

                                var wrapper = $("#dynamicStepSlot{{$i}}");

                                $(wrapper).on("click", ".delete", function (e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();

                                })
                            });
                        </script>


                    </div>

                @endfor

                <script>
                    $(".custom-file-input").on("change", function () {
                        var fileName = $(this).val().split("\\").pop();
                        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                    });
                </script>

                <div id="dynamicStepSlot_edit1">

                </div>

                <br/>
                <div class="text-center pb-2">
                    <button class="btn btn-outline-secondary " id="add_edit_field3">@lang('labels.addField') &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </button>

                </div>
                <script>
                    $(document).ready(function () {
                        var max_fields = 30;
                        var wrapper = $("#dynamicStepSlot_edit1");
                        var add_button = $("#add_edit_field3");

                        var x = 1;
                        $(add_button).click(function (e) {
                            e.preventDefault();
                            if (x < max_fields) {
                                x++;
                                $(wrapper).append(' <div id="dynamicStepSlot_edit1">' +
                                    '  <div class="input-group mb-3 pt-5">' +
                                    '<div class="input-group-prepend">' +
                                    ' <span class="input-group-text">@lang('labels.step')</span>' +
                                    ' </div>' +
                                    '<textarea rows="4" required class="form-control" name="steps_edit[]" aria-label="step_edit" aria-describedby="step_edit"></textarea>' +
                                    '</div>' +
                                    '<div class="input-group mb-3">' +
                                    '<div class="custom-file">' +
                                    ' <input required type="file" accept="image/*" class="custom-file-input" name="stepsImage_edit[]"/>' +
                                    '<label class="custom-file-label" for="stepsImage_edit">@lang('labels.chooseFile')</label>' +
                                    ' </div>' +
                                    '</div>' +
                                    '<a href="#" class="delete text-center"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                                    '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>' +
                                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>' +
                                    '</svg>@lang('labels.deleteStep')</a></div>'); //add input box
                                $(".custom-file-input").on("change", function () {
                                    var fileName = $(this).val().split("\\").pop();
                                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                });
                            }
                        });

                        $(wrapper).on("click", ".delete", function (e) {
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
                @for($i=1; $i<$number_tag; $i++)
                    <div id="dynamicTags{{$i}}" class="col-sm-12 p-2 text-center">
                        <select required class="custom-select" name="tags_edit[]">
                            @if($tags[$i]==1)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option selected value="1">@lang('labels.firstDish')</option>
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
                            @elseif($tags[$i]==2)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option selected value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==3)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option selected value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==4)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option selected value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==5)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option selected value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==6)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option selected value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==7)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option selected value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==8)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option selected value="8">@lang('labels.vegetarian')</option>
                                <option value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==9)
                                <option disabled value="" selected>@lang('labels.chooseTag')</option>
                                <option value="1">@lang('labels.firstDish')</option>
                                <option value="2">@lang('labels.mainCourse')</option>
                                <option value="3">@lang('labels.dessert')</option>
                                <option value="4">@lang('labels.appetiser')</option>
                                <option value="5">@lang('labels.sideDish')</option>
                                <option value="6">@lang('labels.meat')</option>
                                <option value="7">@lang('labels.fish')</option>
                                <option value="8">@lang('labels.vegetarian')</option>
                                <option selected value="9">@lang('labels.vegan')</option>
                                <option value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==10)
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
                                <option selected value="10">@lang('labels.glutenFree')</option>
                                <option value="11">@lang('labels.withoutAll')</option>
                            @elseif($tags[$i]==11)
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
                                <option selected value="11">@lang('labels.withoutAll')</option>
                            @endif
                        </select>


                        <a href="#" class="delete pt-2 pl-1">
                            <svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <script>
                            $(document).ready(function () {

                                var wrapper = $("#dynamicTags{{$i}}");

                                $(wrapper).on("click", ".delete", function (e) {
                                    e.preventDefault();
                                    $(this).parent('div').remove();

                                })
                            });
                        </script>


                    </div>


                @endfor


                <div id="addingTags"></div>


                <br/>
                <div class="text-center pb-2">
                    <button class="btn btn-outline-secondary " id="add_edit_field4">@lang('labels.addField') &nbsp;
                        <span style="font-size:16px; font-weight:bold;">+ </span>
                    </button>

                </div>

                <script>
                    $(document).ready(function () {
                        var max_fields = 30;
                        var wrapper = $("#addingTags");
                        var add_button = $("#add_edit_field4");

                        var x = 1;
                        $(add_button).click(function (e) {
                            e.preventDefault();
                            if (x < max_fields) {
                                x++;
                                $(wrapper).append('<div id="dynamicTags_edit" class="input-group col-sm-12 text-center p-2">' +
                                    '<select required class="custom-select" name="tags_edit[]">' +
                                    '<option disabled value="" selected>@lang('labels.chooseTag')</option>' +
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

                                    '<a href="#"  class="delete pt-2 pl-2"><svg class="bi bi-trash" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">' +
                                    '<path d="M5.5 5.5A.5.5 0 016 6v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm2.5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0V6a.5.5 0 01.5-.5zm3 .5a.5.5 0 00-1 0v6a.5.5 0 001 0V6z"/>' +
                                    '<path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4h-.5a1 1 0 01-1-1V2a1 1 0 011-1H6a1 1 0 011-1h2a1 1 0 011 1h3.5a1 1 0 011 1v1zM4.118 4L4 4.059V13a1 1 0 001 1h6a1 1 0 001-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" clip-rule="evenodd"/>' +
                                    '</svg></a></div>'); //add input box
                            } else {
                                alert('You Reached the limits')
                            }
                        });

                        $(wrapper).on("click", ".delete", function (e) {
                            e.preventDefault();
                            $(this).parent('div').remove();
                            x--;
                        })
                    });
                </script>

                <br/>

                <input id="todeleteCover" type="text" name="todeleteCover" hidden>
                <input id="todeleteStepImage" type="text" name="todeleteStepImage" hidden>

                <!-- Button -->
                <div class="form-inline justify-content-around">
                    <div class="form-group mb-2">
                        <a id="cancel" href="{{route("account_all_recipes")}}" class="btn btn-danger">@lang('labels.cancel')
                        </a>

                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="submit" onclick="updateCover()" name="edit_form"
                               class="form-control btn btn-primary" value=@lang('labels.save')>
                        <script>

                            function decrementCover(i) {
                                document.getElementById("todeleteCover").value = document.getElementById("todeleteCover").value + "_" + i;
                            }


                            function decrementStep(i) {
                                document.getElementById("todeleteStepImage").value = document.getElementById("todeleteStepImage").value + "_" + i;
                            }

                        </script>

                    </div>
                </div>


            </form>
            <br/>

        </div>

    </div>
</div>

@endsection
