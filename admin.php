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
			/* General Body Styles */
			body {
				background-color: #f4f4f4;
				font-family: 'Arial', sans-serif;
				margin: 0;
				padding: 0;
			}

			/* Navbar Styles */
			.navbar {
				background-color: #2c3e50; /* Dark color for navbar */
				border: none;
				position: fixed;
				width: 100%;
				z-index: 1000;
			}
			.navbar .navbar-text {
				color: #ecf0f1; /* Light color for navbar text */
				font-weight: bold;
			}
			.navbar .navbar-header img {
				border-radius: 50%;
			}

			/* Sidebar Styles */
			.sidebar {
				position: fixed;
				top: 60px; /* below the navbar */
				left: 0;
				width: 16.6667%;
				height: calc(100vh - 60px); /* Full height minus navbar */
				background-color: #34495e;
				color: #ecf0f1;
				border-right: 1px solid #bdc3c7;
				overflow-y: auto;
				z-index: 999; /* Keep sidebar above content */
			}
			.sidebar .well {
				margin: 0;
				padding: 10px;
				background-color: #2c3e50;
				border: none;
			}
			.sidebar .well label {
				color: #ecf0f1;
			}
			.sidebar a {
				color: #ecf0f1;
				text-decoration: none;
				padding: 10px;
				display: block;
				border-bottom: 1px solid #34495e;
			}
			.sidebar a:hover {
				background-color: #1abc9c; /* Accent color on hover */
				color: #fff;
			}

			/* Main Content Styles */
			.main-content {
				margin-left: 16.6667%; /* Push content to the right of the sidebar */
				padding-top: 60px; /* Add space for fixed navbar */
				width: 83.3333%; /* Make the content take the remaining width */
			}

			/* Table Styles */
			.table-bordered {
				border: 1px solid #bdc3c7;
			}
			.table thead {
				background-color: #2c3e50;
				color: #fff;
			}
			.table tbody tr:hover {
				background-color: #ecf0f1; /* Light hover effect */
			}

			/* Buttons */
			.btn-primary {
				background-color: #1abc9c;
				border: none;
				color: #fff;
				font-weight: bold;
				transition: background-color 0.3s ease-in-out;
			}
			.btn-primary:hover {
				background-color: #16a085;
			}

			/* Footer Styles */
			.navbar-fixed-bottom {
				background-color: #2c3e50;
				border: none;
			}
			.navbar-fixed-bottom .navbar-text {
				color: #ecf0f1;
			}

			/* Responsive Design */
			@media (max-width: 768px) {
				.sidebar {
					width: 100%;
					position: relative;
					top: 0;
					height: auto;
				}
				.main-content {
					margin-left: 0;
					width: 100%;
				}
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

		<!-- Main Content -->
		<div class="main-content">
			<div class="col-lg-12 well">
				<div class="col-lg-9 well" style="margin-top:60px;">
					<div class="alert alert-info">Accounts / Admin</div>
						<button id="add_admin" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new</button>
						<button id="show_admin" type="button" style="display:none;" class="btn btn-success"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
						<br />
						<br />
						<div id="admin_table">
							<table id="table" class="table table-bordered">
								<thead class="alert-success">
									<tr>
										<th>Username</th>
										<th>Password</th>
										<th>Firstname</th>
										<th>Middlename</th>
										<th>Lastname</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$q_admin = $conn->query("SELECT * FROM `admin`") or die(mysqli_error());
									while($f_admin = $q_admin->fetch_array()){
								?>	
									<tr class="target">
										<td><?php echo $f_admin['username']?></td>
										<td><?php echo md5($f_admin['password'])?></td>
										<td><?php echo $f_admin['firstname']?></td>
										<td><?php echo $f_admin['middlename']?></td>
										<td><?php echo $f_admin['lastname']?></td>
										<td><a href="#" class="btn btn-danger deladmin_id" value="<?php echo $f_admin['admin_id']?>"><span class="glyphicon glyphicon-remove"></span> Delete</a> <a href="#" class="btn btn-warning eadmin_id" value="<?php echo $f_admin['admin_id']?>"><span class="glyphicon glyphicon-edit"></span> Edit</a></td>
									</tr>
								<?php
									}
								?>	
								</tbody>
							</table>
						</div>
						<div id = "admin_form" style = "display:none;">
							<div class = "col-lg-3"></div>
								<div class = "col-lg-6">
									<form method = "POST" action = "save_admin_query.php" enctype = "multipart/form-data">
										<div class = "form-group">
											<label>Username:</label>
											<input type = "text" required = "required" name = "username" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Password:</label>
											<input type = "password" maxlength = "12" name = "password" required = "required" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Firstname:</label>
											<input type = "text" name = "firstname" required = "required" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Middlename:</label>
											<input type = "text" name = "middlename" placeholder = "(Optional)" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Lastname:</label>
											<input type = "text" required = "required" name = "lastname" class = "form-control" />
										</div>
										<div class = "form-group">	
											<button class = "btn btn-primary" name = "save_admin"><span class = "glyphicon glyphicon-save"></span> Submit</button>
										</div>
									</form>		
								</div>	
							</div>
						</div>

						<div id = "edit_form"></div>
							<div id = "admin_form" style = "display:none;">
								<div class = "col-lg-3"></div>
								<div class = "col-lg-6">
									<form method = "POST" action = "save_admin_query.php" enctype = "multipart/form-data">
										<div class = "form-group">
											<label>Username:</label>
											<input type = "text" required = "required" name = "username" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Password:</label>
											<input type = "password" maxlength = "12" name = "password" required = "required" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Firstname:</label>
											<input type = "text" name = "firstname" required = "required" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Middlename:</label>
											<input type = "text" name = "middlename" placeholder = "(Optional)" class = "form-control" />
										</div>	
										<div class = "form-group">	
											<label>Lastname:</label>
											<input type = "text" required = "required" name = "lastname" class = "form-control" />
										</div>
										<div class = "form-group">	
											<button class = "btn btn-primary" name = "save_admin"><span class = "glyphicon glyphicon-save"></span> Submit</button>
										</div>
									</form>		
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer -->
		<nav class="navbar navbar-default navbar-fixed-bottom">
			<div class="container-fluid">
				<label class="navbar-text pull-right">Library System by Eugene &copy; All rights reserved 2024</label>
			</div>
		</nav>

		<!-- Scripts -->
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/login.js"></script>
		<script src="js/sidebar.js"></script>
		<script src="js/jquery.dataTables.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#table').DataTable();
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#add_admin').click(function(){
					$(this).hide();
					$('#show_admin').show();
					$('#admin_table').slideUp();
					$('#admin_form').slideDown();
					$('#show_admin').click(function(){
						$(this).hide();
						$('#add_admin').show();
						$('#admin_table').slideDown();
						$('#admin_form').slideUp();
					});
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$result = $('<center><label>Deleting...</label></center>');
				$('.deladmin_id').click(function(){
					$admin_id = $(this).attr('value');
					$(this).parents('td').empty().append($result);
					$('.deladmin_id').attr('disabled', 'disabled');
					$('.eadmin_id').attr('disabled', 'disabled');
					setTimeout(function(){
						window.location = 'delete_admin.php?admin_id=' + $admin_id;
					}, 1000);
				});
				$('.eadmin_id').click(function(){
					$admin_id = $(this).attr('value');
					$('#show_admin').show();
					$('#show_admin').click(function(){
						$(this).hide();
						$('#edit_form').empty();
						$('#admin_table').show();
						$('#add_admin').show();
					});
					$('#admin_table').fadeOut();
					$('#add_admin').hide();
					$('#edit_form').load('load_admin.php?admin_id=' + $admin_id);
				});
			});
		</script>
	</body>
</html>
