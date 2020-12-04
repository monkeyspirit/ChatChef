<!-- This is the html code for the rappresentation of the "new card" in the my recipes screen.
     This is a card to create a "new card"
     -->

<div class="col mb-3 pb-3">
   {{-- style="background-image: url('public/image/cooking_togheter.jpg')"--}}
    <div class="container-card" onclick="window.location.href='{{route('insert')}}'">
        <div class="column">
            <div class="post-module" style="height: 300px">

                <img src="{{asset('image/cooking_togheter.jpg')}}" class="card-img-create" style="height: 70%">
                <div class="card-body">
                    <h3 class="text-center pt-0 pb-0" style="font-family: 'Fredericka the Great', cursive">@lang('labels.addNewButton')</h3>
                </div>
            </div>
        </div>
    </div>
</div>
