<?php

namespace App;

use Illuminate\Support\Facades\DB;

class DataLayer
{

    public function addUser($username, $firstname, $lastname, $birthday, $email, $password) {
        $user = new webUser();
        $user->username = $username;
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->birthday = $birthday;
        $user->email = $email;
        $user->password = md5($password);
        $user->ban = 0;
        $user->save();
    }

    public function validateUser($username, $password){
        $user = DB::table('user')->where('username',$username)->get()->first();

        if($user != NULL){
            if($user->password === md5($password)){
                return true;
            }
        }
        return false;
    }

    public function thereIsUser($username){
        $user = DB::table('user')->where('username',$username)->get()->first();

        if($user != NULL){
            return true;
        }
        return false;
    }

    public function getUserbyUsername($username){
        return DB::table('user')->where('username',$username)->get()->first();
    }

    public function getUserIDbyUsername($username){
        return DB::table('user')->where('username',$username)->value('id');
    }

    public function getFavoritesArray($favorites){
        return explode("-",$favorites);
    }

    public function getRecipeByID($id){
        $recipe = Recipe::where('id',$id)->first();
        //$recipe = DB::table('recipe')->where('id',$id)->first();
        return $recipe;
    }

    public function getLastRecipeUserInsert($user_id){
        return DB::table('recipe')->where('user_id', $user_id)->orderBy('id', 'desc')->value('id');
    }


    public function addRecipeDB($recipe){
        DB::table('recipe')->insert($recipe);
    }

    public function addImageRecipe($image){
        DB::table('picture')->insert($image);
    }

    public function updateImageRecipeSteps($recipe_id,$step_images){
       // DB::table('image')->where('id',$recipe_id)->update(['steps_image'=>$recipe_id]);
        DB::update('update recipe set steps_image = ? where id =?', [$step_images,$recipe_id]);
    }

    public function updateRecipe($title, $description, $preptime, $cookingtime, $difficult,$doses,  $ingredients_name,$ingredients_quantity,$step_text, $tags,  $id, $approved, $comment){
        DB::update('update recipe set title = ?, description = ?, preparation_time = ?, cooking_time = ?, difficult = ?, doses = ?, ingredients_name = ?, ingredients_quantity = ?, steps_text = ?, tags = ?, approved = ?, comment = ? WHERE id = ?',[$title, $description, $preptime, $cookingtime, $difficult,$doses,  $ingredients_name,$ingredients_quantity,$step_text, $tags, $approved, $comment, $id]);
    }

    public function getLastImageInsert($path){
        return DB::table('picture')->where('picture_path',$path )->orderBy('id', 'desc')->value('id');
    }

    public function getUserRecipe($user_id){
        return DB::table('recipe')->where('user_id',$user_id)->orderByDesc('date')->get();
    }

    public function getFirstCoverImage($recipe_id){
        return DB::table('picture')->where('recipe_id',$recipe_id )->orderBy('id', 'desc')->value('picture_path');
    }

    public function getRecipeCovers($recipe_id){
        return DB::table('picture')->where('recipe_id',$recipe_id)->get();
    }

    public function getImagePathFromID($id){
        return DB::table('picture')->where('id',$id)->value('picture_path');

    }

    public function getAllRecipe(){
        return DB::table('recipe')->orderByDesc('date')->get();
    }

    public function getAllRecipeAZ(){
        return DB::table('recipe')->orderBy('title')->get();
    }


    public function getAllRecipeAZPaginate(){
        return DB::table('recipe')->orderBy('title')->paginate(2);
    }

    public function getAllRecipeDate(){
        return DB::table('recipe')->orderBy('date')->get();
    }

    public function getUserByID($id){
        return DB::table('user')->where('id',$id)->get()->first();
    }

    public function getStepImages($recipe_id){
        return DB::table('recipe')->where('id', $recipe_id)->value('steps_image');
    }

    public function deleteImage($id){
        DB::delete("DELETE FROM picture WHERE id = ?",[$id]);
    }

    public function addToFavorites($recipe_id, $user_id){

        $favorites =  DB::table('user')->where('id',$user_id)->value('favorites');
        if($favorites==null){
            $favorites = $recipe_id.'_';
        }
        else{
            $favorites = $favorites.$recipe_id.'_';
        }

        DB::update('UPDATE `user` SET `favorites` = ? WHERE `user`.`id` = ?;',[$favorites, $user_id]);

    }

    public function removeFromFavorites($recipe_id, $user_id){

        $favorites =  DB::table('user')->where('id',$user_id)->value('favorites');

        $favorites_list = explode("_", $favorites);
        unset($favorites_list[count($favorites_list)-1]);
        array_values($favorites_list);

        for($i=0; $i<count($favorites_list); $i++){
                if ($recipe_id == $favorites_list[$i]) {
                    unset($favorites_list[$i]);

                }
        }
        unset($favorites_list[count($favorites_list)]);
        array_values($favorites_list);

        $newfavorites = null;

        $favorites_list = array_values($favorites_list);
        if(count($favorites_list)!=0){
            for($i=0; $i<count($favorites_list); $i++){
                if($i==0){
                    $newfavorites = $favorites_list[$i].'_';
                }
                else{
                    $newfavorites = $newfavorites.$favorites_list[$i].'_';
                }
            }
        }


        DB::update('UPDATE `user` SET `favorites` = ? WHERE `user`.`id` = ?;',[$newfavorites, $user_id]);
    }


    public function isFavorite($recipe_id, $user_id){
        $favorites =  DB::table('user')->where('id',$user_id)->value('favorites');

        if($favorites!=null){
            $listFavId = explode("_", $favorites);

            for($i=0; $i<count($listFavId); $i++){
                if($recipe_id == $listFavId[$i]){
                    return true;
                }
            }
        }

        return false;
    }

    public function insertComment($comment){
        DB::table('comment')->insert($comment);
    }

    public function getCommentByRecipe($recipe_id){
        return DB::table('comment')->where('recipe_id', $recipe_id)->get();
    }

    public function getAllUsername(){
        return DB::table('user')->get('username');
    }

    public function getAllPassword(){
        return DB::table('user')->get('password');
    }

    public function removeRecipe($id){
        DB::delete("DELETE FROM recipe WHERE id = ?",[$id]);
    }

    public function removeComment($id){
        DB::delete("DELETE FROM comment WHERE id = ?",[$id]);
    }

    public function editUserPassword($id, $newpassword){
        DB::update('UPDATE `user` SET `password` = ? WHERE `user`.`id` = ?;',[$newpassword, $id]);
    }

    public function editUserInformation($id, $firstname, $lastname, $birthday, $email){
        DB::update('UPDATE `user` SET `firstname` = ?, `lastname` = ?, `birthday` = ?, `email` = ?  WHERE `user`.`id` = ?;',[ $firstname, $lastname, $birthday, $email, $id]);
    }

    public function getAllIngredients(){
        $ingredients = DB::table('recipe')->get('ingredients_name');

        $list_item = array();
        $list_ingredients = array();

        foreach ($ingredients as $ingredient){
            $list_item = explode("_", $ingredient->ingredients_name);
            array_shift($list_item);
            foreach ($list_item as $item) {
                array_push($list_ingredients,$item );
            }
        }

        $unique = array_unique($list_ingredients);
        sort($unique);
        $ordered = array_values($unique);
        return $ordered;
    }

    public function modifyApprovedRecipe($approved, $id, $comment){
        DB::update('update recipe set approved = ?, comment = ? WHERE id = ?', [$approved, $comment, $id]);
    }

    public function  editUserRole($user_id, $role){
        if($role == 1){
          DB::update('UPDATE `user` SET `isAdmin` = ? WHERE `user`.`id` = ?;',[1, $user_id]);
          DB::update('UPDATE `user` SET `isEditor` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isModerator` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
        }
        else if($role == 2){
          DB::update('UPDATE `user` SET `isAdmin` = ? WHERE `user`.`id` = ?;',[1, $user_id]);
          DB::update('UPDATE `user` SET `isEditor` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isModerator` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
        }
        else if($role == 0){
          DB::update('UPDATE `user` SET `isAdmin` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isEditor` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isModerator` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
        }
        else if($role == 3){
          DB::update('UPDATE `user` SET `isAdmin` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isEditor` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
          DB::update('UPDATE `user` SET `isModerator` = ? WHERE `user`.`id` = ?;',[1, $user_id]);
        }
    }

    public function  banUser($user_id){
        DB::update('UPDATE `user` SET `ban` = ? WHERE `user`.`id` = ?;',[1, $user_id]);
    }

    public function  unbanUser($user_id){
        DB::update('UPDATE `user` SET `ban` = ? WHERE `user`.`id` = ?;',[0, $user_id]);
    }

    public function  changeImageProfile($user_id, $path){
        DB::update('UPDATE `user` SET `image_profile` = ? WHERE `user`.`id` = ?;',[$path, $user_id]);
    }



}
?>

