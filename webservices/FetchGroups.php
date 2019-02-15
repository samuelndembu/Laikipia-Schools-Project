<?php
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

include "Connection.php";
include "Kaizala.php";

$kaiza = new Kaizala();
$conn = new Connection();

$groups = json_decode($kaiza->fetch_groups());

$multi_query = "";

if(is_array($groups->groups))
{
    $count = count($groups->groups);
    $my_groups = [];

    foreach($groups->groups as $group)
    {
        
        if($group->isMappedToTenant == true)
        {
            $result = $kaiza->get_single_group_details($group->groupId);

            if($result != FALSE)
            {
                if($result->callerRole == 'Admin')
                {
                    // $data = array(
                    //     'group_name' => $group->groupName, 
                    //     'group_unique_id' => $group->groupId,
                    //     'group_image_url' => $group->groupImageUrl,
                    //     'group_type' => $group->groupType,
                    //     'has_sub_groups' => $group->hasSubGroups,
                    //     'has_parent_groups' => $group->hasParentGroups
                    // );

                    $multi_query .= 'INSERT INTO groups (group_name, group_unique_id, group_image_url, group_type, has_sub_groups, has_parent_groups) VALUES("'.$group->groupName.'","'. $group->groupId.'","'.$group->groupImageUrl.'","'.$group->groupType.'","'.$group->hasSubGroups.'","'.$group->hasParentGroups.'") ON DUPLICATE KEY UPDATE group_name="'.$group->groupName.'";';
                    array_push($my_groups, $result);
                }
            }
        }
       
    }
   
    // var_dump($multi_query);
    // die();
    $result =  $conn->multi_query_statement($multi_query);

    if($result == TRUE)
    {
        echo $count . " groups saved!!";
        echo json_encode($my_groups);
    }
    else
    {
        echo $count . " groups NOT saved!!";
        echo json_encode($my_groups);
    }
    
}


