<?php 
    session_start();    
    include('db_connect.php');

$name = '';
$book = '';
$start_date ='';
$end_date='';

$count=1;
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT * FROM `rent data` WHERE id = $id;";
    
    $result = mysqli_query($conn,$sql);

    $record = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
}

$error = array('book'=>'','name'=>'','start_date'=>'','end_date'=>'');

if(isset($_POST['submit'])){
    if(empty($_POST['name'])){
        $error['name']= "name is required";
    }
    else{
        $name = htmlspecialchars($_POST['name']);
    }
    
    if(empty($_POST['book'])){
        $error['book']= "Book Name is required";
    }
    else{
        $book = htmlspecialchars($_POST['book']);
    }
    if(empty($_POST['start_date'])){
      $error['start_date']= "start date is required";
    }
    else{
        $start_date = htmlspecialchars($_POST['start_date']);        
    }
    if(empty($_POST['end_date'])){
        $error['end_date']= "end date is required";
    }
    else{
        $end_date = htmlspecialchars($_POST['end_date']);        
    }
    
    if(array_filter($error)){
    }
    else{
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $book = mysqli_real_escape_string($conn,$_POST['book']);
        $start_date = mysqli_real_escape_string($conn,$_POST['start_date']);
        $end_date = mysqli_real_escape_string($conn,$_POST['end_date']);
        $sql = "UPDATE `rent data` SET `name`='".$name."',`book`='".$book."',`start_date`='".$start_date."',`end_date`='".$end_date."' WHERE id='".$id."'";
            
        if(mysqli_query($conn,$sql)){
            header('Location:rent.php');
            mysqli_close($conn);
        }
        else{
            $error['end_date']="Error! Unable to get data";
            // echo print_r($error);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gisfy</title>
    <link rel="stylesheet" href="style.css" />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  </head>
  <body>
    <div class="app-viewport inspect_">
      <!------ App Header --->
      <div class="app-header">
        <div class="app-branding">
          <i class="material-icons app-icon">change_history</i>
          <h1 class="app-brand">Brand-Name</h1>
        </div>
        <div class="app-nav">
          <p>Navigation</p>
        </div>
      </div>

      <!------ App Content --->
      <div class="app-main">
        <!------ Dashboard--->
        <div class="section">
          <div class="container">
            <header class="header">
              <h1 id="title" class="center-text">Rent Form</h1>
            </header>
            <form id="survey-form" method="POST">
              <div class="form-index">
                <label id="name-label" for="name">Name</label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  class="form-control form-location"
                  placeholder="Name of the Book"
                  value="<?php echo $record[0]['name'] ?>"
                />
                <small><?php echo $error['name']; ?></small>
              </div>
              <div class="form-index">
                <label id="book-label" for="book">book</label>
                <input
                  type="text"
                  name="book"
                  id="book"
                  class="form-control form-location"
                  placeholder="Name of book"
                  value="<?php echo $record[0]['book'] ?>"
                />
                <small><?php echo $error['book']; ?></small>
              </div>
              <div class="form-index">
                <label id="start_date-label" for="start_date">start_date</label>
                <input
                  type="date"
                  name="start_date"
                  id="start_date"
                  class="form-control form-location"
                  placeholder="start date"
                  value="<?php echo $record[0]['start_date'] ?>"
                />
                <small><?php echo date($error['start_date']); ?></small>
              </div>
              <div class="form-index">
                <label id="end_date-label" for="end_date">end_date</label>
                <input
                  type="date"
                  name="end_date"
                  id="end_date"
                  class="form-control form-location"
                  placeholder="end date"
                  value="<?php echo date($record[0]['end_date']) ?>"
                />
                <small><?php echo $error['end_date']; ?></small>
              </div>
                <div class="form-index">
                  <button type="submit" id="submit" name="submit" class="submit-button">
                    UPDATE
                  </button>
                </div>
            </form>
          </div>
        </div>
      </div>

      <!----- App Sidebar--->
      <div class="app-sidebar">
        <ul class="app-sidebar-menu">
          <li class="active">
            <a href="index.php">
              <i class="material-icons menu-icon">assignment_turned_in</i>
              <span>Student</span>
            </a>
          </li>
          <li>
            <a href="book.php">
              <i class="material-icons menu-icon">payment</i>
              <span>Book</span>
            </a>
          </li>
          <li>
            <a href="rent.php">
              <i class="material-icons menu-icon">error_outline</i>
              <span>Rent</span>
            </a>
          </li>
          <li>
            <a href="logout.php">
              <i class="material-icons menu-icon">supervised_user_circle</i>
              <span>Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <script src="script.js"></script>
  </body>
</html>
