@extends('layouts.main')

@section('title', 'Пост #' . $post->id)

@section('content')
    <div class="card card-profile shadow mt--300">
        <div class="px-4">

            <div class="text-center mt-5">
                <h3>{{ '@' . $post->user->name }}</h3>
                <div><i class="ni education_hat mr-2"></i></div>
            </div>

            <div class="mt-5 py-5 border-top">
                <div class="row">
                    <div class="col-lg-9 m-lg-auto">

                        <div id="posts" class="justify-content-center text-center only-edit">

                            {{--Пост--}}
                            @include('_post_item', ['post' => $post, 'userId' => $userTypeId, 'viewPage' => true])
                            {{--Пост--}}
                        </div>

                        <div id="comments">
                            @if(count($comments) > 0)
                            <button class="btn btn-primary btn-load-more-comments md-4 w-100" data-post-id="{{ $post->id }}">Загрузити ще</button>
                            @endif

                            @include('_load_more_comments', ['items' => $comments ])
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow border-0" style="margin-bottom: 20px;">

                                    <div class="card-body py-5">

                                        <p class="description mt-3">
                                                <textarea id="comment-content" cols="30" rows="2" class="form-control"
                                                          placeholder="Коментар (максимум 500 символів)" maxlength="512"></textarea>
                                        </p>

                                        <button type="button" class="btn btn-primary mt-4 btn-save-comment"
                                                data-post-id="{{ $post->id }}" data-csrf-token="{{ csrf_token() }}">Додати
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    <script>
        window.isViewPage = true;
    </script>
    @include('_modal_edit_comment')
@endsection