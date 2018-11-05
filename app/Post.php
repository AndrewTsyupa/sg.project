<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    protected $table = 'post';

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function images() {
        return $this->hasMany('App\PostImage', 'post_id');
    }

    public function delete() {

        foreach ($this->images as $image){
            $image->delete();
        }

        return parent::delete();
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

}
