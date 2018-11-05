<div class="row post-{{ $post->id }}">
    <div class="col-lg-12" data-id="{{ $post->id }}">
        <div class="card shadow border-0" style="margin-bottom: 20px;">

            <div class="card-body py-5">
                <h6 class="text-primary text-uppercase">{{ '@' . $post->user->name }}</h6>
                <small>{{ $post->getPostDate() }}</small>
                <p class="description mt-3 desc-title">{{ $post->title}}</p>
                <p class="description mt-3 desc-content">{{ $post->content}}</p>

                @if ($post->images)

                    <div id="carouselExampleIndicators-<?= $post->id ?>" class="carousel slide mt-4" data-ride="carousel">
                        <ol class="carousel-indicators">

                            <?php foreach($post->images as $idx => $image) { ?>
                            <li data-target="#carouselExampleIndicators-<?= $post->id ?>" data-slide-to="<?= $idx ?>"
                                data-filename="<?= $image->filename ?>"
                                class="<?= ($idx == 0) ? 'active' : '' ?>"></li>
                            <?php } ?>

                        </ol>

                        <div class="carousel-inner" style="background: #333333; text-align: center;">
                            <?php foreach($post->images as $idx => $image) { ?>
                            <div class="carousel-item <?= ($idx == 0) ? 'active' : '' ?>" data-filename="<?= $image->filename ?>">
                                <img src="{{ $image->getUrl() }}" data-filename="<?= $image->filename ?>" style="max-height: 300px">
                            </div>
                            <?php } ?>
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators-<?= $post->id ?>" role="button"
                           data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators-<?= $post->id ?>" role="button"
                           data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                @endif

                @if (!isset($viewPage))
                <a href='{{url('/post/' . $post->id )}}' class="btn btn-primary mt-4">Read</a>
                @endif

                <?php if ($userId == 0 || $post->user_id == $userId) { ?>
                <a href='#' data-post-id="{{$post->id}}" class="btn btn-primary mt-4 btn-post-edit">
                    <i class="fa fa-edit"></i></a>

                @if (isset($viewPage))
                    <a href='{{ url('/delete-post', ['id' => $post->id ]) }}' class="btn btn-danger mt-4">
                        <i class="fa fa-remove"></i></a>
                @else
                    <a href='#' data-post-id="{{$post->id}}" class="btn btn-danger mt-4 btn-post-remove"><i
                                class="fa fa-remove"></i></a>
                @endif
                <?php } ?>

            </div>

        </div>
    </div>
</div>