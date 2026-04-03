<?php

namespace App\Policies;

use App\Models\Download;
use App\Models\User;

class DownloadPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function download(User $user, Download $download): bool
    {
        return $user->id === $download->user_id;
    }
}
