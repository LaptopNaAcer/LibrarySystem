<!DOCTYPE html>
<?php
	require_once 'valid.php';

	require('../../libs/fpdf.php');  // Include FPDF library

	try {
		$db = getDbConnection();

		// Fetch today's borrow and return counts
		$today = date('Y-m-d');
		$stmtBorrowed = $db->prepare("SELECT COUNT(*) as borrowed_books FROM borrow WHERE date_borrow = :today");
		$stmtBorrowed->bindParam(':today', $today);
		$stmtBorrowed->execute();
		$borrowedBooks = $stmtBorrowed->fetch(PDO::FETCH_ASSOC)['borrowed_books'];

		$stmtReturned = $db->prepare("SELECT COUNT(*) as returned_books FROM returns WHERE date_return = :today");
		$stmtReturned->bindParam(':today', $today);
		$stmtReturned->execute();
		$returnedBooks = $stmtReturned->fetch(PDO::FETCH_ASSOC)['returned_books'];

	} catch (PDOException $e) {
		die("Database error: " . $e->getMessage());
	}

	if (isset($_POST['generate_report'])) {
		// Generate PDF when the button is clicked
		$pdf = new FPDF();
		$pdf->AddPage();
		
		// Set font
		$pdf->SetFont('Arial', 'B', 16);
		
		// Title
		$pdf->Cell(200, 10, 'Library Borrow and Return Report', 0, 1, 'C');
		$pdf->Ln(10);
		
		// Borrowed Books
		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(100, 10, "Books Borrowed Today: " . $borrowedBooks, 0, 1);
		
		// Returned Books
		$pdf->Cell(100, 10, "Books Returned Today: " . $returnedBooks, 0, 1);
		
		// Output PDF
		$pdf->Output('D', 'BorrowReturnReport_' . $today . '.pdf');
		exit;
	}
?>	
<html lang = "eng">
	<head>
		<title>Library System</title>
		<meta charset = "utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="../../assets/CSS/report.css">
		<link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css" />
		<style>
			body {
				background-color: #ffaa00;
				padding-top: 60px; /* Account for fixed navbar */
			}
			.sidebar {
				height: 100vh;
				overflow-y: auto;
				position: fixed;
				top: 60px;
				left: 0;
				background-color: #fff;
				border-right: 1px solid #d3d3d3;
				width: 16.6667%; /* Matches col-lg-2 */
			}
			.content {
				margin-left: 16.6667%; /* Matches sidebar width */
			}
			.sidebar .well {
				margin: 0;
				background-color: #f5f5f5;
				border: none;
			}
		</style>
	</head>
	<body>
		<!-- Top Navbar -->
		<nav class = "navbar navbar-default navbar-fixed-top">
			<div class = "container-fluid">
				<div class = "navbar-header">
					<img src = "images/logo.png" width = "50px" height = "50px" />
					<h4 class = "navbar-text navbar-right">Library System</h4>
				</div>
			</div>
		</nav>
		
		<!-- Sidebar -->
		<div class="sidebar well">
			<div class="container-fluid text-center">
				<img src = "images/user.png" width = "50px" height = "50px"/>
				<br />
				<br />
				<label class = "text-muted"><?php require 'account.php'; echo $name; ?></label>
			</div>
			<hr style = "border:1px dotted #d3d3d3;" />
			<ul id = "menu" class = "nav menu">
				<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = "home.php"><i class = "glyphicon glyphicon-home"></i> Home</a></li>
				<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-tasks"></i> Accounts</a>
					<ul style = "list-style-type:none;">
						<li><a href = "admin.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-user"></i> Admin</a></li>
						<li><a href = "student.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-user"></i> Student</a></li>
					</ul>
				</li>
				<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = "book.php"><i class = "glyphicon glyphicon-book"></i> Books</a></li>
				<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-th"></i> Transaction</a>
					<ul style = "list-style-type:none;">
						<li><a href = "borrowing.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Borrowing</a></li>
						<li><a href = "returning.php" style = "font-size:15px;"><i class = "glyphicon glyphicon-random"></i> Returning</a></li>
					</ul>
				</li>
				<li><a style = "font-size:18px; border-bottom:1px solid #d3d3d3;" href = ""><i class = "glyphicon glyphicon-cog"></i> Settings</a>
					<ul style = "list-style-type:none;">
						<li><a style = "font-size:15px;" href = "logout.php"><i class = "glyphicon glyphicon-log-out"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>

		<!-- Main Content -->
		<div class="content">
			<div class="col-lg-12 well">
				<div class="main-content">
				<h3>Books Borrowed and Returned Today</h3>
				<p>Books Borrowed Today: <?php echo $borrowedBooks; ?></p>
				<p>Books Returned Today: <?php echo $returnedBooks; ?></p>
				
				<!-- Button to generate the PDF report -->
				<form method="POST" action="reports.php">
					<button type="submit" name="generate_report" id="reportbtn">Generate PDF Report</button>
				</form>
        		</div>
			</div>
		</div>

		<!-- Footer -->
		<nav class = "navbar navbar-default navbar-fixed-bottom">
			<div class = "container-fluid">
				<label class = "navbar-text pull-right">Library System &copy; All rights reserved 2016</label>
			</div>
		</nav>
		
		<script src = "js/jquery.js"></script>
		<script src = "js/bootstrap.js"></script>
		<script src = "js/login.js"></script>
		<script src = "js/sidebar.js"></script>
	</body>
</html>
