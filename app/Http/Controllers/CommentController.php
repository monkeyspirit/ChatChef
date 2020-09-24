<?php

namespace App\Http\Controllers;

use App\DataLayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function insertComment($id)
    {
        session_start();
        $dl = new DataLayer();

        if (isset($_POST['comment_form'])) {
            $rec = $dl->getRecipeByID($id);

            $comment_text = $_POST['comment'];
            $date = date("Y/m/d");

            $user_id = $dl->getUserIDbyUsername($_SESSION['loggedName']);
            $comment = array('user_id' => $user_id, 'recipe_id' => $id, 'date' => $date, 'text' => $comment_text);
            $dl->insertComment($comment);

        }

        return Redirect::to(route('recipe_view',['id'=>$id]));

    }

}
