<?php
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

include "Connection.php";
include "Kaizala.php";

function update_agents(){
    $conn = new Connection();
    $kaiza = new Kaizala();

    $title = "Updates: Agents";

    //1. Get max id from Mawingunetworks.com
    $sql = "SELECT MAX(id) FROM agents";
    $max_id = $conn->get_max_id($sql);
    
    // var_dump($max_id);die();
    $to_date = date("Y-m-d H:i:s");
    $from_date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    $message;
    $count = 0;

    if($max_id != FALSE)
    {
        //2. Select all agents with greater ids than $max_id from Postgres
        $sql = 'SELECT * FROM "public"."agents" WHERE id > '.$max_id.' LIMIT 100';
        
        $agents_array = $conn->select_items($sql);
        if(is_array($agents_array))
        {
            $total_agents = count($agents_array);
            $count = $total_agents;
            $total_saved = 0;
            $multi_query = "";
            //3. Insert new agents
            if($total_agents > 0)
            {
                for($r = 0; $r < $total_agents; $r++)
                {
                    $row = $agents_array[$r];
                   //check is agent exists
                   $sql = "SELECT * FROM agents WHERE id = ".$row["id"];
                    if($conn->item_exists($sql) == FALSE)
                    {
                        $total_saved++;

                        $multi_query .= 'INSERT INTO agents (id, username, password, Visible, firstName, lastName, email, latitude, longitude, street, city, zip, houseNumber, cell, forcePasswordChange, CreditLimit, inserted, FreeInernetUsername, FreeInternet, uniqueId, agentTypeId, agent_password) VALUES ("'.$row['id'].'","'.$row['username'].'","'.$row['password'].'","'.$row['Visible'].'","'.$row['firstName'].'","'.$row['lastName'].'","'.$row['email'].'","'.$row['latitude'].'","'.$row['longitude'].'","'.$row['street'].'","'.$row['city'].'","'.$row['zip'].'","'.$row['houseNumber'].'","'.preg_replace('/\s/', '', $row["cell"]).'","'.$row['forcePasswordChange'].'","'.$row['CreditLimit'].'","'.$row['inserted'].'","'.$row['FreeInernetUsername'].'","'.$row['FreeInternet'].'","'.$row['uniqueId'].'","'.$row['agentTypeId'].'", "e10adc3949ba59abbe56e057f20f883e");';
                    }

                    else
                    {
                        $message =  $count . " agent(s) not saved";
                        echo"<span style='color:red;'>".$row["username"]." ".$row["id"]." already exists </span><br/>";
                    }
                }
                
                //4. Multi insert into the database
               $result =  $conn->multi_query_statement($multi_query);
               if($result == TRUE){
                $message = $total_saved . " agent(s) saved";
                echo $total_saved . " agent(s) saved<br/>";
               }
               else
               {
                    $message =  $total_saved . " agent(s) not saved";
                    echo"<span style='color:red;'>".$total_saved." agent(s) not saved </span><br/>";
               }
            }

            else
            {
                $message =  "No new agents found";
                echo"<span style='color:red;'>No new agents found </span><br/>";
            }
        }

        else
        {
            $message =  "No new agents found";
            echo"<span style='color:red;'>No new agents found </span><br/>";
        }
    }

    else
    {
        $message =  "No new agents found";
        echo"<span style='color:red;'>No new agents found </span><br/>";
    }

    //5. send Kaizala Action Card
    if($message != "No new agents found" && $count > 0)
    {
        $id = $kaiza->send_action_card($from_date, $to_date, $message, $title);

        echo "ActionId: ". $id;
    }
}

//Run this function
update_agents();

?>