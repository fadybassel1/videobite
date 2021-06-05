<?php

namespace App\Policies;

use App\User;
use App\models\video;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VideoPolicy
{
    use HandlesAuthorization;

    public function create_edit_request(User $user, Video $video)
    {
        if ($user->id === $video->user_id) {
            if ($video->requests()->where("status", "pending")->count() == 0) {
                if ($video->active_summary != null)
                    return response::allow();
                else return response::deny('no summary');
            } else
                return response::deny('pending');
        } else return Response::deny('You do not own this video.');
    }

    public function view_requests(User $user, Video $video)
    {
        return $user->id === $video->user_id ? response::allow() : response::deny('You do not own this video.');
    }

    public function view_summaries(User $user, Video $video)
    {
        return $user->id === $video->user_id ? response::allow() : response::deny('You do not own this video.');
    }
}
