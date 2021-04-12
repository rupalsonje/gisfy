<?php 
    session_start();    
    include('db_connect.php');

$name = '';
$author = '';
$publication ='';
$year='';

$count=1;

$sql="SELECT `id`,`name`,`author`,`publication`,`year` FROM `book data` ORDER BY `id`;";

$result = mysqli_query($conn,$sql);

$record = mysqli_fetch_all($result,MYSQLI_ASSOC);

mysqli_free_result($result);


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

        $sql = "INSERT INTO `book data`(`name`,`author`,`publication`,`year`) VALUES ('$name','$author','$publication','$year');";
        if(mysqli_query($conn,$sql)){
            header('Location:book.php');
            mysqli_close($conn);
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
              <h1 id="title" class="center-text">Book Registration</h1>
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
                  value="<?php echo $name ?>"
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
                  value="<?php echo $author ?>"
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
                  value="<?php echo $publication ?>"
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
                  value="<?php echo $year ?>"
                />
                <small><?php echo $error['year']; ?></small>
              </div>
                <div class="form-index">
                  <button type="submit" id="submit" name="submit" class="submit-button">
                    Submit
                  </button>
                </div>
            </form>
          </div>
        </div>
        
        <section id="table">
          <!--for demo wrap-->
          <h1 class="tbl-title">Book's Record</h1>
          <div class="tbl-header">
            <table>
              <thead>
                <tr>
                  <th>SR NO.</th>
                  <th>NAME</th>
                  <th>AUTHOR</th>
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
                  <td><?php echo htmlspecialchars($data['author']); ?></td>
                  <td><a href="book_edit.php?id=<?php echo $data['id']; ?>" class="edit"><i class="material-icons app-icon">build</i></a></td>
                  <td><a href="delete_book.php?id=<?php echo $data['id']; ?>" class="delete"><i class="material-icons app-icon">highlight_off</i></a></td>
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
