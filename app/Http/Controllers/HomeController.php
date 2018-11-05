<?php

namespace App\Http\Controllers;

use App\Comment;
use App\CommentLike;
use App\Post;
use App\PostImage;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function usersForAdmin() {
        $user = Auth::user()->isAdmin();

        if (!$user) {
            return redirect('/');
        }

        $users = User::query()->get();

        return view('users', ['users' => $users]);
    }

    public function editUser(Request $request, $id) {
        $curUser = Auth::user();

        if (!$curUser->isAdmin()) {
            return redirect('/');
        }

        $user = User::find($id);

        if ($curUser->id == $user->id) {
            return redirect('/');
        }

        return view('edit_user', ['user' => $user]);
    }

    public function editUserSave(Request $request, $id) {
        $curUser = Auth::user();

        if (!$curUser->isAdmin()) {
            return redirect('/');
        }

        $user = User::find($id);

        if ($curUser->id == $user->id) {
            return redirect('/');
        }

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user->id),
                ],
            ]);

            $user->name = $request->post('name');
            $user->email = $request->post('email');

            $role = Role::where('id', $request->post('role_id'))->first();
            if ($role) {
                $user->setRole($role);
            }


            if ($user->save()) {
                return redirect('/admin/users');
            }

        }


        return view('edit_user', ['user' => $user]);
    }


    public function testData() {
        set_time_limit(0);
        if (Auth::user()->isUser()) {
            return redirect('/');
        }

        foreach (range(1, 50) as $i) {
            $post = new Post();
            $post->user_id = rand(1, 3);
            $post->title = "Заголовок #$i";
            $post->content = "Тестовий пост $i";
            $s = $post->save();

            if ($s) {
                foreach (range(1, 40) as $j) {
                    $comment = new Comment();
                    $comment->user_id = rand(1, 5);
                    $comment->post_id = $post->id;
                    $comment->content = "Коментар #$j для поста " . $post->content;
                    $statusComment = $comment->save();

                    if ($statusComment) {
                        $randUserIdForLike = $comment->user_id;
                        while ($randUserIdForLike == $comment->user_id) {
                            $randUserIdForLike = rand(1, 5);
                        }

                        $comment->like($randUserIdForLike);
                    }

                }

                PostImage::setImagesForPost('for_test', $post->id, true);
            }
        }

        return redirect('/');

    }

    public function index(Request $request) {

        $posts = Post::query()
            ->orderByDesc('id')
            ->offset(0)
            ->limit(10)
            ->get();

        return view('index', ['posts' => $posts]);
    }

    public function loadMorePosts(Request $request) {
        $lastId = $request->get('last_id', 0);

        $posts = Post::query()
            ->where('id', '<', $lastId)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('_load_more_posts', ['items' => $posts]);
    }

    public function loadMoreComments(Request $request) {
        $postId = $request->get('post_id', false);

        if (!$postId) {
            return '';
        }

        $lastId = $request->get('last_id', 0);

        $comments = Comment::query()
            ->where('id', '<', $lastId)
            ->where('post_id', '=', $postId)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $comments = $comments->make(array_reverse($comments->getDictionary()));

        return view('_load_more_comments', ['items' => $comments]);
    }

    public function postView(Request $request, $id) {
        $user = Auth::user();
        $post = Post::find($id);

        if ($post) {

            $comments = Comment::query()
                ->where('post_id', '=', $post->id)
                ->orderByDesc('id')
                ->limit(10)
                ->get();

            $comments = $comments->make(array_reverse($comments->getDictionary()));

            $userTypeId = $user->canEditPostOrComments();

            return view('post_view', ['post' => $post, 'comments' => $comments, 'userTypeId' => $userTypeId]);
        }

        return redirect('/');
    }

    public function uploadPostImages(Request $request) {
        $images = $request->file('images');
        $uploadDir = PostImage::UPLOAD_DIR . Auth::user()->id;

        if (count($images) == 0) {
            return json_encode([
                'status' => 'error',
            ]);
        }

        $img = end($images);

        if (substr($img->getMimeType(), 0, 5) !== 'image') {
            return json_encode([
                'status' => 'error',
                'msg' => 'Некоректний тип зображення'
            ]);
        }

        foreach ($images as $image) {
            $imagesDir = public_path($uploadDir);
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($imagesDir, $filename);

            $url = $uploadDir . '/' . $filename;
        }

        return json_encode([
            'status' => 'success',
            'url' => $url,
            'filename' => $filename
        ]);
    }

    public function removePostImage(Request $request) {
        $user = Auth::user();

        if ($user->isUser()) {
            return json_encode([
                'status' => 'error',
                'msg' => 'Доступ заборонено'
            ]);
        }

        $postId = $request->get('post_id', false);
        $filename = $request->get('filename', false);

        if (!$filename) {
            return json_encode([
                'status' => 'error',
                'msg' => 'Імя фото обовязкове'
            ]);
        }

        $filename = str_replace(['\\', '/'], '', $filename);

        $status = false;

        if ($postId) {

            if ($user->isAdmin()) {
                $post = Post::query()->where(['id' => $postId])->first();
            } else {
                $post = Post::query()->where(['id' => $postId, 'user_id' => $user->id])->first();
            }


            if ($post) {

                $image = PostImage::query()->where(['post_id' => $post->id, 'filename' => $filename])->first();

                if ($image) {
                    $status = $image->delete();
                }

            }


        } else {
            $uploadDir = PostImage::UPLOAD_DIR . $user->id;

            $imagesDir = public_path($uploadDir);
            $path = $imagesDir . '/' . $filename;


            if (file_exists($path)) {
                $status = unlink($path);
            }
        }


        return json_encode([
            'status' => $status ? 'success' : 'error',
            'msg' => !$status ? 'Помилка при видаленні' : ''
        ]);
    }


    public function savePost(Request $request) {
        $user = Auth::user();
        $canEdit = $user && ($user->isAdmin() || $user->isEditor());

        if (!$canEdit) {
            return '';
        }

        $postId = $request->post('post_id', false);

        if ($postId) {

            if (Auth::user()->isAdmin()) {
                $post = Post::find($postId);
            } else {
                $post = Post::where(['id' => $postId, 'user_id' => Auth::user()->id])->first();
            }

            if (!$post) {
                return 'Не є власником поста';
            }

        } else {
            $post = new Post();
        }

        if (!$post->exists) {
            $post->user_id = Auth::user()->id;
        }

        $post->title = substr(strip_tags($request->post('title')), 0, 500);
        $post->content = substr(strip_tags($request->post('content')), 0, 1021);

        if (empty($post->content)) {
            return '';
        }

        if ($post->save()) {

            PostImage::setImagesForPost($user->id, $post->id);

            $userId = $user->canEditPostOrComments();

            $isViewPage = $request->post('is_view_page', false);

            $params = ['post' => $post, 'userId' => $userId];

            if ($isViewPage) {
                $params['viewPage'] = true;
            }

            $view = view('_post_item', $params);
        } else {
            $view = '';
        }

        return $view;
    }

    public function deleteAndRedirectPost(Request $request, $id) {
        if (Auth::user()->isAdmin()) {
            $post = Post::find($id);
        } else {
            $post = Post::where(['id' => $id, 'user_id' => Auth::user()->id])->first();
        }

        if ($post) {
            $post->delete();
        }

        return redirect('/');
    }

    public function removePost(Request $request, Response $response) {
        $canEdit = Auth::user() && (Auth::user()->isAdmin() || Auth::user()->isEditor());

        if (!$canEdit) {
            return json_encode([
                'status' => 'error',
                'msg' => 'немає доступу до видалення або ресурс видалено'
            ]);
        }

        $status = false;
        $postId = $request->post('post_id', false);

        if ($postId) {
            if (Auth::user()->isAdmin()) {
                $post = Post::find($postId);
            } else {
                $post = Post::where(['id' => $postId, 'user_id' => Auth::user()->id])->first();
            }

            if ($post) {
                $status = $post->delete();
            }

        }

        return json_encode([
            'status' => $status ? 'success' : 'error',
            'msg' => ($status) ? '' : 'немає доступу до видалення або ресурс видалено'
        ]);
    }

    public function saveComment(Request $request) {
        $user = Auth::user();
        $commentId = $request->post('comment_id');

        if ($commentId) {
            if (Auth::user()->isAdmin()) {
                $comment = Comment::find($commentId);
            } else {
                $comment = Comment::where(['id' => $commentId, 'user_id' => Auth::user()->id])->first();
            }

            $postId = $comment->post_id;

            if (!$comment) {
                return 'Не є власником коментаря';
            }

        } else {
            $comment = new Comment();
            $postId = $request->post('post_id', false);
        }

        if (!$postId) {
            return '';
        }

        if (!$comment->exists) {
            $comment->user_id = Auth::user()->id;
        }

        if ($postId) {
            $comment->post_id = $postId;
        }

        $content = substr(strip_tags($request->post('content')), 0, 511);

        if (!empty($comment)) {
            $comment->content = $content;
        } else {
            return '';
        }

        if ($comment->save()) {
            return view('_comment_item', ['comment' => $comment, 'curUser' => $user]);
        }

        return '';
    }

    public function removeComment(Request $request) {
        $status = false;
        $commentId = $request->post('comment_id', false);

        if ($commentId) {

            if (Auth::user()->isAdmin()) {
                $comment = Comment::find($commentId);
            } else {
                $comment = Comment::where(['id' => $commentId, 'user_id' => Auth::user()->id])->first();
            }

            if ($comment) {
                $status = $comment->delete();
            }

        }

        return json_encode([
            'status' => $status ? 'success' : 'error',
            'msg' => ($status) ? '' : 'немає доступу до видалення або ресурс видалено'
        ]);
    }

    public function likeComment(Request $request) {
        $user = Auth::user();

        $commentId = $request->post('comment_id', false);
        $status = $request->post('status', 0);

        if ($commentId) {

            $comment = Comment::find($commentId);

            if ($comment) {
                if (Auth::user()->id != $comment->user_id) {

                    if ($status) {
                        $comment->like($user->id);
                    } else {
                        $comment->unlike($user->id);
                    }

                    return json_encode([
                        'status' => 'success',
                        'total' => $comment->likes,
                        'msg' => ''
                    ]);

                } else {
                    return json_encode([
                        'status' => 'error',
                        'msg' => 'не можна ставити лайк на свій комент'
                    ]);
                }
            } else {
                return json_encode([
                    'status' => 'error',
                    'msg' => 'комент не знайдено'
                ]);
            }

        } else {
            return json_encode([
                'status' => 'error',
                'msg' => 'не коректні дані'
            ]);
        }

    }


}
