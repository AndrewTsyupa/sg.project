<div class="row comment-{{ $comment->id }}">
    <div class="col-lg-12" data-id="{{ $comment->id }}">
        <div class="card shadow border-0" style="margin-bottom: 20px;">

            <div class="card-body py-5">
                <h6 class="text-primary text-uppercase">{{ '@' . $comment->user->name }} {{$comment->created}}</h6>
                <small>{{ $comment->getPostDate() }}</small>
                <p class="description mt-3">{{ $comment->content}}</p>

                <button class="btn btn-1 <?= ($comment->isLiked($curUser->id))?'btn-success':'btn-neutral' ?> mt-4 btn-like" data-comment-id="{{ $comment->id }}"
                        type="button"><i class="fa fa-heart-o" style="margin: 0"></i><span class="like-count"> <?= ($comment->likes)?$comment->likes:'' ?></span></button>

                <?php if ($curUser->isAdmin() || $comment->user_id == $curUser->id) { ?>

                <a href='#' data-post-id="{{ $comment->post_id }}" data-comment-id="{{$comment->id}}"
                   class="btn btn-primary mt-4 btn-comment-edit"><i class="fa fa-edit"></i></a>
                <a href='#' data-post-id="{{ $comment->post_id }}" data-comment-id="{{$comment->id}}"
                   class="btn btn-danger mt-4 btn-comment-remove"><i class="fa fa-remove"></i></a>

                <?php } ?>

            </div>

        </div>
    </div>
</div>