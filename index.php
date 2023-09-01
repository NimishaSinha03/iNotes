<?php
// INSERT INTO `notes` ( `title`, `description`, `tstamp`) VALUES ('hello', 'do that', current_timestamp());
$insert = false;
// connect to the database
$severname = "localhost";
$username = "root";
$password = "";
$database = "notes";
$conn = mysqli_connect(
  $severname,
  $username,
  $password,
  $database
);
if (!$conn) {
  die("falied to connect : " . mysqli_connect_error());
}
// echo $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (isset($_POST['snoEdit'])) {
    // update the record
    $sno = $_POST["snoEdit"];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];
    $sql = "UPDATE `notes` SET `title` = `$title` , `description`=`$description` WHERE `notes`.`s no.` = $sno";
    $result = mysqli_query($conn, $sql);
    // exit();
  } else {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $sql = "INSERT INTO `notes` (`title`,`description`) VALUES ('$title','$description')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      // echo "success";
      $insert = true;
    } else {
      echo "failed " . mysqli_error($conn);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>iNotes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />





</head>

<body>
  <!-- edit modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
    Edit Modal
  </button> -->

  <!-- edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit this Note </h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/CRUD/index.php" method="POST">
            <div class="mb-3">
              <h2>Update this Note</h2>
              <label for="exampleInputEmail1" class="form-label">Note Title</label>
              <input id="titleEdit" name="titleEdit" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />

            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Note Description</label>
              <div class="form-float ing">
                <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" style="height: 100px"></textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">iNotes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact us</a>
            </li>

            <li class="nav-item">
              <a class="nav-link disabled">Disabled</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
            <button class="btn btn-outline-success" type="submit">
              Search
            </button>
          </form>
        </div>
      </div>
    </nav>
    <?php
    if ($insert) {
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> Your note has been inseerted successfully
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
    }




    ?>
    <div class="container my-4">
      <form action="/CRUD/index.php" method="POST">
        <input type="hidden" name="snoEdit" id="snoEdit">
        <div class="mb-3">
          <h2>Add a Note</h2>
          <label for="exampleInputEmail1" class="form-label">Note Title</label>
          <input id="title" name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" />

        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Note Description</label>
          <div class="form-float ing">
            <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
          </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Note</button>
      </form>
    </div>
    <div class="container">

      <table class="table" id="myTable">
        <thead>
          <tr>
            <th scope="col">S no.</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM `notes`";
          $result = mysqli_query($conn, $sql);
          $sno = 0;
          while ($row = mysqli_fetch_assoc($result)) {
            $sno = $sno + 1;
            echo "<tr>
          <th scope='row'>" . $sno . "</th>
          <td> " . $row['title'] . " </td>
          <td>" . $row['description'] . "</td>
          <td><button class ='edit btn btn-sm btn-primary' id=" . $row['s no.'] . ">Edit</button> <a href='/del'>Delete</a></td>
        </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
    <script>
      $(document).ready(function() {
        $('#myTable').DataTable();
      });
    </script>
    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
          console.log("edit", );
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          console.log(title, description);
          descriptionEdit.value = description;
          snoEdind.value = e.target.id;
          console.log(e.target.id);
          titleEdit.value = title;
          $('#editModal').modal('toggle');
        })
      })
    </script>
</body>

</html>