<?php
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

include "../Connection.php";
include "../Kaizala.php";

function update_mpesa_lipa_transaction(){
    $conn = new Connection();
    $kaiza = new Kaizala();

    $title = "Updates: Lipa na Mpesa Transaction";

    //1. Get max id from Mawingunetworks.com
    $sql = 'SELECT MAX(id) FROM mpesalipatransaction';
    $max_id = $conn->get_max_id($sql);
    
    echo($max_id);

    $to_date = date("Y-m-d H:i:s");
    $from_date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    $message;
    $count = 0;

    if($max_id != FALSE)
    {
        //2. Select all mpesaLipaTransaction with greater ids than $max_id from Postgres
        $sql = 'SELECT * FROM "public"."mpesaLipaTransaction" WHERE id > '.$max_id.' LIMIT 100';
        
        $mpesa_lipa_transaction = $conn->select_items($sql);
        
        // var_dump($mpesa_lipa_transaction); die();

        if(is_array($mpesa_lipa_transaction))
        {
            $total_mpesa_lipa_transaction = count($mpesa_lipa_transaction);
            $count = $total_mpesa_lipa_transaction;
            $total_saved = 0;
            $multi_query = "";
            //3. Insert new mpesaLipaTransaction
            if($total_mpesa_lipa_transaction > 0)
            {
                for($r = 0; $r < $total_mpesa_lipa_transaction; $r++)
                {
                    $row = $mpesa_lipa_transaction[$r];
                   //check if mpesa_lipa_transaction exists
                   $sql = "SELECT * FROM mpesalipatransaction WHERE id = ".$row["id"];
                   if($conn->item_exists($sql) == FALSE)
                    {
                       
                        $total_saved++;
                        $multi_query .= "INSERT INTO mpesalipatransaction (id, customerId, ticketId, status, amount, msisdn, merchantRequestID, checkoutRequestID, responseDescription, responseCode, customerMessage, responseReceived, resultDesc, resultCode, resultReceived, errorCode, errorMessage, requestPackage, category, agentId, routerId, mpesaReceiptNumber) VALUES ('".$row["id"]."','".$row["customerId"]."','".$row["ticketId"]."','".$row["status"]."','".$row["amount"]."','".$row["msisdn"]."','".$row["merchantRequestID"]."','".$row["checkoutRequestID"]."','".$row["responseDescription"]."','".$row["responseCode"]."','".$row["customerMessage"]."','".$row["responseReceived"]."','".$row["resultDesc"]."','".$row["resultCode"]."','".$row["resultReceived"]."','".$row["errorCode"]."','".$row["errorMessage"]."','".$row["requestPackage"]."','".$row["category"]."','".$row["agentId"]."','".$row["routerId"]."', '".$row["mpesaReceiptNumber"]."');";
                        // var_dump($multi_query); die();
                    }

                    else
                    {
                        $message =  $count . " mpesa-transaction(s) not saved";
                        echo"<span style='color:red;'>".$row["amount"]." ".$row["id"]." already exists </span><br/>";
                    }
                }
                
                //4. Multi insert into the database
               $result =  $conn->multi_query_statement($multi_query);
               if($result == TRUE){
                    $message = $total_saved . " mpesa-transaction(s) saved";
                    echo $total_saved . " mpesa-transaction(s) saved<br/>";
               }
               else
               {
                    $message =  $total_saved . " mpesa-transaction(s) not saved";
                    echo"<span style='color:red;'>".$total_saved." mpesa-transaction(s) not saved </span><br/>";
               }
            }

            else
            {
                $message =  "No new mpesaLipaTransaction found";
                echo"<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
            }
        }

        else
        {
            $message =  "No new mpesaLipaTransaction found";
            echo"<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
        }
    }

    else
    {
        $message =  "No new mpesaLipaTransaction found";
        echo"<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
    }

    //5. send Kaizala Action Card
    if($message != "No new mpesaLipaTransaction found" && $count > 0)
    {
        $id = $kaiza->send_action_card($from_date, $to_date, $message, $title);

        echo "ActionId: ". $id;
    }
}

//Run this function
update_mpesa_lipa_transaction();

?>