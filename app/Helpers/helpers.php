<?php

use App\Models\Activity;


function saveLogs($user_id,$description,$properties){
    Activity::create([
        'user_id'=>$user_id,
        'description'=>$description,
        'properties'=>$properties
    ]);
}
