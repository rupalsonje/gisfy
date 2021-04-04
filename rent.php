<?php 
    session_start();    
    include('db_connect.php');

$name = '';
$book = '';

$count=1;

$sql="SELECT `id`,`name`,`book`,`start_date`,`end_date` FROM `rent data` ORDER BY `id`;";

$result = mysqli_query($conn,$sql);

$record = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_free_result($result);

$sql="SELECT `name` FROM `book data` ORDER BY `id`;";

$result = mysqli_query($conn,$sql);

$book_record = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_free_result($result);

$sql="SELECT `name` FROM `student data` ORDER BY `id`;";

$result = mysqli_query($conn,$sql);

$student_record = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_free_result($result);

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
        $start_date = date(mysqli_real_escape_string($conn,$_POST['start_date']));
        $end_date = date(mysqli_real_escape_string($conn,$_POST['end_date']));
        // echo $name;
        $sql = "INSERT INTO `rent data`(`name`,`book`,`start_date`,`end_date`) VALUES ('$name','$book','$start_date','$end_date');";
        if(mysqli_query($conn,$sql)){
            header('Location:rent.php');
            mysqli_close($conn);
        }
        else{
          $end_date['end_date']='Error! Please try again later';
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
                <label id="name-label" for="name">Student Name</label>
                <select name="name" class="form-control form-location">
                  <option disabled selected > Select Student Name</option>
                  <?php foreach($student_record as $data){ ?>
                  <option value="<?php echo $data['name']; ?>"><?php echo $data['name']; ?></option>
                  <?php }?>
                </select>
              </div>
              
              <div class="form-index">
                <label id="book-label" for="book">Book Name</label>
                <select name="book" class="form-control form-location">
                  <option disabled selected > Select Book Name</option>
                  <?php foreach($book_record as $data){ ?>
                  <option value="<?php echo $data['name']; ?>"><?php echo $data['name']; ?></option>
                  <?php }?>                
                </select>
              </div>
              <div class="form-index">
                <label id="start-label" for="date">Start Date</label>
                <input
                  type="date"
                  name="start_date"
                  id="start_date"
                  class="form-control form-location"
                  placeholder="Start Date"
                />
              </div>
              <div class="form-index">
                <label id="end-label" for="date">End Date</label>
                <input
                  type="date"
                  name="end_date"
                  id="end_date"
                  class="form-control form-location"
                  placeholder="End Date"
                />
              </div>
                <div class="form-index">
                  <button type="submit" name="submit" id="submit" class="submit-button">
                    Submit
                  </button>
                </div>
            </form>
          </div>
        </div>
        
        <section id="table">
          <!--for demo wrap-->
          <h1 class="tbl-title">Fixed Table header</h1>
          <div class="tbl-header">
            <table>
              <thead>
                <tr>
                  <th>SR NO.</th>
                  <th>STUDENT NAME</th>
                  <th>BOOK NAME</th>
                  <th>EDIT</th>
                  <th>DELETE</th>
                </tr>
              </thead>
            </table>
          </div>
          <div class="tbl-content">
            <table>
            <?php if (count($record)==0){ ?>
                        <p class="text-center"><?php echo"no data found"; ?></p>
                    <?php }else{?>
                <?php foreach($record as $data){ ?>
              <tbody>
                <tr>
                  <td><?php echo $count?></td>
                  <td><?php echo htmlspecialchars($data['name']); ?></td>
                  <td><?php echo htmlspecialchars($data['book']); ?></td>
                  <td><a href="rent_edit.php?id=<?php echo $data['id']; ?>" class="edit"><i class="material-icons app-icon">build</i></a></td>
                  <td><a href="" class="delete"><i class="material-icons app-icon">highlight_off</i></a></td>
                </tr>
              </tbody>
              <?php $count++; }}?>
            </table>
          </div>
        </section>
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
