<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class User extends Controller {

	public function index(){
    $data = [
      'users'=> $this->User_model->getAlldata(),
    ];
    $this->call->view('index',$data);
  }

  // public function test(){
  //   $this->call->view('test');
  // }

  public function insertData(){
    $fullname = $this->io->post('fullname');
    $username = $this->io->post('username');
    $pass = $this->io->post('password');

    
    if($fullname == '' && $username == '' && $pass == '' ){
      $res = [
        'status' => 500,
        'message' => 'All fields are required.'
      ];
      echo json_encode($res);
      return;

    }else{
      $isInserted = $this->User_model->insertStudent($fullname, $username, $pass);
      if ($isInserted) {
          $res = [
            'status' => 200,
            'message' => 'Data inserted successfully.'
          ];
          echo json_encode($res);
          return;
        } 
    }
   
    
    // return;

  }

  public function getSingleUser(){
    $id = $this->io->post('user_id');
    $user = $this->User_model->getSingleStudent($id);
    if ($user) {
      $res = [
        'status' => 200,
        'user' => $user,
        'message' => 'Select user not found',
      ];
      echo json_encode($res);
    }else{
      $res = [
        'status' => 500,
        'message' => 'Selected user not found',
      ];
      echo json_encode($res);
    }
  }

  public function updateData(){
    $user_id = $this->io->post('user_id');
    $fullname = $this->io->post('fullname');
    $username = $this->io->post('username');
    $pass = $this->io->post('password');

    
    if($fullname == '' && $username == '' && $pass == '' ){
      $res = [
        'status' => 500,
        'message' => 'All fields are required.'
      ];
      echo json_encode($res);

    }else{
      $isUpdated = $this->User_model->updateStudent($user_id, $fullname, $username, $pass);
      if ($isUpdated) {
          $res = [
            'status' => 200,
            'message' => 'Data updated successfully.'
          ];
          echo json_encode($res);
        } 
    }
   
    
    // return;

  }

  public function deleteData(){
    $id = $this->io->post('user_id');
    $user = $this->User_model->deleteData($id);
    if ($user) {
      $res = [
        'status' => 200,
        'user' => $user,
        'message' => 'Data Deleted successfully.'
      ];
      echo json_encode($res);
    }else{
      $res = [
        'status' => 500,
        'message' => 'Selected user not found',
      ];
      echo json_encode($res);
    }
  }
}
?>
