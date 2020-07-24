<?php
class Booking
{
  public $table_name_train = 'train';
  public $table_name_coach = 'coach';
  public $table_name_book = "booking";
  public $data;
  public $db;
  public $value_Array = array();

  public function __construct() //create database object
  {
    $this->db = new Database();
  }

  public function add() // function for booking seats in train
  { 
    $response = null;
    $seat_number = null;
    $total_seat_with_booking_seat = null;
    if(isset($this->data->data) && !empty($this->data->data))
    {
      foreach ($this->data->data as $key => $value)
      {
          $this->value_Array[$key] = htmlspecialchars(strip_tags($value));
      }
    }
    else
    {
      return $this->db->responsehandler(0,array(),'Data field cannot be empty');
    }
    $seat_avail = $this->get_sum_book_seat(); //function for check sum of booking seat from booking table
    if($seat_avail)
    {
      $total_seat_with_booking_seat = $seat_avail+$this->value_Array['book_seat'];
    }
    else
    {
      $total_seat_with_booking_seat = $seat_avail+$this->value_Array['book_seat'];
    }
    $this->db->data = array
                      (
                      'table_name'=>$this->table_name_book,
                      'keys'=> array_keys($this->value_Array),
                      'values'=> array_values($this->value_Array)
                      );
    if($total_seat_with_booking_seat <= 80 && $total_seat_with_booking_seat <= 80)
    { 
      $response =$this->db->Insert(); //database file function called for insert in database
    }
    else
    {
      return $this->db->responsehandler(0,array(),'Seats are not Available');
    }  
    if($response['status'] === 1)
    { 
      if($this->seat_update($total_seat_with_booking_seat) === true) //funcation called for seat update in train table
      {
        return $response;
      }
    } 

  }

  public function details() // fuction for get detial for dashboard coponent in angular
  {
    $this->db->data = array
                      (
                        'table_name'=>$this->table_name_train,
                        'main_alias'=>'a',
                        'join'=>array
                        (
                          array
                          (
                            'table_name'=>$this->table_name_coach,
                            'jointype'=>'left',
                            'on'=>'b.Id = a.coach_id',
                            'alias'=>'b'
                          )
                        ),
                        'select'=>array('a.Id as Train_Number,b.Id as Coach_Number,a.total_seat as Total_Seat,a.avail_seat as Seat_Availability'),
                        'condition'=>array
                                    (
                                      'a.Id'=>'12624'
                                    )

                      );
    $response =$this->db->Get();  // database file function for get data from database
    return $response;
  }

  public function get_sum_book_seat() //function for get total booking seat from booking table
  {
    $total_book = null;
    $this->db->connect();
    $sql = 'SELECT SUM(book_seat) as total_book FROM booking';
    $responsedata = $this->db->conn->query($sql);
    if (mysqli_num_rows($responsedata) > 0)
        {
            $total_book = mysqli_fetch_array($responsedata, MYSQLI_ASSOC);  
            return $total_book['total_book'];          
        }
  }

  public function seat_update($total_book) //fucntion for update seat availability in train table
  { 
    $this->db->connect();
    $sql1 = "UPDATE `train` SET `avail_seat`=((80) - (".$total_book.")) where `Id`='12624'";   
    $responsedata = $this->db->conn->query($sql1);
    if($responsedata == 1 )
    {
      return true;
    }
  }
}

?>