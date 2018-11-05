<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model {

    const UPLOAD_DIR = '/uploads/';
    const IMAGES_DIR = '/uploads/post_images/';

    public $timestamps = false;

    protected $table = 'post_image';

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function getUrl() {
        return self::IMAGES_DIR . $this->post_id . '/' . $this->filename;
    }

    public function delete() {
        $path = public_path(self::IMAGES_DIR . $this->post_id . '/' . $this->filename);

        if (file_exists($path)) {
            unlink($path);
        }

        return parent::delete();
    }

    public static function setImagesForPost($userId, $postId, $isCopy = false) {
        $uploadDir = PostImage::UPLOAD_DIR . $userId;
        $imagesDir = public_path($uploadDir);

        if (file_exists($imagesDir)) {
            $listImages = scandir($imagesDir);
            unset($listImages[0]);
            unset($listImages[1]);
        } else {
            $listImages = [];
        }

        if (count($listImages) > 0) {
            $postImageDir = public_path(PostImage::UPLOAD_DIR . 'post_images/' . $postId);

            if (!file_exists($postImageDir)) {
                mkdir($postImageDir, 0777, true);
            }

            foreach ($listImages as $imageFile) {
                $image = new PostImage();
                $image->post_id = $postId;
                $image->filename = $imageFile;

                if ($image->save()) {

                    if ($isCopy) {
                        copy($imagesDir . '/' . $imageFile, $postImageDir . '/' . $imageFile);
                    } else {
                        rename($imagesDir . '/' . $imageFile, $postImageDir . '/' . $imageFile);
                    }


                }

            }
        }

    }

}
