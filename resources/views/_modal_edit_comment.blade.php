<div class="modal fade" id="modal-comment" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="comment-id" value="">
                <textarea id="comment-content" cols="30" rows="5" class="form-control" placeholder="Коментар (максимум 500 символів)" maxlength="1024"></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ml-auto btn-modal-save-comment" data-csrf-token="{{ csrf_token() }}">Save</button>
            </div>

        </div>
    </div>
</div>