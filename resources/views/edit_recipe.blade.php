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


            <form id="edit_form{{$recipe->id}}" action="{{route('edit_recipe',['id'=>$recipe->id])}}" method="post" enctype="multipart/form-data">
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
                            <p><input id="title_edit" name="title_edit" value="{{$recipe->title}}" type="text" class="form-control" aria-label="Title" aria-describedby="title"></p>
                            <label><strong>@lang('labels.description'):</strong></label>
                            <p><textarea rows="5" class="form-control" onkeyup="countCharE(this)" id="description_edit" name="description_edit" aria-label="description" aria-describedby="description">{{$recipe->description}}</textarea></p>
                            <small id="charNumE">{{strlen($recipe->description)}}</small><small>/350</small>
                            <br>
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
                            <br>


                            <label>@lang('labels.insertCover')</label>

                            @for($i=0; $i<$number_cover; $i++)

                                <div id="dynamicCover_edit{{$i}}">
                                    <a>{{$imageCover[$i]->picture_path}}</a>


                                    <a href="#" onclick="decrementCover({{$i}})" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a>
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

                            <br>

                            <div style="text-align: center; border: 0px solid">
                                <button class="btn btn-outline-secondary" id="add_edit_field2">@lang('labels.addImage') &nbsp;
                                    <span style="font-size:16px; font-weight:bold;">+ </span>
                                </button>
                            </div>




                            <script>
                                $(document).ready(function() {
                                    var max_fields = 10;
                                    var wrapper = $("#addingCover");
                                    var add_button = $("#add_edit_field2");

                                    var x = 1;
                                    $(add_button).click(function(e) {
                                        e.preventDefault();
                                        if (x < max_fields) {
                                            x++;

                                            $(wrapper).append(' <div id="dynamicImage_edit" class="input-group mb-3 pt-2">\n'+
                                                '<div class="custom-file">\n'+
                                                '<input id="imageCover_edit"  type="file" accept="image/*"  class="custom-file-input form-control" name="imageCover_edit[]" aria-describedby="imageCover">\n'+
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
                                <input @if($recipe->difficult == 1) checked @endif type="radio" id="customRadio1" value="1" name="difficult_edit" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio1">@lang('labels.easy')</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input @if($recipe->difficult == 2) checked @endif type="radio" id="customRadio2" value="2" name="difficult_edit" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2">@lang('labels.mid')</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input @if($recipe->difficult == 3) checked @endif type="radio" id="customRadio3" value="3" name="difficult_edit" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3">@lang('labels.expert')</label>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-auto">
                                    </label><label style="color: darkred">*</label><img src="{{asset('image/icons_View/hand_kitchen_mixer_icon.png')}}" alt="" class="icon">
                                    <label><strong>@lang('labels.preptime'):</strong>
                                </div>
                                <div class="col-auto">
                                    <input value="{{$recipe->preparation_time}}" style="width: 150px" min=0 max=200 name="preptime_edit" id="preptime_edit" type="number"  class="form-control" aria-label="Preparation time" aria-describedby="prep">
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
                                    <input value="{{$recipe->cooking_time}}" style="width: 150px" min=0 max=200 name="cookingtime_edit" id="cookingtime_edit" type="number" class="form-control" aria-label="Cooking time" aria-describedby="cook">
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
                                    <input value="{{$recipe->doses}}" style="width: 150px" min=0 max=200 name="doses_edit" id="doses_edit" type="number" class="form-control" aria-label="Doses" aria-describedby="doses">
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
                            @for($i=1; $i<$number_ing; $i++)

                                <div id="dynamicIngredient_edit{{$i}}" class="form-row p-2">
                                    <!-- Name -->
                                    <div class="col-auto">
                                        <span style="color: darkred"><strong>*</strong></span>
                                    </div>
                                    <div class="col">
                                        <input value="{{$ingredients_n[$i]}}" type="text" class="form-control"
                                               name="ingredients_edit[]">

                                    </div>
                                    <div class="col-auto">
                                        <span style="color: darkred"><strong>*</strong></span>
                                    </div>
                                    <!-- Quantity -->
                                    <div class="col">
                                        <input value={{$ingredients_q[$i]}} type="number" step="0.01" min="0" class="form-control"
                                               name="quantities_edit[]">
                                    </div>

                                    <!-- Unit -->
                                    <div class="col">
                                        <select class="custom-select" name="units_edit[]">';
                                            @if($ingredients_u[$i]==1)
                                                <option selected value="1">@lang('labels.ml')</option>
                                                <option value="2"> @lang('labels.g')</option>
                                                <option value="3">@lang('labels.tablespoon')</option>
                                                <option value="4">  @lang('labels.littleunit')</option>
                                                <option value="5">@lang('labels.qb')</option>

                                            @elseif ($ingredients_u[$i]==2)
                                                <option value="1">@lang('labels.ml')</option>
                                                <option selected value="2"> @lang('labels.g')</option>
                                                <option value="3">@lang('labels.tablespoon')</option>
                                                <option value="4">  @lang('labels.littleunit')</option>
                                                <option value="5">@lang('labels.qb')</option>
                                            @elseif ($ingredients_u[$i]==3)
                                                <option value="1">@lang('labels.ml')</option>
                                                <option value="2"> @lang('labels.g')</option>
                                                <option selected value="3">@lang('labels.tablespoon')</option>
                                                <option value="4">  @lang('labels.littleunit')</option>
                                                <option value="5">@lang('labels.qb')</option>
                                            @elseif ($ingredients_u[$i]==4)
                                                <option value="1">@lang('labels.ml')</option>
                                                <option value="2"> @lang('labels.g')</option>
                                                <option value="3">@lang('labels.tablespoon')</option>
                                                <option selected value="4">  @lang('labels.littleunit')</option>
                                                <option value="5">@lang('labels.qb')</option>
                                            @else
                                                <option value="1">@lang('labels.ml')</option>
                                                <option value="2"> @lang('labels.g')</option>
                                                <option value="3">@lang('labels.tablespoon')</option>
                                                <option value="4">  @lang('labels.littleunit')</option>
                                                <option selected value="5">@lang('labels.qb')</option>
                                            @endif
                                        </select>
                                    </div>


                                    @if($i>=2)
                                        <a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a>


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



                            <div id="addIng"></div>

                            <br/>

                            <div class="text-center pb-2">
                                <button class="btn btn-outline-secondary " id="add_edit_field1">@lang('labels.add_ingredient')
                                    <span style="font-size:16px; font-weight:bold;">+ </span>
                                </button>
                            </div>

                            <script>
                                $(document).ready(function() {
                                    var max_fields = 100;
                                    var wrapper = $("#addIng");
                                    var add_button = $("#add_edit_field1");

                                    var x = 1;
                                    $(add_button).click(function(e) {
                                        e.preventDefault();
                                        if (x < max_fields) {
                                            x++;
                                            e = x;
                                            $(wrapper).append('<div id="dynamicIngredient_edit" class=" p-2 form-row">' +
                                                '<!-- Name -->\n' +
                                                '                                    <div class="col-auto">\n' +
                                                '                                            <span style="color: darkred"><strong>*</strong></span>\n' +
                                                '                                        </div>' +
                                                '                                        <div class="col">\n' +
                                                '                                        <input oninput="this.className = \'\'" type="text" class="form-control" placeholder=@lang('labels.ingredients') name="ingredients_edit[]">\n' +
                                                '                                    </div>\n' +
                                                '\n' +
                                                '                                    <!-- Quantity -->\n' +
                                                '                                    <div class="col-auto">\n' +
                                                '                                            <span style="color: darkred"><strong>*</strong></span>\n' +
                                                '                                        </div><div class="col">\n' +
                                                '                                        <input oninput="this.className = \'\'" type="number" step="0.01" min="0" class="form-control" placeholder=@lang('labels.quantity') name="quantities_edit[]">\n' +
                                                '                                    </div>\n' +
                                                '\n' +
                                                '                                    <!-- Unit -->\n' +
                                                '                                    <div class="col">\n' +
                                                '                                        <select class="custom-select" name="units_edit[]">\n' +
                                                '                                            <option value="1" selected>@lang('labels.ml')</option>\n' +
                                                '                                            <option value="2">@lang('labels.g')</option>\n' +
                                                '                                            <option value="3">@lang('labels.tablespoon')</option>\n'+
                                                '                                            <option value="4">@lang('labels.littleunit')</option>'+
                                                '                                            <option value="5">@lang('labels.qb')</option>\n'+
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
                            @for($i=1; $i<$number_step; $i++)
                                <div id="dynamicStepSlot{{$i}}">

                                    <label><strong>@lang('labels.step'):</strong></label><label style="color: darkred"> *</label>

                                    <textarea rows="4" required class="form-control" name="steps_edit[]" aria-label="steps_edit"
                                              aria-describedby="steps_edit">{{$step_text[$i]}}</textarea>

                                    <div id="appendUpload{{$i}}" class="input-group mb-3">
                                        <div id="stepSlot{{$i}}" class="custom-file">
                                            <a>{{$step_image[$i-1]}}</a>
                                            <a href="#" onclick="decrementStep({{$i}})" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a>

                                            <script>
                                                $(document).ready(function () {

                                                    var wrapper = $("#stepSlot{{$i}}");

                                                    $(wrapper).on("click", ".delete", function (e) {
                                                        e.preventDefault();
                                                        $(this).parent('div').remove();
                                                        $($("#appendUpload{{$i}}")).append(
                                                            '<div class="custom-file">' +
                                                            ' <input type="file" accept="image/*" class="custom-file-input" name="stepsImage_edit[]"/>' +
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


                                    <a href="#" onclick="decrementStep({{$i}})" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.deleteStep')</a>

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
                                $(".custom-file-input").on("change", function() {
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
                                $(document).ready(function() {
                                    var max_fields = 30;
                                    var wrapper = $("#dynamicStepSlot_edit1");
                                    var add_button = $("#add_edit_field3");

                                    var x = 1;
                                    $(add_button).click(function(e) {
                                        e.preventDefault();
                                        if (x < max_fields) {
                                            x++;

                                            $(wrapper).append('<div id="dynamicStepSlot_edit1">'+
                                                '<br><label><strong>@lang('labels.step'):</strong></label><label style="color: darkred"> *</label>\n' +
                                                '                                        <textarea rows="4" class="form-control" name="steps_edit[]" aria-label="steps" aria-describedby="steps"></textarea>\n' +
                                                '                                        <br>\n' +

                                                '                                           <div class="custom-file">\n' +
                                                '                                            <input type="file" accept="image/*" class="custom-file-input" name="stepsImage_edit[]"/>\n' +
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
                                <h2>@lang('labels.tag')</h2>
                            </div>
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

                                    @if($i>=2)
                                        <a href="#" class="delete pt-2 pl-1" style="color: #c72222"><i class="fas fa-minus-square"></i> @lang('labels.remove')</a>

                                        <script>
                                            $(document).ready(function () {

                                                var wrapper = $("#dynamicTags{{$i}}");

                                                $(wrapper).on("click", ".delete", function (e) {
                                                    e.preventDefault();
                                                    $(this).parent('div').remove();

                                                })
                                            });
                                        </script>
                                    @endif

                                </div>


                            @endfor

                            <div id="addingTags"></div>


                            <br/>
                            <div class="text-center pb-2">
                                <button class="btn btn-outline-secondary " id="add_edit_field4">@lang('labels.addTag') &nbsp;
                                    <span style="font-size:16px; font-weight:bold;">+ </span>
                                </button>

                            </div>

                            <script>
                                $(document).ready(function() {
                                    var max_fields = 30;
                                    var wrapper = $("#addingTags");
                                    var add_button = $("#add_edit_field4");

                                    var x = 1;

                                    $(add_button).click(function(e) {
                                        e.preventDefault();
                                        if (x < max_fields) {
                                            x++;

                                            $(wrapper).append('<div id="addingTags" class="input-group col-sm-12 text-center p-2">' +
                                                '<select class="custom-select" name="tags_edit[]">'+
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

                        <input id="todeleteCover" type="text" name="todeleteCover" hidden>
                        <input id="todeleteStepImage" type="text" name="todeleteStepImage" hidden>
                        <script>

                            function decrementCover(i) {
                                document.getElementById("todeleteCover").value = document.getElementById("todeleteCover").value + "_" + i;
                            }


                            function decrementStep(i) {
                                document.getElementById("todeleteStepImage").value = document.getElementById("todeleteStepImage").value + "_" + i;
                            }

                        </script>

                        <div  class="text-center">
                            <div class="pt-3  ">
                                <input style="width: auto" type="submit" id="submit" name="edit_form" class="form-control btn btn-success" value=@lang('labels.save')>
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
                                else{

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


            <br/>

        </div>

    </div>
</div>

@endsection
