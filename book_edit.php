<?php 
    session_start();    
    include('db_connect.php');

$name = '';
$author = '';
$publication ='';
$year='';

$count=1;
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT * FROM `book data` WHERE id = $id;";
    
    $result = mysqli_query($conn,$sql);

    $record = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
}

$error = array('author'=>'','name'=>'','publication'=>'','year'=>'');

if(isset($_POST['submit'])){
    if(empty($_POST['name'])){
        $error['name']= "name is required";
    }
    else{
        $name = htmlspecialchars($_POST['name']);
    }
    
    if(empty($_POST['author'])){
        $error['author']= "Author Name is required";
    }
    else{
        $author = htmlspecialchars($_POST['author']);
    }
    if(empty($_POST['publication'])){
      $error['publication']= "publication is required";
    }
    else{
        $publication = htmlspecialchars($_POST['publication']);        
    }
    if(empty($_POST['year'])){
        $error['year']= "year is required";
    }
    else{
        $year = htmlspecialchars($_POST['year']);        
    }
    
    if(array_filter($error)){
    }
    else{
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $author = mysqli_real_escape_string($conn,$_POST['author']);
        $publication = mysqli_real_escape_string($conn,$_POST['publication']);
        $year = mysqli_real_escape_string($conn,$_POST['year']);
        $sql = "UPDATE `book data` SET `name`='".$name."',`author`='".$author."',`publication`='".$publication."',`year`='".$year."' WHERE id='".$id."'";
            
        if(mysqli_query($conn,$sql)){
            header('Location:book.php');
            mysqli_close($conn);
        }
        else{
            $error['year']="Error! Unable to get data";
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
    <title>Document</title>
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
              <h1 id="title" class="center-text">Registration Form</h1>
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
                <label id="author-label" for="author">Author</label>
                <input
                  type="text"
                  name="author"
                  id="author"
                  class="form-control form-location"
                  placeholder="Name of Author"
                  value="<?php echo $record[0]['author'] ?>"
                />
                <small><?php echo $error['author']; ?></small>
              </div>
              <div class="form-index">
                <label id="publication-label" for="publication">Publication</label>
                <input
                  type="text"
                  name="publication"
                  id="publication"
                  class="form-control form-location"
                  placeholder="Name of Publication"
                  value="<?php echo $record[0]['publication'] ?>"
                />
                <small><?php echo $error['publication']; ?></small>
              </div>
              <div class="form-index">
                <label id="year-label" for="year">Year</label>
                <input
                  type="number"
                  name="year"
                  id="year"
                  class="form-control form-location"
                  placeholder="Year"
                  value="<?php echo $record[0]['year'] ?>"
                />
                <small><?php echo $error['year']; ?></small>
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
            <a href="index.html">
              <i class="material-icons menu-icon">assignment_turned_in</i>
              <span>Student</span>
            </a>
          </li>
          <li>
            <a href="#payment">
              <i class="material-icons menu-icon">payment</i>
              <span>Book</span>
            </a>
          </li>
          <li>
            <a href="#customers">
              <i class="material-icons menu-icon">error_outline</i>
              <span>Rent</span>
            </a>
          </li>
          <li>
            <a href="#serverlogs">
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
