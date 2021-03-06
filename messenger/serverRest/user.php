<?php
/*
A domain Class to demonstrate RESTful web services
*/



Class User {

    private $users = array(
        1 => 'Youssef',
        2 => 'Jan',
        3 => 'Carlo',
        4 => 'Mäx');

    /*
        you should hookup the DAO here
    */
    public function getAllUser(){
        return $this->users;
    }

    public function getUser($id){

        $user = array($id => ($this->users[$id]) ? $this->users[$id] : $this->users[2]);
        return $user;
    }

    //conect
    public function connectDb()
    {
        $mysqli = new mysqli("localhost", "root", "", "messenger");
        return $mysqli;
    }

    //get user from DB using id
    public function getUserDb($user_id)
    {
        $mysqli = $this->connectDb();


        $result = $mysqli->query("SELECT user_id, identity, salt_masterkey, privkey_user_enc FROM users WHERE user_id = $user_id");
        $user = $result->fetch_assoc();
        //$user_ = $row['user_id']." ".$row['identity']." ".$row['salt_masterkey'];
        return $user;


    }

    public function getMessage($user_id)
    {
        return "it works"." ".$user_id;
    }



    public function deleteUserDb($user_id)
    {
        $mysqli = $this->connectDb();



        $mysqli->query("DELETE  FROM users WHERE user_id = $user_id");
        if ($mysqli->affected_rows == 1)
        {
            return "user with the user_id ==> ".$user_id.'  is deleted';
        };
    }


}
?>