<div class="modal fade" id="commentmodal" tabindex="-1" role="dialog" aria-labelledby="commentmodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title text-center" >@lang('labels.insertComment')</h5>


                <form id="comment_form" action="{{route('insert_comment',['id'=>$recipe->id])}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="comment" aria-label="comment" aria-describedby="comment"></textarea>
                    </div>

                    <!-- Button -->
                    <div class="form-inline justify-content-around">
                        <div class="form-group mb-2">
                            <button  type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">@lang('labels.close')</button>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="submit" name="comment_form" class="form-control btn btn-primary" value=@lang('labels.save')>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
