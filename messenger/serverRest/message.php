<?php
/*
A domain Class to demonstrate RESTful web services
*/


Class Message{




    //conect
    public function connectDb()
    {
        $mysqli = new mysqli("localhost", "root", "", "messenger");
        return $mysqli;
    }



    //get user from DB using id
    public function getMessageDb($user_id)
    {
        $mysqli = $this->connectDb();


        $result = $mysqli->query("SELECT message_txt FROM message WHERE user_id = $user_id");
        $user = $result->fetch_assoc();
        //$user = $row['user_id']." ".$row['identity']." ".$row['salt_masterkey'];
        return $user ;


    }


    //Mockup answer Server
    private $answers = array(
        1 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> registration',
        2 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> login',
        3 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> pub_key',
        4 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> message Get Post Delete',
        5 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> delete all message',
        6 => 'hey, was get !!  hier ist der Server von der Gruppe 4 ==> delete account',
    );


    //get user from DB using id
    public function getMessage($id)
    {
        $text = $this->answers[$id];
        return $text;


    }







}

?>