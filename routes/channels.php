<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chats.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
