<!DOCTYPE html>
<?php
    require_once 'valid.php';
?>  
<html lang="eng">
<head>
    <title>Library System - Returning</title>
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
            <div class="alert alert-info">Transaction / Returning</div>
            <form method="POST" action="return.php" enctype="multipart/form-data">
                <table id="table" class="table table-bordered">
                    <thead class="alert-success">
                        <tr>
                            <th>Student</th>
                            <th>Book Title</th>
                            <th>Book Author</th>
                            <th>Status</th>
                            <th>Date Returned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $qreturn = $conn->query("SELECT * FROM `borrowing`") or die(mysqli_error());
                            while($freturn = $qreturn->fetch_array()){
                        ?>
                        <tr>
                            <td>
                                <?php
                                    $qstudent = $conn->query("SELECT * FROM `student` WHERE `student_no` = '{$freturn['student_no']}'") or die(mysqli_error());
                                    $fstudent = $qstudent->fetch_array();
                                    echo $fstudent['firstname']." ".$fstudent['lastname'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    $qbook = $conn->query("SELECT * FROM `book` WHERE `book_id` = '{$freturn['book_id']}'") or die(mysqli_error());
                                    $fbook = $qbook->fetch_array();
                                    echo $fbook['book_title'];
                                ?>
                            </td>
                            <td>
                                <?php
                                    $qbook = $conn->query("SELECT * FROM `book` WHERE `book_id` = '{$freturn['book_id']}'") or die(mysqli_error());
                                    $fbook = $qbook->fetch_array();
                                    echo $fbook['book_author'];
                                ?>
                            </td>
                            <td><?php echo $freturn['status'] ?></td>
                            <td><?php echo date("m-d-Y", strtotime($freturn['date'])) ?></td>
                            <td>
                                <?php 
                                    if($freturn['status'] == 'Returned'){
                                        echo '<center><button disabled="disabled" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Returned</button></center>';  
                                    } else {
                                        echo '<input type="hidden" name="borrow_id" value="'.$freturn['borrow_id'].'"/>';
                                        echo '<center><button class="btn btn-primary"><span class="glyphicon glyphicon-unchecked"></span> Return</button></center>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid">
            <label class="navbar-text pull-left">Developed By: CHMSC TEAM - Alijis</label>
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
            $('#table').DataTable();
        });
    </script>
</body>
</html>
