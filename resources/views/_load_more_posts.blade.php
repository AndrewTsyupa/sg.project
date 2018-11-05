<?php

use Illuminate\Support\Facades\Auth;

$user = Auth::user();

$userId = $user->canEditPostOrComments();

$last = $items->last(function ($item, $key) {
    return $item;
});

if ($last) {
    $url = route('load-more-posts', ['last_id' => $last->id]);
} else {
    $url = false;
}
?>

@foreach ($items as $item)
    @include('_post_item', ['post' => $item, 'userId' => $userId])
@endforeach

@if ($url)
<a href="{{ $url }}" class="jscroll-next hide"></a>
@endif