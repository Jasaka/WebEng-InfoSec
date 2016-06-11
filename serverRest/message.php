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
    public function getAllMessageDB($user_id)
    {
        $mysqli = $this->connectDb();


        $result = $mysqli->query("SELECT message_txt FROM message WHERE user_id = $user_id");
        $json = mysqli_fetch_all ($result, MYSQLI_ASSOC);
        $message = json_encode($json );

        return $message ;
    }


    //Mockup answer Server
    private $answers = array(
        1 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> registration',
        2 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> login',
        3 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> pub_key',
        4 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> Get message',

        5 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> Post message',
        6 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> Delete message',


        7 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> delete all message',
        8 => 'hey, was geht!!  hier ist der Server von der Gruppe 4 ==> delete account',
    );


    //get user from DB using id
    public function getMessage($id)
    {
        $text = $this->answers[$id];
        return $text;

    }







}

?>