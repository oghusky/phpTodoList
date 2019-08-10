<?php

    $page_title="PHP Todo List";
    
    // sql connection
    $host = "localhost";
    $username = "root";
    $password = "password";
    $db_name = "todolist";

    // Create connection
    $mysqli = new mysqli($host, $username, $password, $db_name) or die(mysql_error($mysqli));
    // grabs data from db
    $result = $mysqli->query("SELECT * FROM todos") or die($mysqli->error);
    // sets text to empty string initially so nothing weird shows up on index screen
    $show_text = "";
    // set update to empty string initially so there are no random tags in input field
    $update = false;
    // set done to false initally
    $done = false;
    // sets index to 0 initally so its grabbed by update button
    $id = 0;
    // checks if button named complete is pressed
    // all sets are case sensitive
    if(isset($_POST["save"])){
        // posts text to text field in db
        $todo_text = $_POST["Text"];
        // queries insert into db
        $mysqli->query("INSERT INTO todos (Text, IsDone) VALUE('$todo_text', false)") or 
            die($mysqli->error);
        // goes back to index page after click
        header("location: index.php");
    }
    // checks id for delete using get method
    if(isset($_GET["delete"])){
        $id = $_GET["delete"];
        // db query
        $mysqli->query("DELETE FROM todos WHERE id = $id") or
            die($mysqli->error());
        // goes back to homepage after click
        header("location: index.php");
    }
    if(isset($_GET["edit"])){
        $id = $_GET["edit"];
        $update = true;
        $result = $mysqli->query("SELECT * FROM todos WHERE id = $id") or
            die($mysqli->error());
        if(count($result) == 1){
            $todo_text = $result->fetch_array();
            $show_text = $todo_text["Text"];
        }
    }
    if(isset($_POST["update"])){
        $id = $_POST["id"];
        // posts updated text to db
        $show_text = $_POST["Text"];
        // queries updated todo
        $mysqli->query("UPDATE todos SET Text='$show_text' WHERE id = $id") or 
            die($mysqli->error);
        // goes back to homepage after click
        header("location: index.php");
    }
    if(isset($_GET["done"])){
        $id = $_GET["done"];
        $done = true;
        $mysqli->query("SELECT * FROM todos WHERE id = $id") or 
            die($mysqli->error);
        $get_is_done = $mysqli->query("SELECT * FROM todos") or die($mysqli->error);
        if(count($result)== 1 && $done == true){
            $mysqli->query("UPDATE todos SET IsDone = true WHERE id = $id") or
                die($mysqli->error);
        }
        header("location: index.php");
    }
    if(isset($_GET["not"])){
        $id = $_GET["not"];
        $done = false;
        $mysqli->query("SELECT * FROM todos WHERE id = $id") or 
            die($mysqli->error);
        if(count($result ) == 1 && $done == false){
            $mysqli->query("UPDATE todos SET IsDone = false WHERE id = $id") or
                die($mysqli->error);
        }
        header("location: index.php");
    }
?>