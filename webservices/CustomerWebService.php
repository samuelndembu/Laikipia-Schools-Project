<?php
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

include "Connection.php";
include "Kaizala.php";

//Run this function
update_customers();

function update_customers(){
    $conn = new Connection();
    $kaiza = new Kaizala();

    $title = "Updates: Customers";

    //1. Get max id from Nanyukiappfactory
    $sql = "SELECT MAX(id) FROM customers";
    $max_id = $conn->get_max_id($sql);
    $to_date = date("Y-m-d H:i:s");
    $from_date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    $message;
    $count = 0;

    if($max_id != FALSE)
    {
        //2. Select all customers with greater ids than $max_id from Postgres
        $sql = 'SELECT * FROM "public"."customers" WHERE id > '.$max_id.' LIMIT 100';
        
        $customers_array = $conn->select_items($sql);

        // var_dump($customers_array);die();
        
        if(is_array($customers_array))
        {
            $total_customers = count($customers_array);
            $count = $total_customers;
            $multi_query = "";
            //3. Insert new customers
            if($total_customers > 0)
            {
                for($r = 0; $r < $total_customers; $r++)
                {
                    $row = $customers_array[$r];
                    //check if customer exists
                    $sql = "SELECT * FROM customers WHERE id = ".$row["id"];
                    if($conn->item_exists($sql) == FALSE)
                    {

                        $multi_query .= 'INSERT INTO customers (firstName, lastName, street, city, zip, email, cell, birthDate, agentId, Visible, id, packageId, username, password, numberIdCard, houseNumber, inserted, uniqueId) VALUES ("'.$row['firstName'].'","'.$row['lastName'].'","'.$row['street'].'","'.$row['city'].'","'.$row['zip'].'","'.$row['email'].'","'.$row['cell'].'","'.$row['birthDate'].'","'.$row['agentId'].'","'.$row['Visible'].'","'.$row['id'].'","'.$row['packageId'].'","'.$row['username'].'","'.$row['password'].'","'.$row['numberIdCard'].'","'.$row['houseNumber'].'","'.$row['inserted'].'","'.$row['uniqueId'].'");';
                        // var_dump($multi_query);die();
                    }

                    else
                    {
                        $message =  $count . " customer(s) not saved";
                        echo"<span style='color:red;'>".$row["firstName"]." ".$row["lastName"]." ".$row["id"]." not saved </span><br/>";
                    }
                }
                //4. Multi insert into the database
                // ($max_id
               $result =  $conn->multi_query_statement($multi_query);
            //    var_dump($result);die();

               if($result == TRUE){
                $message = $count . " customer(s) saved";
                echo $message . $row["firstName"]." ".$row["lastName"]." ".$row["id"]." saved <br/>";
               }
               else
               {
                    $message =  $count . " customer(s) not saved";
                    echo"<span style='color:red;'>".$row["firstName"]." ".$row["lastName"]." ".$row["id"]." not saved </span><br/>";
               }
            }

            else
            {
                $message =  "No new customers found";
                echo"<span style='color:red;'>No new customers found </span><br/>";
            }
        }

        else
        {
            $message =  "No new customers found";
            echo"<span style='color:red;'>No new customers found </span><br/>";
        }
    }

    else
    {
        $message =  "No new customers found";
        echo"<span style='color:red;'>No new customers found </span><br/>";
    }

    //5. send Kaizala Action Card
    if($message != "No new customers found" && $count > 0)
    {
        $id = $kaiza->send_action_card($from_date, $to_date, $message, $title);

        echo "ActionId: ". $id;
    }
  
}

?>