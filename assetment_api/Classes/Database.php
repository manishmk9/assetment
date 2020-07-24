<?php
class Database
{
    public $server_name = 'localhost';
    public $user_name = 'pv_app_gurugram';
    public $password = 'u=7u]mk(,9b%';
    public $database = 'pv_app_gurugram';
    public $conn = null;

    public function connect() //connection database
    {
        $this->conn = mysqli_connect($this->server_name, $this->user_name, $this->password, $this->database);
    }

    public function responsehandler($key = 0, $data, $message)
    {
        if ($key === 1)
        {
            return array("status" => 1,'data' => $data,'message' => $message);
        }
        else
        {
            return array("status" => 0,'data' => $data,'message' => $message);
        }
    }

    public function Insert() // insert function for insert data in database
    {
        $keysArray = array();
        $FinalValueArray = array();
        $valuesArray = array();
        $valuesStr = '';
        $TableName = $this->data['table_name'];
        if(isset($this->data['keys']))
        {
            foreach ($this->data['keys'] as $key => $value) 
            {
                $keysArray[] = "`".$value."`";
            }
        }
        if(isset($this->data['values']))
        {
            foreach ($this->data['values'] as $key => $value) 
            {
                    $valuesArray[$key] = "'".$value."'";
                
            }   
        }
        $kStr = "(".implode(',', $keysArray).")";
        $vStr = '('.implode(',', $valuesArray).')';
        $this->connect();
        $sql_query="INSERT INTO `".$TableName."` ".$kStr." VALUES ".$vStr;  
        if($this->conn->query($sql_query))
        {
            return $this->ResponseHandler(1,array('Id'=>$this->conn->insert_id),'Inserted successfully');
        }
        else
        {
            return $this->ResponseHandler(0,array('msg'=>mysqli_error($this->conn)),'Unable to insert');
        }
    }

    public function Update() //update function for update in database 
    {
        $keysArray = array();
        $FinalValueArray = array();
        $valuesArray = array();
        $valuesStr = '';
        $WhereArray = array();
        $TableName = $this->data['table_name'];
        if(isset($this->data['values']))
        {
            foreach ($this->data['values'] as $key => $value) 
            {
                $valuesArray[] = "`".$key."`="."'".$value."'";
            }
        }
        if(isset($this->data['condition']) && !empty($this->data['condition']))
        {
            foreach ($this->data['condition'] as $key => $value) 
            {
                $WhereArray[] = "`".$key."`="."'".$value."'";
            }
        }
        if($WhereArray)
        {
            $Where = " where " .implode(',', $WhereArray);
        }
        else
        {
            $Where = '';
        }
        $vStr = implode(',', $valuesArray);
        $this->connect();
        $sql_query="UPDATE `".$TableName."` SET ".$vStr." ".$Where." "; 
        if($this->conn->query($sql_query))
        {
            return $this->ResponseHandler(1,array(),'Updated successfully');
        }
        else
        {
            return $this->ResponseHandler(0,array('msg'=>mysqli_error($this->conn)),'Unable to update');
        }
        
    }

    public function Get() // get function for get single row data from database
    {
        $keysArray = array();
        $FinalValueArray = array();
        $valuesArray = array();
        $valuesStr = '';
        $WhereArray = array();
        $selectarray = array();
        $select = '';
        $TableName = $this->data['table_name'];
        $MainAlias = $this->data['main_alias'];

        if (isset($this->data['select']) && !empty($this->data['select']))
        {
            foreach ($this->data['select'] as $key => $value)
            {
                $selectarray[] = $value;
            }
            $select = implode(',', $selectarray);
        }
        else
        {
            $select = '*';
        }
        if (isset($this->data['condition']) && !empty($this->data['condition']))
        {
            foreach ($this->data['condition'] as $key => $value)
            {
                $WhereArray[] = "" . $key . "=" . "'" . $value . "'";
            }
        }
        if ($WhereArray)
        {
            $Where = " where " . implode(',', $WhereArray);
        }
        else
        {
            $Where = '';
        }

        if ($this->data['join'])
        {
            $Join = '';
            foreach ($this->data['join'] as $key => $value)
            {
                $Join .= $value['jointype'] . " join " . $value['table_name'] . " " . $value['alias'] . " on " . $value['on'] . " ";
            }
        }
        else
        {
            $Join = '';
        }

        $vStr = implode(',', $valuesArray);
        $this->connect();
        $sql_query = "SELECT " . $select . " from `" . $TableName . "` " . $MainAlias . " " . $Join . " " . $Where . " " . $vStr . " ";
        $responsedata = $this->conn->query($sql_query);
        if (mysqli_num_rows($responsedata) > 0)
        {
            return $this->ResponseHandler(1, mysqli_fetch_array($responsedata, MYSQLI_ASSOC) , 'Data Get successfully');
        }
        else
        {
            return $this->ResponseHandler(0, array('msg' => mysqli_error($this->conn)) , 'Unable to Get Data');
        }

    }
}
?>
