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
				padding-top: 60px; /* For fixed navbar */
				font-family: 'Arial', sans-serif;
			}
			
			/* Navbar Styles */
			.navbar {
				background-color: #2c3e50; /* Dark color for navbar */
				border: none;
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
				height: 100vh;
				overflow-y: auto;
				position: fixed;
				top: 60px;
				left: 0;
				width: 16.6667%;
				background-color: #34495e;
				color: #ecf0f1;
				border-right: 1px solid #bdc3c7;
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

			/* Content Styles */
			.content {
				margin-left: 16.6667%;
			}
			.well {
				background-color: #ffffff;
				box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
			}
			.well h4 {
				color: #2c3e50; /* Dark color for headings */
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
				}
				.content {
					margin-left: 0;
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
		<div class="content">
			<div class="col-lg-12 well">
				<div class="alert alert-info">Book</div>
				<button id="add_book" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add new</button>
				<button id="show_book" type="button" style="display:none;" class="btn btn-success"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
				<br />
				<br />
				<div id="book_table">
					<table id="table" class="table table-bordered">
						<thead class="alert-success">
							<tr>
								<th>Book Title</th>
								<th>Category</th>
								<th>Author</th>
								<th>Date Published</th>
								<th>Available</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$qbook = $conn->query("SELECT * FROM `book`") or die(mysqli_error());
								while($fbook = $qbook->fetch_array()){
							?>
							<tr>
								<td><?php echo $fbook['book_title']?></td>
								<td><?php echo $fbook['book_category']?></td>
								<td><?php echo $fbook['book_author']?></td>
								<td><?php echo date("m-d-Y", strtotime($fbook['date_publish']))?></td>
								<td><?php echo $fbook['qty']?></td>
								<td>
									<a class="btn btn-danger delbook_id" value="<?php echo $fbook['book_id']?>"><span class="glyphicon glyphicon-remove"></span> Delete</a>
									<a value="<?php echo $fbook['book_id']?>" class="btn btn-warning ebook_id"><span class="glyphicon glyphicon-edit"></span> Edit</a>
								</td>
							</tr>
							<?php
								}
							?>
						</tbody>
					</table>
				</div>
				<div id="edit_form"></div>
				<div id="book_form" style="display:none;">
					<div class="col-lg-3"></div>
					<div class="col-lg-6">
						<form method="POST" action="save_book_query.php" enctype="multipart/form-data">
							<div class="form-group">
								<label>Book Title:</label>
								<input type="text" name="book_title" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Book Description:</label>
								<input type="text" name="book_desc" class="form-control" />
							</div>
							<div class="form-group">
								<label>Book Category:</label>
								<input type="text" name="book_category" class="form-control" required="required"/>
							</div>
							<div class="form-group">
								<label>Book Author:</label>
								<input type="text" name="book_author" class="form-control" required="required" />
							</div>
							<div class="form-group">
								<label>Date Published:</label>
								<input type="date" name="date_publish" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Quantity:</label>
								<input type="number" min="0" name="qty" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<button name="save_book" class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Submit</button>
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
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#add_book').click(function(){
					$(this).hide();
					$('#show_book').show();
					$('#book_table').slideUp();
					$('#book_form').slideDown();
					$('#show_book').click(function(){
						$(this).hide();
						$('#add_book').show();
						$('#book_table').slideDown();
						$('#book_form').slideUp();
					});
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$result = $('<center><label>Deleting...</label></center>');
				$('.delbook_id').click(function(){
					$book_id = $(this).attr('value');
					$(this).parents('td').empty().append($result);
					$('.delbook_id').attr('disabled', 'disabled');
					$('.ebook_id').attr('disabled', 'disabled');
					setTimeout(function(){
						window.location = 'delete_book.php?book_id=' + $book_id;
					}, 1000);
				});
				$('.ebook_id').click(function(){
					$book_id = $(this).attr('value');
					$('#show_book').show();
					$('#show_book').click(function(){
						$(this).hide();
						$('#edit_form').empty();
						$('#book_table').show();
						$('#book_admin').show();
					});
					$('#book_table').fadeOut();
					$('#add_book').hide();
					$('#edit_form').load('load_book.php?book_id=' + $book_id);
				});
			});
		</script>
	</body>
</html>
