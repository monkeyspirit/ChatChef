<!-- This is the html code for the rappresentation of the "new card" in the my recipes screen.
     This is a card to create a "new card"
     -->

<div class="col mb-3 pb-3">
   {{-- style="background-image: url('public/image/cooking_togheter.jpg')"--}}
    <div class="container-card" onclick="window.location.href='{{route('insert')}}'">
        <div class="column">
            <div class="post-module" style="height: 420px">

                <img src="{{asset('image/cooking_togheter.jpg')}}" class="card-img-create" style="height: 70%">
                <div class="card-body">
                    <h2 class="text-center pt-0 pb-0"  style="font-size: 30px; font-family: 'Amatic SC', cursive"><i class="las la-pen-alt"></i> @lang('labels.addNewButton') <i class="las la-utensils"></i></h2>
                    <div class="text-center">
                        <button class="btn btn-outline-secondary" type="button" onclick="window.location.href='{{route('insert')}}'">
                            <i class="las la-plus"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
