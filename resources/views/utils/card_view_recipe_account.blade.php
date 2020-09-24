<!-- This is the html code for the rappresentation of the cards in the home screen.
     The cards are described by a:
     - title
     - tiny descripton
     - picture
     - last update
     - author
     Every card has also a button to delete the recipe and a button to edit that.
     -->

<!-- ID is passed with php, so every card is rappresented here -->
<?php
use App\DataLayer;
$dl = new \App\DataLayer();
$firstCover = $dl->getFirstCoverImage($recipe->id);


?>





<div class="col mb-3">

    <div  class="container-card">
        <div class="column" >
            <!-- Post-->
            <div class="post-module" >
                <!-- Thumbnail-->
                <div class="thumbnail">

                    <img src="{{asset($firstCover)}}"  alt="...">
                </div>
                <!-- Post Content-->
                <div class="post-content">

                    <h1 class="title link pb-0" <?php if($recipe->approved == 2) { echo 'style="color: #dc3545"';} ?> >{{$recipe->title}}</h1>
                    <div class="text-center pt-0">
                        <img src="{{asset('image/doodle/doodle-home.jpg')}}" width="250" height="40" alt="">
                    </div>

                    <div class="d-flex justify-content-around">
                        @if($recipe->approved!=0)
                        <a id="delete{{$recipe->id}}" class="butt btn-my btn-outline-danger-my" href="{{route('delete',['id'=>$recipe->id])}}">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center" style="color: #dc3545">
                                    @lang('labels.delteButtonMyRec')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="delete-lottie{{$recipe->id}}"
                                                   src="{{asset('/icons/trash-bin-red.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 35px; height: 35px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </a>
                        <script>
                            var delanimation{{$recipe->id}} = document.getElementById("delete-lottie{{$recipe->id}}");
                            $("#delete{{$recipe->id}}").mouseover(function(){
                                delanimation{{$recipe->id}}.play();
                            });
                            $("#delete{{$recipe->id}}").mouseleave(function(){
                                delanimation{{$recipe->id}}.stop();
                            });

                        </script>


                        <a id="edit{{$recipe->id}}" class="butt btn-my btn-outline-secondary-my" href="{{route('edit',['id'=>$recipe->id])}}">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                    @lang('labels.editButtonMyRec')
                                </div>


                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="edit-lottie{{$recipe->id}}"
                                                   src="{{asset('/icons/edit.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 35px; height: 35px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </a>
                        <script>
                            var editanimation{{$recipe->id}} = document.getElementById("edit-lottie{{$recipe->id}}");

                            $("#edit{{$recipe->id}}").mouseover(function(){
                                editanimation{{$recipe->id}}.play();
                            });
                            $("#edit{{$recipe->id}}").mouseleave(function(){
                                editanimation{{$recipe->id}}.stop();
                            });

                        </script>
                        @endif

                        <a id="view{{$recipe->id}}" class="butt btn-my btn-outline-secondary-my" href="{{route('recipe_view',['id'=>$recipe->id])}}">

                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center">
                                    @lang('labels.viewButtonMyRec')
                                </div>
                                <div class="row justify-content-center align-self-center">
                                    <lottie-player id="view-lottie{{$recipe->id}}"
                                                   src="{{asset('/icons/eye.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 35px; height: 35px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </a>
                        <script>
                            var viewanimation{{$recipe->id}} = document.getElementById("view-lottie{{$recipe->id}}");
                            $("#view{{$recipe->id}}").mouseover(function(){
                                viewanimation{{$recipe->id}}.play();
                            });
                            $("#view{{$recipe->id}}").mouseleave(function(){
                                viewanimation{{$recipe->id}}.stop();
                            });

                        </script>


                    </div>
                    <!--<div class="post-meta"><span class="timestamp"><i class="fa fa-clock-">o</i> 6 mins ago</span><span
                            class="comments"><i class="fa fa-comments"></i><a href="#"> 39 comments</a></span></div>-->
                </div>
            </div>
        </div>
    </div>


</div>

