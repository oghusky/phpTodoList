<!-- brings in actiona from process file -->
<?php require_once "process.php"; ?>
<?php
    // page title
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $page_title ?></title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background-color: #e0e0e0;
        }
        .container{
            background-color: #fdfdfd;
            padding: 2rem 1.2rem;
            position: relative;
            width: 50%;
            margin: 2rem auto 2rem auto;
        }
        .buttonspan{
            margin-left: 39%;
        }
        .text{
            width: 80%;
            margin: 1rem auto;
        }
        .btn{
            border-radius: 0;
        }
        #enter-text{
            border-radius: 0;
            border-top: none;
            border-left: none;
            border-right: none;
            padding-bottom: 0rem;
            border-bottom: 1px solid #e0e0e0;
        }
        #enter-text:focus{
            outline: none;
            box-shadow: none;
            background: transparent;
        }
        @media screen and (max-width: 700px){
            .container{
                width: 100%;
            }
            .btn{
                font-size: .7rem;
            }
            .actual-text{
                line-height: .2rem;
            }
        }
    </style>
</head>
<body>
<!-- container -->
    <div class="container">
        <div>
        <!-- form -->
            <form action="process.php" method="POST" id="todo_form">
            <!-- input that grabs id from db -->
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                <!-- text input -->
                <input 
                    id="enter-text"
                    class="form-control" 
                    type="text" 
                    name="Text" 
                    placeholder="Add item"
                    value="<?php echo $show_text; ?>"
                    require>
                </div>
                <!-- conditionally renders button  -->
                <div class="form-group">
                    <?php
                        if($update == true):
                    ?>
                    <p class="text-center">
                        <button class="btn btn-warning btn-md" type="submit" name="update">UPDATE <i class="far fa-paper-plane"></i></button>
                    </p>
                    <?php
                        else:
                    ?>
                    <p class="text-center">
                        <button class="btn btn-primary btn-md" type="submit" name="save">SAVE <i class="far fa-paper-plane"></i></button>
                    </p>
                    <?php endif; ?>
                </div>
            </form>
            <!-- where todos show up from db -->
            <section id="todo_section">
                <h3 class="text-center">Todo List</h3>
                <?php 
                    while($todo_text = $result->fetch_assoc()): 
                ?>
                        <div class="display-text">
                            <p class="text clearfix">
                                <?php if($todo_text["IsDone"] == 0): ?>
                                    <a 
                                        href="index.php?done=<?php echo $todo_text['id']; ?>"
                                        class="btn btn-sm btn-success float-left" 
                                        name="done"><i class="far fa-square"></i>
                                    </a>
                                <?php elseif($todo_text["IsDone"] == 1): ?>
                                    <a 
                                        href="index.php?not=<?php echo $todo_text['id']; ?>"
                                        class="btn btn-sm btn-primary float-left" 
                                        name="not"><i class="far fa-check-square"></i>
                                    </a>   
                                <?php endif; ?>
                                
                                <span 
                                    class="actual-text pl-4">
                                    <?php 
                                        echo $todo_text["Text"]; 
                                    ?>
                                </span> 
                                <span class="buttonspan float-right">
                                    <a 
                                        href="index.php?edit=<?php echo $todo_text['id']; ?>" 
                                        class="btn btn-sm btn-warning"><i class="far fa-edit"></i>
                                    </a>
                                    <a 
                                        href="process.php?delete=<?php echo $todo_text['id']; ?>"
                                        class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i>
                                    </a>
                                </span>
                            </p>
                            <hr/>
                        </div>
                <?php endwhile; ?>
                <?php
                    function pre_r( $array ){
                        echo "<div>";
                        print_r($array);
                        echo "</div>";
                    }
                ?>
            </section>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>