<?php 
    session_start();    
    include('db_connect.php');

$name = '';
$class = '';

$count=1;
if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($conn,$_GET['id']);
    $sql="SELECT * FROM `student data` WHERE id = $id;";
    
    $result = mysqli_query($conn,$sql);

    $record = mysqli_fetch_all($result,MYSQLI_ASSOC);

    mysqli_free_result($result);
}

$error = array('class'=>'','name'=>'');

if(isset($_POST['submit'])){
    if(empty($_POST['name'])){
        $error['name']= "name is required";
    }
    else{
        $name = htmlspecialchars($_POST['name']);
    }
    
    if(empty($_POST['class'])){
        $error['class']= "class is required";
    }
    else{
        $author = htmlspecialchars($_POST['author']);
    }
    if(empty($_POST['image'])){
        $error['image']= "image is required";
    }
    else{
        $image = htmlspecialchars($_POST['image']);        
    }
    if(empty($_POST['video'])){
        $error['video']= "video is required";
    }
    else{
        $video = htmlspecialchars($_POST['video']);        
    }
    
    if(array_filter($error)){
    }
    else{
        $name = mysqli_real_escape_string($conn,$_POST['name']);
        $class = mysqli_real_escape_string($conn,$_POST['class']);        
        $image = mysqli_real_escape_string($conn,$_POST['image']);
        $video = mysqli_real_escape_string($conn,$_POST['video']);

        $sql = "UPDATE `student data` SET `name`='".$name."',`class`='".$class."',`image`='".$image."',`video`='".$video."' WHERE id='".$id."'";
            
        if(mysqli_query($conn,$sql)){
            header('Location:index.php');
            mysqli_close($conn);
        }
        else{
            $error['video']="Error! Unable to get data";
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
                  placeholder="What's Your Name?"
                  value="<?php echo $record[0]['name'] ?>"
                />
                <small><?php echo $error['name']; ?></small>
              </div>
              <div class="form-index">
                <label id="class-label" for="class">Class</label>
                <input
                  type="text"
                  name="class"
                  id="class"
                  class="form-control form-location"
                  placeholder="Enter your Class"
                  value="<?php echo $record[0]['class'] ?>"
                />
                <small><?php echo $error['class']; ?></small>
              </div>
              <div class="form-index">
                <label id="image-label" for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="form-control form-location" >
                <small><?php echo $error['image']; ?></small>
              </div>
              <div class="form-index">
                <label id="video-label" for="video">Video</label>
                <input type="file" id="video" name="video" accept="video/mp4,video/x-m4v,video/*" class="form-control form-location" >
                <small><?php echo $error['video']; ?></small>
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
