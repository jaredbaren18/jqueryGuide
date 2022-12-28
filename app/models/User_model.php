<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User_model extends Model {


  //insertion of data into db coming from the inputs
  public function insertStudent($fname, $username, $pass){

    //list data into an associative array
    $data = [
      'fullname' => $fname,
      'username' => $username,
      'password'=> $pass
    ];
    //execute the data to be insert in the database
    return $this->db->table('user')->insert($data);
  }


  //get all data from the database
  public function getAlldata(){
    return $this->db->table('user')->get_all();
  }

  public function getSingleStudent($id){
    return $this->db->table('user')->where('user_id', $id)->get();
  }

  public function updateStudent($id, $fname, $username, $pass){

    //list data into an associative array
    $data = [
      'fullname' => $fname,
      'username' => $username,
      'password'=> $pass
    ];
    //execute the data to be insert in the database
    return $this->db->table('user')->where('user_id', $id)->update($data);
  }

	public function deleteData($id){
    return $this->db->table('user')->where('user_id', $id)->delete();
  }
}
?>
