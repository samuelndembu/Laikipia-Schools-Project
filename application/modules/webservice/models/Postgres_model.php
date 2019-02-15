<?php
class Postgres_model  extends CI_Model
{
    var $db_host;
    var $db_username;
    var $db_password;
    var $db_name;

    public function __construct()
    {
        $this->db_host = "pg.net-service.cz";
        $this->db_username = "mawingu_stat";
        $this->db_password = "Mawingu2891872";
        $this->db_name = "mawingu_production";
    }

    public function db_connect()
    {
        $conn = pg_connect('host='.$this->db_host. ' port=5432 dbname='.$this->db_name. ' user='.$this->db_username. ' password='.$this->db_password);

        return $conn;
    }

    function select_items($sql)
    {
        $connection = $this->db_connect();
        $result = pg_query($connection, $sql);
        $val = pg_fetch_all($result);
        return $val;
        pg_close($connection);
    }
}
?>