<?php
date_default_timezone_set('Africa/Nairobi');
set_time_limit(0);

include "Connection.php";
include "Kaizala.php";

function update_mpesa_lipa_transaction(){
    $conn = new Connection();
    $kaiza = new Kaizala();

    // $title = "Updates: Lipa na Mpesa Transaction";

    //1. Get mpesalipatransaction_id and id from Mawingunetworks.com mpesalipatransaction
    //   table where status=3
    $sql = 'SELECT mpesalipatransaction_id, id FROM mpesalipatransaction WHERE status = 3 AND resultCode != "0"';
    $mpesa_lipa_transaction = $conn->mysql_select_items($sql);
    
    // var_dump($mpesa_lipa_transaction);die();

    $to_date = date("Y-m-d H:i:s");
    $from_date = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    $message;
    $count = 0;

    if($mpesa_lipa_transaction != FALSE)
    {
        if(is_array($mpesa_lipa_transaction))
        {
            $total_mpesa_lipa_transaction = count($mpesa_lipa_transaction);
            $count = $total_mpesa_lipa_transaction;
            $total_saved = 0;

            $mpesalipatransaction_ids = "(";

            //2. Get mpesalipatransaction_id and create comma separated values
            if($total_mpesa_lipa_transaction > 0)
            {
                echo $total_mpesa_lipa_transaction."<br/>";
                for($r = 0; $r < $total_mpesa_lipa_transaction; $r++)
                {
                    $row = $mpesa_lipa_transaction[$r];
                    
                    if($r == $total_mpesa_lipa_transaction - 1)
                    {
                        $mpesalipatransaction_ids .= $row[1] . ")";
                    }
                    else
                    {
                        $mpesalipatransaction_ids .= $row[1] . ",";
                    }
                }

                //3. Select all from Postgres mpesaLipaTransaction table IN mpesalipatransaction_ids
                $sql = 'SELECT * FROM "public"."mpesaLipaTransaction" WHERE id IN ' . $mpesalipatransaction_ids;
                // echo $sql; die();
                $mpesa_results = $conn->select_items($sql);

                // var_dump($mpesa_results);die();

                $multi_query = "";
                $count = 0;

                if(is_array($mpesa_results))
                {
                    $total_mpesa_results = count($mpesa_results);
                    
                    if($total_mpesa_results > 0)
                    {
                        echo $total_mpesa_results."<br/>";
                        //4. Update all in mpesalipatransaction with the ids
                        for($j = 0; $j < $total_mpesa_results; $j++)
                        {
                            $row = $mpesa_results[$j];

                            if($row["resultCode"] == "0")
                            {
                                $count++;
                                 // var_dump($row);die();
                                $multi_query .= 'UPDATE mpesalipatransaction SET customerId ="'.$row["customerId"].'", ticketId ="'.$row["ticketId"].'", status ="'.$row["status"].'", amount ="'.$row["amount"].'", msisdn ="'.$row["msisdn"].'", merchantRequestID ="'.$row["merchantRequestID"].'", checkoutRequestID ="'.$row["checkoutRequestID"].'", responseDescription ="'.$row["responseDescription"].'", responseCode ="'.$row["responseCode"].'", customerMessage ="'.$row["customerMessage"].'", responseReceived ="'.$row["responseReceived"].'", resultDesc ="'.$row["resultDesc"].'", resultCode ="'.$row["resultCode"].'", resultReceived ="'.$row["resultReceived"].'", errorCode ="'.$row["errorCode"].'", errorMessage ="'.$row["errorMessage"].'", requestPackage ="'.$row["requestPackage"].'", category ="'.$row["category"].'", agentId ="'.$row["agentId"].'", routerId ="'.$row["routerId"].'", mpesaReceiptNumber = "'.$row["mpesaReceiptNumber"].'" WHERE id = '.$row["id"].';';
                            }
                           
                            // break;
                        }
                        // echo $multi_query; die();
                    }
                }

                $result =  $conn->multi_query_statement($multi_query);
                var_dump($result);
                echo "Total results = ".$count;
            }

            else
            {
                $message =  "No new mpesaLipaTransaction found";
                echo"<span style='color:red;'>No new mpesaLipaTransaction found </span><br/>";
            }
        }
    }
}

//Run this function
update_mpesa_lipa_transaction();

?>