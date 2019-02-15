<?php
// $base_url = "http://localhost/mawingu-downtime/";
class Connection
{
    var $db_host;
    var $db_username;
    var $db_password;
    var $db_name;
    var $mysql_db_host;
    var $mysql_db_dbname;
    var $mysql_db_username;
    var $mysql_db_password;

    public function __construct()
    {
        //Postgres Database Config
        $this->db_host = "pg.net-service.cz";
        $this->db_username = "mawingu_stat";
        $this->db_password = "Mawingu2891872";
        $this->db_name = "mawingu_production";

        //MySQL Database Config
        // $this->mysql_db_host = "mawingunetworks.com";
        // $this->mysql_db_dbname = "mawingun_mpesa";
        // $this->mysql_db_username = "mawingun_mpesa";
        // $this->mysql_db_password = "r6r5bb!!";
        
        // $this->mysql_db_host = "localhost";
        // $this->mysql_db_dbname = "mawingun_mpesa";
        // $this->mysql_db_username = "root";
        // $this->mysql_db_password = "";

        $this->mysql_db_host = "localhost";
        $this->mysql_db_dbname = "mkopa";
        $this->mysql_db_username = "root";
        $this->mysql_db_password = "";
    }

    //Connect to MySQL
    function mysql_db_connect()
    {

        $conn = new mysqli($this->mysql_db_host, $this->mysql_db_username, $this->mysql_db_password, $this->mysql_db_dbname);

        if($conn->connect_error)
        {
            die("Connection failed ".$conn->connect_error);
        }

        return $conn;
    
    }

    //Connect Postgres
    public function db_connect()
    {
        
        $conn = pg_connect('host='.$this->db_host. ' port=5432 dbname='.$this->db_name. ' user='.$this->db_username. ' password='.$this->db_password);

        return $conn;
    }

    //MySQL queries
    function mysql_queries($sql){
        $connection = $this->mysql_db_connect();
        $result = $connection->query($sql);
        mysqli_close($connection);

        return $result;
    }

    function select_items($sql)
    {
        $connection = $this->db_connect();
        $result = pg_query($connection, $sql);
        $val = pg_fetch_all($result);
       
        // var_dump($val);die();
        return $val;

        pg_close($connection);
        
    }

    function get_max_id($sql)
    {
        $query = $this->mysql_queries($sql);
        
        if($query != FALSE)
        {
            $row = $query->fetch_row();
            
            if($row)
            {
                $max_id = $row[0];
                return $max_id;
            }

            else
            {
                return FALSE;
            }
        }

        else
        {
            return FALSE;
        }
    }

    function item_exists($sql)
    {
        $query = $this->mysql_queries($sql);
        $row = $query->fetch_row();

        if($row == NULL)
        {
            return FALSE;
        }

        else
        {
            return TRUE;
        }
    }

    function mysql_select_items($sql)
    {
        $query = $this->mysql_queries($sql);
        
        if($query != FALSE)
        {
            $results = $query->fetch_all();
            if($results)
            {
                return $results;
            }

            else
            {
                return FALSE;
            }
        }

        else
        {
            return FALSE;
        }
    }

    function multi_query_statement($multi_query)
    {
        //var_dump($multi_query);
        $connection = $this->mysql_db_connect();
        // $result = $connection->multi_query($multi_query);
        $result = mysqli_multi_query($connection, $multi_query);
        mysqli_close($connection);

        return $result;
    }

}
?>