<!DOCTYPE html>
<?php
    require_once 'valid.php';
?>  
<html lang="eng">
<head>
    <title>ReadHub - Library System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
    <style>
        body {
            background-color: #f4f4f4;
            padding-top: 60px;
            font-family: 'Arial', sans-serif;
            display: flex;
            min-height: 100vh;
            flex-direction: row;
            overflow-x: hidden;
        }
        .navbar {
            background-color: #2c3e50;
            border: none;
        }
        .navbar .navbar-text {
            color: #ecf0f1;
            font-weight: bold;
        }
        .navbar .navbar-header img {
            border-radius: 50%;
        }
        .sidebar {
            height: 100vh;
            overflow-y: auto;
            position: fixed;
            top: 60px;
            left: 0;
            width: 16.6667%;
            background-color: #34495e;
            color: #ecf0f1;
            border-right: 1px solid #bdc3c7;
            padding-top: 10px;
        }
        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-bottom: 1px solid #34495e;
        }
        .sidebar a:hover {
            background-color: #1abc9c;
            color: #fff;
        }
        .content {
            margin-left: 16.6667%; /* Sidebar width */
            flex: 1;
            padding: 20px;
        }
        .well {
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .table-bordered {
            border: 1px solid #bdc3c7;
        }
        .table thead {
            background-color: #2c3e50;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #ecf0f1;
        }
        .navbar-fixed-bottom {
            background-color: #2c3e50;
            border: none;
        }
        .navbar-fixed-bottom .navbar-text {
            color: #ecf0f1;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <img src="images/logo.png" width="50px" height="50px" />
                <h4 class="navbar-text navbar-right">ReadHub</h4>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="container-fluid text-center">
            <img src="images/user.png" width="50px" height="50px" />
            <br />
            <br />
            <label class="text-muted"><?php require 'account.php'; echo $name; ?></label>
        </div>
        <hr style="border: 1px dotted #34495e;" />
        <ul id="menu" class="nav menu">
            <li><a href="home.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
            <li>
                <a href="#"><i class="glyphicon glyphicon-tasks"></i> Accounts</a>
                <ul class="nav">
                    <li><a href="admin.php"><i class="glyphicon glyphicon-user"></i> Admin</a></li>
                    <li><a href="student.php"><i class="glyphicon glyphicon-user"></i> Student</a></li>
                </ul>
            </li>
            <li><a href="book.php"><i class="glyphicon glyphicon-book"></i> Books</a></li>
            <li>
                <a href="#"><i class="glyphicon glyphicon-th"></i> Transaction</a>
                <ul class="nav">
                    <li><a href="borrowing.php"><i class="glyphicon glyphicon-random"></i> Borrowing</a></li>
                    <li><a href="returning.php"><i class="glyphicon glyphicon-random"></i> Returning</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="glyphicon glyphicon-cog"></i> Settings</a>
                <ul class="nav">
                    <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Content Area -->
    <div class="content">
        <div class="col-lg-9 well" style="margin-top: 60px;">
            <div class="alert alert-info">Transaction / Borrowing</div>
            <form method="POST" action="borrow.php" enctype="multipart/form-data">
                <div class="form-group pull-left">    
                    <label>Student Name:</label>
                    <br />
                    <select name="student_no" id="student">
                        <option value="" selected="selected" disabled="disabled">Select an option</option>
                        <?php
                            $qborrow = $conn->query("SELECT * FROM `student` ORDER BY `lastname`") or die(mysqli_error());
                            while($fborrow = $qborrow->fetch_array()){
                        ?>
                            <option value="<?php echo $fborrow['student_no']?>"><?php echo $fborrow['firstname']." ".$fborrow['lastname']?></option>
                        <?php
                            }
                        ?>
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
                        $i = 0;
                        $q_book = $conn->query("SELECT * FROM `book`") or die(mysqli_error());
                        while($f_book = $q_book->fetch_array()){
                            $q_borrow = $conn->query("SELECT SUM(qty) as total FROM `borrowing` WHERE `book_id` = '$f_book[book_id]' && `status` = 'Borrowed'") or die(mysqli_error());
                            $new_qty = $q_borrow->fetch_array();
                            $total = $f_book['qty'] - $new_qty['total'];
                        ?> 
                        <tr>
                            <td>
                                <?php
                                    if($total == 0){
                                        echo "<center><label class='text-danger'>Not Available</label></center>";
                                    } else {
                                        echo '<input type="hidden" name="book_id['.$i.']" value="'.$f_book['book_id'].'"><center><input type="checkbox" name="selector['.$i.']" value="1"></center>';
                                    }
                                ?>
                            </td>
                            <td><?php echo $f_book['book_title']?></td>
                            <td><?php echo $f_book['book_category']?></td>
                            <td><?php echo $f_book['book_author']?></td>
                            <td><?php echo date("m-d-Y", strtotime($f_book['date_publish']))?></td>
                            <td><?php echo $f_book['qty']?></td>
                            <td><?php echo $total ?></td>
                        </tr>
                        <?php
                        $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid">
            <label class="navbar-text pull-right">Library System &copy; All rights reserved 2016</label>
        </div>
    </nav>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.dataTables.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#table').DataTable();
        });
    </script>
	</body>
</html>
