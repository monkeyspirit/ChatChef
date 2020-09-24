<!-- This is the html code for the rappresentation of the "new card" in the my recipes screen.
     This is a card to create a "new card"
     -->

<div class="col mb-3">

    <div class="container-card">
        <div class="column">
            <div class="post-module">
                <img src="{{asset('image/doodle/cookingWoman.jpg')}}" class="card-img-create" alt="...">
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-around pt-1">

                        <a id="add" class="butt-add  btn btn-outline-primary-my" href="{{route("insert")}}">
                            <div class="d-flex flex-column align-items-start flex-column bd-highlight mb-3 ">
                                <div class="row justify-content-center align-self-center" style="color: #007bff">
                                   @lang('labels.addNewButton')
                                </div>
                                <div class="row justify-content-center align-self-center">

                                    <lottie-player id="add-lottie"
                                                   src="{{asset('/icons/add-blue.json')}}"
                                                   background="transparent"
                                                   speed="1"
                                                   style="width: 30px; height: 30px;"
                                                   hover
                                    >
                                    </lottie-player>
                                </div>
                            </div>

                        </a>
                        <script>
                            var addanim = document.getElementById("add-lottie");
                            $("#add").mouseover(function () {
                                addanim.play();
                            });

                            $("#add").mouseleave(function () {
                                addanim.stop();
                            });

                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
