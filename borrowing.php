<!DOCTYPE html>
<?php
    require_once 'valid.php';
?>  
<html lang="eng">
<head>
    <title>Library System - Borrowing</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="css/chosen.min.css" />
    <style>
        body {
            background-color: #d3d3d3;
            padding-top: 60px;
        }
        .sidebar {
            position: fixed;
            top: 60px;
            left: 0;
            width: 16.6667%;
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #d3d3d3;
            overflow-y: auto;
        }
        .content {
            margin-left: 16.6667%;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <img src="images/logo.png" width="50px" height="50px" />
                <h4 class="navbar-text navbar-right">Library System</h4>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="container-fluid text-center">
            <img src="images/user.png" width="50px" height="50px" />
            <br /><br />
            <label class="text-muted"><?php require 'account.php'; echo $name; ?></label>
        </div>
        <hr style="border: 1px dotted #d3d3d3;" />
        <ul id="menu" class="nav menu">
            <li><a href="home.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
            <li><a href="borrowing.php"><i class="glyphicon glyphicon-random"></i> Borrowing</a></li>
            <li><a href="returning.php"><i class="glyphicon glyphicon-random"></i> Returning</a></li>
            <li><a href="student.php"><i class="glyphicon glyphicon-user"></i> Students</a></li>
            <li><a href="book.php"><i class="glyphicon glyphicon-book"></i> Books</a></li>
            <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="col-lg-12 well">
            <form method="POST" action="borrow.php" enctype="multipart/form-data">
                <div class="form-group pull-left">
                    <label>Student Name:</label><br />
                    <select name="student_no" id="student" class="form-control">
                        <option value="" selected disabled>Select an option</option>
                        <?php
                            $qborrow = $conn->query("SELECT * FROM `student` ORDER BY `lastname`") or die(mysqli_error());
                            while($fborrow = $qborrow->fetch_array()){
                        ?>
                        <option value="<?php echo $fborrow['student_no'] ?>">
                            <?php echo $fborrow['firstname']." ".$fborrow['lastname'] ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group pull-right">
                    <button name="save_borrow" class="btn btn-primary"><span class="glyphicon glyphicon-thumbs-up"></span> Borrow</button>
                </div>
                <table id="table" class="table table-bordered">
                    <thead class="alert-success">
                        <tr>
                            <th>Select</th>
                            <th>Book Title</th>
                            <th>Book Category</th>
                            <th>Book Author</th>
                            <th>Date Published</th>
                            <th>Quantity</th>
                            <th>Left</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $q_book = $conn->query("SELECT * FROM `book`") or die(mysqli_error());
                            while($f_book = $q_book->fetch_array()){
                                $q_borrow = $conn->query("SELECT SUM(qty) as total FROM `borrowing` WHERE `book_id` = '{$f_book['book_id']}' AND `status` = 'Borrowed'") or die(mysqli_error());
                                $new_qty = $q_borrow->fetch_array();
                                $total = $f_book['qty'] - $new_qty['total'];
                        ?>
                        <tr>
                            <td>
                                <?php if ($total == 0) {
                                    echo "<center><label class='text-danger'>Not Available</label></center>";
                                } else { ?>
                                <input type="hidden" name="book_id[]" value="<?php echo $f_book['book_id'] ?>">
                                <center><input type="checkbox" name="selector[]" value="1"></center>
                                <?php } ?>
                            </td>
                            <td><?php echo $f_book['book_title'] ?></td>
                            <td><?php echo $f_book['book_category'] ?></td>
                            <td><?php echo $f_book['book_author'] ?></td>
                            <td><?php echo date("m-d-Y", strtotime($f_book['date_publish'])) ?></td>
                            <td><?php echo $f_book['qty'] ?></td>
                            <td><?php echo $total ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid">
            <label class="navbar-text pull-right">Library System &copy; All rights reserved 2016</label>
        </div>
    </nav>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/login.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script src="js/chosen.jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#student').chosen({ width: "auto" });
            $('#table').DataTable();
        });
    </script>
</body>
</html>
