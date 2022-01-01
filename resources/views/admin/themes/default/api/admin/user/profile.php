<?php

$user = getUser();

$user = get_post('user', $user->id);

unset($user->password);
unset($user->remember_token);

return [
    'user'=>$user
];