<?php

namespace App\Http\Controllers;

use App\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Null_;

class RecipeController extends Controller
{
    public function addRecipe(){

          if (isset($_POST['register_form'])){

            $title = $_POST['title'];
            $date = date("Y/m/d");
            $difficult = $_POST['difficult'];
            $preptime = $_POST['preptime'];
            $cookingtime = $_POST['cookingtime'];
            $doses = $_POST['doses'];
            $description = $_POST['description'];

            $count_ing = sizeof($_POST['ingredients']);
            $ingredients_name = "";
            $ingredients_quantity = "";
            for($i=0; $i<$count_ing; $i++){
                $ingredients_name = $ingredients_name."_".$_POST['ingredients'][$i];
                $ingredients_quantity = $ingredients_quantity."_".$_POST['quantities'][$i];
            }
            $ingredients_quantity = $ingredients_quantity."/";
            for( $n=0; $n<$count_ing; $n++) {
                $ingredients_quantity = $ingredients_quantity."_".$_POST['units'][$n];
            }

            $count_step= sizeof($_POST['steps']);
            $step_text="";
            for($k=0; $k<$count_step; $k++){
                $step_text = $step_text."_".$_POST['steps'][$k];
            }

            $step_images="prova";



            $count_tag= sizeof($_POST['tags']);
            $tags="";
            for($l=0; $l<$count_tag; $l++){
                $tags = $tags."_".$_POST['tags'][$l];
            }

        }

        session_start();
        $dl = new DataLayer();

        $user_id = $dl->getUserIDbyUsername($_SESSION['loggedName']);
        $recipe = array('title'=>$title, 'description'=>$description, 'preparation_time'=> $preptime, 'cooking_time'=>$cookingtime, 'difficult'=> $difficult, 'doses'=> $doses, 'user_id'=>$user_id,'date'=>$date, 'ingredients_name'=>$ingredients_name, 'ingredients_quantity'=>$ingredients_quantity, 'steps_text'=>$step_text, 'steps_image'=>$step_images,'tags'=> $tags, 'approved'=>0, 'comment'=>NULL);

        $dl->addRecipeDB($recipe);
        $recipe_id = $dl->getLastRecipeUserInsert($user_id);

        if (isset($_FILES['stepsImage'])){


            $path='upload/'. $recipe_id.'/';
            mkdir($path,0777,true);
            $step_images="";

            for($t=0; $t<$count_step; $t++){
                if($_FILES['stepsImage']['type'][$t] !== ""){

                    move_uploaded_file($_FILES['stepsImage']['tmp_name'][$t], $path . $_FILES['stepsImage']['name'][$t]);
                    $image = array('picture_path'=>$path . $_FILES['stepsImage']['name'][$t],'recipe_id'=>null);
                    $dl->addImageRecipe($image);
                    $image_id = $dl->getLastImageInsert($path . $_FILES['stepsImage']['name'][$t]);
                    $step_images = $step_images."_".$image_id;
                }
                else{

                    $n= rand(1, 6);
                    $default_path = 'image/default_step_image/'.$n.'.jpg';
                    $image = array('picture_path'=>$default_path,'recipe_id'=>null);
                    $dl->addImageRecipe($image);
                    $image_id = $dl->getLastImageInsert($default_path . $_FILES['stepsImage']['name'][$t]);
                    $step_images = $step_images."_".$image_id;

                }


            }

            $dl->updateImageRecipeSteps($recipe_id,$step_images);
        }


        if (isset($_FILES['imageCover'])) {
            $imgCover = count($_FILES['imageCover']['name']);

            $pathCover = 'upload_cover/' . $recipe_id . '/';
            mkdir($pathCover, 0777, true);

            for ($t = 0; $t < $imgCover; $t++) {

                if($_FILES['imageCover']['type'][$t] !== ""){
                    move_uploaded_file($_FILES['imageCover']['tmp_name'][$t], $pathCover . $_FILES['imageCover']['name'][$t]);
                    $image = array('picture_path' => $pathCover . $_FILES['imageCover']['name'][$t], 'recipe_id' => $recipe_id);
                    $dl->addImageRecipe($image);
                }
                else{
                    $path_default = 'image/default_cover.jpg';
                    $image = array('picture_path' => $path_default, 'recipe_id' => $recipe_id);
                    $dl->addImageRecipe($image);
                }

            }
        }
        else{
            $path_default = 'image/default_cover.jpg';

            $image = array('picture_path' => $path_default, 'recipe_id' => $recipe_id);
            $dl->addImageRecipe($image);

        }

       return Redirect::to(route('account_all_recipes'));

    }

    public function editRecipe($id){

        session_start();
        $dl = new DataLayer();
        $rec = $dl->getRecipeByID($id);

        if(isset($_SESSION['logged'])) {

            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if (($rec->approved != 0) && ($user->isModerator || $user->id == $rec->user_id)) {
                if (isset($_POST['edit_form'])) {


                    $title = $_POST['title_edit'];
                    $difficult = $_POST['difficult_edit'];
                    $preptime = $_POST['preptime_edit'];
                    $cookingtime = $_POST['cookingtime_edit'];
                    $doses = $_POST['doses_edit'];
                    $description = $_POST['description_edit'];

                    $count_ing = sizeof($_POST['ingredients_edit']);
                    $ingredients_name = "";
                    $ingredients_quantity = "";


                    for ($i = 0; $i < $count_ing; $i++) {
                        $ingredients_name = $ingredients_name . "_" . $_POST['ingredients_edit'][$i];
                        $ingredients_quantity = $ingredients_quantity . "_" . $_POST['quantities_edit'][$i];
                    }
                    $ingredients_quantity = $ingredients_quantity . "/";
                    for ($n = 0; $n < $count_ing; $n++) {
                        $ingredients_quantity = $ingredients_quantity . "_" . $_POST['units_edit'][$n];
                    }


                    $count_step = sizeof($_POST['steps_edit']);
                    $step_text = "";
                    for ($k = 0; $k < $count_step; $k++) {
                        $step_text = $step_text . "_" . $_POST['steps_edit'][$k];
                    }


                    if (isset($_FILES['stepsImage_edit'])) {
                        $t = 0;
                        $new_step = "";

                        //Creo il path per le nuove foto
                        $path = 'upload/' . $id . '/';
                        //Nuove da sostituire o aggiungere
                        $img = count($_FILES['stepsImage_edit']['type']);

                        if ($_POST['todeleteStepImage'] != null) {

                            //Da eliminare
                            $todelete = explode("_", $_POST['todeleteStepImage']);
                            for ($i = 0; $i < count($todelete) - 1; $i++) {
                                $todelete[$i] = $todelete[$i + 1];
                            }

                            //array contenente gli indici da eliminare
                            $withoutCopies = array_unique($todelete);

                            //recupero gli step già presenti
                            $old_steps_text = $dl->getStepImages($id);
                            $old_step = explode("_", $old_steps_text);
                            unset($old_step[0]);

                            for ($i = 0; $i < count($withoutCopies); $i++) {
                                $j = $withoutCopies[$i];
                                $dl->deleteImage($old_step[$j]);
                                $old_step[$j] = -1;
                            }

                            $old_step = array_values($old_step);

                            for ($i = 0; $i < count($old_step); $i++) {
                                if ($old_step[$i] == -1) {

                                    if($_FILES['stepsImage_edit']['type'][$t] !== ""){
                                        move_uploaded_file($_FILES['stepsImage_edit']['tmp_name'][$t], $path . $_FILES['stepsImage_edit']['name'][$t]);
                                        $image = array('picture_path' => $path . $_FILES['stepsImage_edit']['name'][$t], 'recipe_id' => null);
                                        $dl->addImageRecipe($image);
                                        $image_id = $dl->getLastImageInsert($path . $_FILES['stepsImage_edit']['name'][$t]);
                                        $old_step[$i] = $image_id;
                                        $t++;
                                    }
                                    else{
                                        $n= rand(1, 6);
                                        $default_path = 'image/default_step_image/'.$n.'.jpg';
                                        $image = array('picture_path' => $default_path, 'recipe_id' => null);
                                        $dl->addImageRecipe($image);
                                        $image_id = $dl->getLastImageInsert($default_path . $_FILES['stepsImage_edit']['name'][$t]);
                                        $old_step[$i] = $image_id;
                                        $t++;
                                    }



                                }


                            }


                            if (count($old_step) == 0) {
                                $new_step = $new_step . '_';
                            } else {
                                for ($i = 0; $i < count($old_step); $i++) {
                                    $new_step = $new_step . '_' . $old_step[$i];
                                }
                            }
                        } else {

                            $new_step = $dl->getStepImages($id);
                        }


                        for ($k = $t; $k < $img; $k++) {
                            if($_FILES['stepsImage_edit']['type'][$k] !== ""){
                                move_uploaded_file($_FILES['stepsImage_edit']['tmp_name'][$k], $path . $_FILES['stepsImage_edit']['name'][$k]);
                                $image = array('picture_path' => $path . $_FILES['stepsImage_edit']['name'][$k], 'recipe_id' => null);
                                $dl->addImageRecipe($image);
                                $image_id = $dl->getLastImageInsert($path . $_FILES['stepsImage_edit']['name'][$k]);
                                $new_step = $new_step . '_' . $image_id;
                            }
                            else {
                                $n= rand(1, 6);
                                $default_path = 'image/default_step_image/'.$n.'.jpg';
                                $image = array('picture_path'=>$default_path,'recipe_id'=>null);
                                $dl->addImageRecipe($image);
                                $image_id = $dl->getLastImageInsert($default_path . $_FILES['stepsImage_edit']['name'][$k]);
                                $new_step = $new_step."_".$image_id;
                            }

                        }


                        $dl->updateImageRecipeSteps($id, $new_step);


                    } else {

                        if ($_POST['todeleteStepImage'] != null) {

                            $new_step = "";
                            //Da eliminare
                            $todelete = explode("_", $_POST['todeleteStepImage']);
                            for ($i = 0; $i < count($todelete) - 1; $i++) {
                                $todelete[$i] = $todelete[$i + 1];
                            }


                            //array contenente gli indici da eliminare
                            $withoutCopies = array_unique($todelete);


                            //recupero gli step già presenti
                            $old_steps_text = $dl->getStepImages($id);
                            $old_step = explode("_", $old_steps_text);

                            unset($old_step[0]);


                            for ($i = 0; $i < count($withoutCopies); $i++) {
                                $j = $withoutCopies[$i];
                                unset($old_step[$j]);
                            }


                            $old_step = array_values($old_step);

                            echo "<pre>", print_r($old_step), "</pre>";


                            if (count($old_step) == 0) {
                                $new_step = $new_step . '_';
                            } else {
                                for ($i = 0; $i < count($old_step); $i++) {
                                    $new_step = $new_step . '_' . $old_step[$i];
                                }
                            }

                            $dl->updateImageRecipeSteps($id, $new_step);
                        }


                    }


                    $count_tag = sizeof($_POST['tags_edit']);
                    $tags = "";
                    for ($l = 0; $l < $count_tag; $l++) {
                        $tags = $tags . "_" . $_POST['tags_edit'][$l];
                    }

                }


                $approved = 0;

                $dl->updateRecipe($title, $description, $preptime, $cookingtime, $difficult, $doses, $ingredients_name, $ingredients_quantity, $step_text, $tags, $id, $approved, NULL);


                if ($_POST['todeleteCover'] != null) {

                    $todeleteCover = explode("_", $_POST['todeleteCover']);
                    for ($i = 0; $i < count($todeleteCover) - 1; $i++) {
                        $todeleteCover[$i] = $todeleteCover[$i + 1];
                    }

                    $oldcovers = $dl->getRecipeCovers($id);

                    for ($i = 0; $i < count($oldcovers); $i++) {
                        for ($j = 0; $j < count($todeleteCover); $j++) {

                            if ($i == ($todeleteCover[$j])) {
                                $dl->deleteImage($oldcovers[$i]->id);
                            }

                        }

                    }
                }


                if (isset($_FILES['imageCover_edit'])) {

                    $imgCover = count($_FILES['imageCover_edit']['name']);

                    $pathCover = 'upload_cover/' . $id . '/';

                    for ($t = 0; $t < $imgCover; $t++) {
                        if($_FILES['imageCover_edit']['type'][$t] !== ""){
                            move_uploaded_file($_FILES['imageCover_edit']['tmp_name'][$t], $pathCover . $_FILES['imageCover_edit']['name'][$t]);
                            $image = array('picture_path' => $pathCover . $_FILES['imageCover_edit']['name'][$t], 'recipe_id' => $id);
                            $dl->addImageRecipe($image);
                        }
                        else {
                            $path_default = 'image/default_cover.jpg';
                            $image = array('picture_path' => $path_default, 'recipe_id' => $id);
                            $dl->addImageRecipe($image);
                        }

                    }

                }


                return Redirect::to(route('account_all_recipes'));

            }
            else{
                return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);
            }
        }
        else{
            return view('error_view')->with('logged',false);
        }

    }

    public function addFavorite(Request $request){
        $user_id = $request['user_id'];
        $recipe_id = $request['recipe_id'];

        session_start();
        $dl = new DataLayer();

        $dl->addToFavorites($recipe_id,$user_id);
        return null;
    }


    public function removeFavorite(Request $request){
        $user_id = $request['user_id'];
        $recipe_id = $request['recipe_id'];

        session_start();
        $dl = new DataLayer();

        $dl->removeFromFavorites($recipe_id,$user_id);
        return null;
    }

    public function deleteRecipe($id){
        session_start();
        $dl = new DataLayer();
        $rec = $dl->getRecipeByID($id);

        if(isset($_SESSION['logged'])) {

            $user = $dl->getUserbyUsername($_SESSION['loggedName']);
            if ($user->id == $rec->user_id) {
                $dl->removeRecipe($id);
                return Redirect::to(route('account_all_recipes'));
            }
            else{
                return view('error_view')->with('logged',true)->with('loggedName', $_SESSION['loggedName']);

            }
        }
        else {
            return view('error_view')->with('logged',false);
        }

    }

    public function getSearchType($type){
        session_start();
        $dl = new DataLayer();


        $recipes_all = $dl->getAllRecipe();

        $result = array();

        $recipes = array();
        foreach ($recipes_all as $recipe_ok) {
            if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
                array_push($recipes, $recipe_ok);
            }
        }

        foreach ($recipes as $recipe){
            $recipe_tag = $recipe->tags;
            $explode_tag = explode("_", $recipe_tag);
            array_shift($explode_tag);

            if(in_array($type,$explode_tag)){
                array_push($result,$recipe->id);
            }
        }

        echo "<pre>", print_r($result), "</pre>";



        return Redirect::to(route('search_advanced_get',['array'=>json_encode($result)]));

    }

    public function getSearchResult(Request $request){
        session_start();
        $dl = new DataLayer();




        $id_recipes_ok = array();
        $recipes_all = $dl->getAllRecipe();

        $recipes = array();
        foreach ($recipes_all as $recipe_ok) {
            if($recipe_ok->approved == 1 || $recipe_ok->approved == 3){
                array_push($recipes, $recipe_ok);
            }
        }


        $list_tags = array("First dish","Main course","Dessert","Appetizer", "Side dish" ,"Meat", "Fish", "Vegetarian", "Vegan", "Gluten Free", "Without allergens");
        $numbers = array("1","2","3","4","5","6","7","8","9","10","11");
        array_shift($_POST);

        $element_key = array_keys($_POST);
        $present_tag = array();
        $present_ingredients = array();

        if(count($_POST) == 0){
            return Redirect::to(route('search_advanced_get',['array'=>json_encode(array())]));
        }

        if($element_key[0] == "method__research__toggle"){
            array_shift($element_key);

            foreach ($element_key as $item) {
                $item = str_replace("_", " ", $item);
                if (in_array($item, $list_tags)) {
                    array_push($present_tag, $item);
                } else {
                    array_push($present_ingredients, $item);
                }
            }


            $number_tag = str_replace($list_tags, $numbers, $present_tag);
            $n_tag = count($number_tag);
            $n_ing = count($present_ingredients);
            echo $n_ing;
            echo $n_tag;

            echo "<pre>", print_r($element_key), "</pre>";


            foreach ($recipes as $recipe) {
                $tag_ok = 0;
                $ing_ok = 0;

                $recipe_ing = $recipe->ingredients_name;
                $explode_ing = explode("_", $recipe_ing);
                array_shift($explode_ing);
                $recipe_tag = $recipe->tags;
                $explode_tag = explode("_", $recipe_tag);
                array_shift($explode_tag);

                foreach ($explode_tag as $tag) {
                    if (in_array($tag, $number_tag)) {
                        $tag_ok++;
                    }
                }

                foreach ($explode_ing as $item_ing) {
                    if (in_array($item_ing, $present_ingredients)) {
                        $ing_ok++;
                    }
                }

                if($ing_ok==$n_ing && $tag_ok==$n_tag){
                    array_push($id_recipes_ok, $recipe->id);
                }

            }

            echo $tag_ok;
            echo $ing_ok;
        }
        else {
            foreach ($element_key as $item) {
                $item = str_replace("_", " ", $item);
                if (in_array($item, $list_tags)) {
                    array_push($present_tag, $item);
                } else {
                    array_push($present_ingredients, $item);
                }
            }


            $number_tag = str_replace($list_tags, $numbers, $present_tag);


            foreach ($recipes as $recipe) {
                $recipe_ing = $recipe->ingredients_name;
                $explode_ing = explode("_", $recipe_ing);
                array_shift($explode_ing);
                $recipe_tag = $recipe->tags;
                $explode_tag = explode("_", $recipe_tag);
                array_shift($explode_tag);

                foreach ($explode_tag as $tag) {
                    if (in_array($tag, $number_tag)) {
                        array_push($id_recipes_ok, $recipe->id);
                    }
                }

                foreach ($explode_ing as $item_ing) {
                    if (in_array($item_ing, $present_ingredients)) {
                        array_push($id_recipes_ok, $recipe->id);
                    }
                }

            }

        }


        $unique = array_unique($id_recipes_ok);
        $ordered = array_values($unique);


        return Redirect::to(route('search_advanced_get',['array'=>json_encode($ordered)]));

    }


    public function acceptRecipe(Request $request){
        $recipe_id = $request['recipe_id'];
        $comment = $request->input('comment');

        session_start();
        $dl = new DataLayer();
        $dl->modifyApprovedRecipe(3, $recipe_id, $comment);

        return null;
    }


    public function declineRecipe(Request $request){
        $recipe_id = $request['recipe_id'];
        $comment = $request->input('comment');
        session_start();
        $dl = new DataLayer();
        $dl->modifyApprovedRecipe(2,$recipe_id, $comment);

        return null;
    }

    public function correctRecipe(Request $request){
        $recipe_id = $request['recipe_id'];

        session_start();
        $dl = new DataLayer();
        $dl->modifyApprovedRecipe(1, $recipe_id,NULL);

        return null;
    }

    public function reviewRecipe(Request $request){
        $recipe_id = $request['recipe_id'];

        session_start();
        $dl = new DataLayer();
        $dl->modifyApprovedRecipe(0, $recipe_id,NULL);

        return null;
    }
}
