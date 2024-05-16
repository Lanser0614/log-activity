<?php

namespace App\Services\ActivityLog\Interface;

use App\Services\ActivityLog\Model\LogActivity;

interface ActivityLogInterface
{
    public function getActivityLogOptions(): LogActivity;
}
