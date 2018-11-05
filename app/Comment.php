<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = 'comment';

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function format($date) {
        return \DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i');
    }

    public function getPostDate() {
        if ($this->updated_at) {
            return $this->format($this->updated_at);
        } else {
            return $this->format($this->created_at);
        }
    }

    public function updateLikesCount() {
        $total = CommentLike::query()->where(['comment_id' => $this->id])->count();

        $this->likes = $total;
        return $this->save();
    }

    public function like($userId) {
        $row = CommentLike::query()->where(['comment_id' => $this->id, 'user_id' => $userId])->first();

        if (!$row) {
            $like = new CommentLike();
            $like->user_id = $userId;
            $like->comment_id = $this->id;
            $status = $like->save();

            return $status ? $this->updateLikesCount() : false;
        }

        return true;
    }

    public function unlike($userId) {
        $row = CommentLike::query()->where(['comment_id' => $this->id, 'user_id' => $userId])->first();;

        if ($row) {
            $status = $row->delete();
            return $status ? $this->updateLikesCount() : false;
        }

        return true;
    }


    public function isLiked($userId) {
        return CommentLike::query()->where(['comment_id' => $this->id, 'user_id' => $userId])->count();
    }

}
