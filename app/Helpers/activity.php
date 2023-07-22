<?php

use App\Models\ActivityLog;


function LogActivity($user_id,$activity,$description){
    ActivityLog::create([
        'user_id'=>$user_id,
        'activity'=>$activity,
        'description'=>$description
    ]);
}
