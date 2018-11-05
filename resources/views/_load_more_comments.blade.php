<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>

@foreach ($items as $item)
    @include('_comment_item', ['comment' => $item, 'curUser' => $user])
@endforeach
