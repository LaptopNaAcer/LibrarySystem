<!DOCTYPE html>
<?php
    require_once 'valid.php';
?>  
<html lang="eng">
<head>
    <title>Library System - Students</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
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
            <div class="alert alert-info">Accounts / Student</div>
            <button id="add_student" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new</button>
            <button id="show_student" type="button" style="display:none;" class="btn btn-success"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
            <br /><br />
            <div id="student_table">
                <table id="table" class="table table-bordered">
                    <thead class="alert-success">
                        <tr>
                            <th>Student ID</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                            <th>Lastname</th>
                            <th>Course</th>
                            <th>Yr & Section</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $qstudent = $conn->query("SELECT * FROM `student`") or die(mysqli_error());
                            while($fstudent = $qstudent->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $fstudent['student_no'] ?></td>
                            <td><?php echo $fstudent['firstname'] ?></td>
                            <td><?php echo $fstudent['middlename'] ?></td>
                            <td><?php echo $fstudent['lastname'] ?></td>
                            <td><?php echo $fstudent['course'] ?></td>
                            <td><?php echo $fstudent['section'] ?></td>
                            <td>
                                <a value="<?php echo $fstudent['student_no'] ?>" class="btn btn-danger delstudent_id"><span class="glyphicon glyphicon-remove"></span> Delete</a>
                                <a value="<?php echo $fstudent['student_no'] ?>" class="btn btn-warning estudent_id"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div id="edit_form"></div>
            <div id="student_form" style="display:none;">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <form method="POST" action="save_student_query.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Student ID:</label>
                            <input type="text" name="student_no" required="required" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Firstname:</label>
                            <input type="text" name="firstname" required="required" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Middlename:</label>
                            <input type="text" name="middlename" placeholder="(Optional)" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Lastname:</label>
                            <input type="text" required="required" name="lastname" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Course:</label>
                            <input type="text" required="required" name="course" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Yr & Section:</label>
                            <input type="text" maxlength="12" name="section" required="required" class="form-control" />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" name="save_student"><span class="glyphicon glyphicon-save"></span> Submit</button>
                        </div>
                    </form>       
                </div>  
            </div>
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('#table').DataTable();
            $('#add_student').click(function(){
                $(this).hide();
                $('#show_student').show();
                $('#student_table').slideUp();
                $('#student_form').slideDown();
                $('#show_student').click(function(){
                    $(this).hide();
                    $('#add_student').show();
                    $('#student_table').slideDown();
                    $('#student_form').slideUp();
                });
            });
        });
    </script>
</body>
</html>
