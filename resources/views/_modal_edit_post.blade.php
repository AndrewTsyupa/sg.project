<div class="modal fade" id="modal-post" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="post-id" value="">
                <input type="text" id="post-title" class="form-control" placeholder="Заголовок поста">

                <textarea id="post-content" cols="30" rows="5" class="form-control mt-4" placeholder="Текст поста (максимум 1024 символи)" maxlength="1024"></textarea>

                <label for="fileupload" class="btn btn-success fileinput-button mt-4">
                    <i class="fa fa-photo"></i>
                    <span>Виберіть декілька фото</span>
                    <input id="fileupload" type="file" name="images[]" style="display: none" multiple="multiple">
                </label>
                
                <div id="photos"></div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary ml-auto btn-submit-post" data-csrf-token="{{ csrf_token() }}">Відправити</button>
            </div>

        </div>
    </div>
</div>