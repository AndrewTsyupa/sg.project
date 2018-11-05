$(function () {

    function photoList(imageUrl, filename) {
        var imgBlock = '<div style="margin-bottom: 10px">' +
            '<img src="' + imageUrl + '" style="max-height: 100px">' +
            '<button class="btn btn-danger btn-remove-img" data-filename="' + filename + '"><i class="fa fa-remove"></i></button></div>';

        $('#photos').append(imgBlock);
    }

    $('#fileupload').fileupload({
        url: "/upload-post-images",
        formData: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        add: function (e, data) {
            console.log(data);
            data.submit();
        },
        done: function (e, data) {
            if (data.result.status === 'success') {
                photoList(data.result.url, data.result.filename);
            }
        }
    });

    $(document).on('click', '.btn-remove-img', function () {
        var imgBlock = $(this).parent();
        var postId = $(".modal #post-id").val();
        var filename = $(this).data('filename');


        $.ajax({
            url: '/remove-post-image',
            cache: false,
            dataType: 'json',
            data: {
                post_id: postId,
                filename: filename,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                if (data.status === 'success') {
                    $(imgBlock).remove();

                    if (postId) {
                        var totalImgs = $('.post-' + postId).find('.carousel-item');
                        if (totalImgs.length === 0) {
                            $('.post-' + postId).find('.carousel').remove();
                        }

                        // виделення із каруселі
                        var img = $('.post-' + postId).find('div[data-filename="' + filename + '"]');
                        var imgIsActive = $(img).hasClass('active');
                        if (img) {
                            $(img).remove();
                        }

                        // виделення індикатора із каруселі
                        $('.post-' + postId).find('li[data-filename="' + filename + '"]').remove();

                        if (imgIsActive) {
                            $('.post-' + postId).find('div.carousel-item:last').addClass('active');
                        }

                    }

                } else {
                    alert(data.msg);
                }
            }
        });

    });


    $('.btn-submit-post').click(function (e) {
        e.preventDefault();

        var postId = $(".modal #post-id").val();
        var title = $(".modal #post-title").val();
        var content = $(".modal #post-content").val();

        if (content == '') {
            alert('Пост не може бути порожнім');
            return;
        }

        $.ajax({
            type: "post",
            url: "/save-post",
            data: {
                post_id: postId,
                title: title,
                content: content,
                is_view_page: window.isViewPage,
                _token: $(this).data('csrf-token')
            },
            cache: false,
            success: function (post_html) {
                var listPosts = $('#posts');

                if (post_html.length > 0 && listPosts.length > 0) {

                    if (postId == '' && !$(listPosts).hasClass('only-edit')) {

                        var firstPost = $(listPosts).find('div:first');

                        if (firstPost.length > 0) {
                            $(post_html).insertBefore(firstPost);
                        } else {
                            $(listPosts).append(post_html);
                        }

                    } else {
                        var oldPost = $(listPosts).find('.post-' + postId);

                        if (oldPost.length > 0) {
                            $(post_html).insertAfter(oldPost);
                            oldPost.remove();
                        }

                    }

                    // clear post-id
                    $(".modal #post-id").val('');
                    $(".modal #post-title").val('');
                    $(".modal #post-content").val('');
                }

                $('#photos').html('');
                $('#modal-post').modal('hide');
            }

        });

    });

    $(document).on('click', '.btn-add-post', function (e) {
        $(".modal #post-id").val('');
        $(".modal #post-title").val('');
        $(".modal #post-content").val('');
    });

    $(document).on('click', '.btn-post-edit', function (e) {
        e.preventDefault();

        var postId = $(this).data('post-id');
        var postTitle = $(this).parent().find('.desc-title').text();
        var postContent = $(this).parent().find('.desc-content').text();

        $(".modal #post-id").val(postId);
        $(".modal #post-title").val(postTitle);
        $(".modal #post-content").val(postContent);
        $('#photos').html('');

        $.each($('.post-' + postId).find('.carousel-item img'), function (idx, el) {
            photoList($(el).attr('src'), $(el).data('filename'));
        });

        $('#modal-post').modal('show');
    });

    $(document).on('click', '.btn-post-remove', function (e) {
        e.preventDefault();

        var postId = $(this).data('post-id');

        $.ajax({
            url: "/remove-post",
            data: {
                post_id: postId
            },
            cache: false,
            dataType: 'json',
            success: function (data) {

                if (data.status == 'success') {
                    var listPosts = $('#posts');
                    var post = $(listPosts).find('.post-' + postId);

                    if (post.length > 0) {
                        var postTitle = $(post).find('.desc-title').text();

                        $(post).remove();
                        alert('Виделено пост: ' + postTitle);
                    }
                } else {
                    alert(data.msg);
                }


            }
        });

    });


    function saveComment(commentId, postId, content, token) {
        if (content == '') {
            alert('Коментар не може бути порожнім');
            return;
        }

        $.ajax({
            type: "post",
            url: "/save-comment",
            data: {
                comment_id: commentId,
                post_id: postId,
                content: content,
                _token: token
            },
            success: function (comment_html) {
                var listComments = $('#comments');

                if (comment_html.length > 0 && listComments.length > 0) {

                    if (commentId == '') {

                        $(listComments).append(comment_html);

                    } else {
                        var oldComment = $(listComments).find('.comment-' + commentId);

                        if (oldComment.length > 0) {
                            $(comment_html).insertAfter(oldComment);
                            oldComment.remove();
                        }

                    }

                }


                $('#comment-content').val('');
                $('#modal-comment').modal('hide');

            }
        });
    }

    $('.btn-save-comment').click(function (e) {
        e.preventDefault();

        var postId = $(this).data('post-id');
        var content = $('#comment-content').val();
        var token = $(this).data('csrf-token');

        saveComment('', postId, content, token);
    });

    $('.btn-modal-save-comment').click(function (e) {
        e.preventDefault();

        var commentId = $(".modal #comment-id").val();
        var content = $('.modal #comment-content').val();
        var token = $(this).data('csrf-token');

        saveComment(commentId, '', content, token);
    });

    $(document).on('click', '.btn-comment-edit', function (e) {
        e.preventDefault();

        var commentId = $(this).data('comment-id');
        var commentContent = $(this).parent().find('.description').text();

        $(".modal #comment-id").val(commentId);
        $(".modal #comment-content").val(commentContent);

        $('#modal-comment').modal('show');
    });

    $(document).on('click', '.btn-comment-remove', function (e) {
        e.preventDefault();

        var commentId = $(this).data('comment-id');

        $.ajax({
            url: "/remove-comment",
            data: {
                comment_id: commentId
            },
            cache: false,
            dataType: 'json',
            success: function (data) {

                if (data.status == 'success') {
                    var listComments = $('#comments');
                    var comment = $(listComments).find('.comment-' + commentId);

                    if (comment.length > 0) {
                        var date = $(comment).find('small:first').text();

                        $(comment).remove();
                        alert('Коментар із датою ' + date + ' - виделено');
                    }
                } else {
                    alert(data.msg);
                }


            }
        });

    });

    $('.btn-load-more-comments').on('click', function () {

        var btn = $(this);

        var postId = $(this).data('post-id');

        var firstComment = $('#comments > div:first > div:first');

        var lastId = '';

        if (firstComment) {
            lastId = $(firstComment).data('id');
        }


        $.ajax({
            url: "/load-more-comments",
            data: {
                post_id: postId,
                last_id: lastId
            },
            cache: false,
            dataType: 'html',
            success: function (html) {

                if (html === '') {
                    $(btn).remove();
                } else {
                    $(html).insertBefore($('#comments > div:first'));
                }

            }
        });

    });

    var options = {
        loadingHtml: '<img src="/img/loading.gif" height="25"/> Загрузка...',
        padding: 500,
        nextSelector: 'a.jscroll-next:last'
    };

    if ($('#posts').length > 0) {
        $('#posts').jscroll(options);
    }

    $(document).on('click', '.btn-like', function () {
        var commentId = $(this).data('comment-id');

        var btn = $(this);
        var status = $(btn).hasClass('btn-neutral') ? 1 : 0;

        $.ajax({
            type: 'get',
            url: "/like-comment",
            data: {
                comment_id: commentId,
                status: status
            },
            cache: false,
            dataType: 'json',
            success: function (data) {

                if (data.status === 'success') {

                    if (status) {
                        $(btn).removeClass('btn-neutral').addClass('btn-success');
                    } else {
                        $(btn).removeClass('btn-success').addClass('btn-neutral');
                    }

                    var total = parseInt(data.total) > 0 ? ' ' + data.total : '';
                    $(btn).find('.like-count').text(total);

                } else if (data.status == 'error') {
                    alert(data.msg);
                }


            }
        });

    });

});