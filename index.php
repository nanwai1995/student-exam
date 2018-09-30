<!DOCTYPE html>
<html>
<head>
	<title>Student Management System</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../js/bootstrap.min.js">
	<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
</head>
<body>

	<?php
	include ('dbconnection.php');
	if (isset($_POST["btnAdd"])) {
	 	$name=$_POST["txtName"];
	 	$roll=$_POST["txtRoll"];
	 	$html=$_POST["txtHtml"];
	 	$css=$_POST["txtCss"];
	 	$php=$_POST["txtPhp"];
	 	$total=$html+$css+$php;

	 	$sql="insert into student(name,roll,html,css,php) values('$name','$roll','$html','$css','$php')";
	 	$result=$con->query($sql);
	 	// if ($result) {
	 	// 	echo "<script>alert('Success')</script>";
	 	// }

	 }
	 if (isset($_POST["btnUpdate"])) {
	 	$id=$_POST["txtID"];
	 	$name=$_POST["txtName"];
	 	$roll=$_POST["txtRoll"];
	 	$html=$_POST["txtHtml"];
	 	$css=$_POST["txtCss"];
	 	$php=$_POST["txtPhp"];
	 	$total=$html+$css+$php;

	 	$sql="UPDATE student SET name='$name',roll='$roll',html='$html',css='$css',php='$php' WHERE id=".$id;
	 	$result=$con->query($sql);

	 }

	 if(isset($_POST["btnDelete"])) {

	$sql="delete from student where id=".$_POST["btnDelete"];
	$result=$con->query($sql);
	// if ($result) {
	// 	echo "<script>alert('Success')</script>";
	// }
}


	 ?>
<h1 class="text-info" style="text-align: center;font-weight: bold;">Student Exam Result</h1>
<div  class="container" style="width: 80%;border: 4px solid green;padding-bottom:20px;border-radius: 7px;">
<form name="frmStudent" method="post" action="#">


<?php

if (isset($_POST["btnEdit"])) {
	$sql="select * from student where id=".$_POST["btnEdit"];
	$result=$con->query($sql);
	if ($result) {
		$row=$result->fetch_object();

		echo '
		<div class="form-group">
		<div class="col-md-2">
		<label> &nbsp;</label>
		<input type="text" name="txtID" class="form-control" value="'.$row->id.'.">
		</div>
		<div class="col-md-4">
		<label>Student Name</label>
		<input type="text" name="txtName" class="form-control" value="'.$row->name.'">
		</div>
		<div class="col-md-6">
		<label>Roll</label>
		<input type="text" name="txtRoll" class="form-control" value="'.$row->roll.'">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<label>HTML</label>
			<input type="text" name="txtHtml" class="form-control" value="'.$row->html.'">
		</div>
		<div class="col-md-4">
			<label>CSS</label>
			<input type="text" name="txtCss" class="form-control" value="'.$row->css.'">
		</div>
		<div class="col-md-4">
			<label>PHP</label>
			<input type="text" name="txtPhp" class="form-control" value="'.$row->php.'">
		</div>
	</div>
	<div class="form-group">
		<input type="submit" name="btnUpdate" value="Update" class="btn btn-info" style="margin-top: 10px;width: 99%;height: 45px;">
	</div>


		';
	}
}else{
	echo '

<div class="form-group">
		<div class="col-md-6">
		<label>Student Name</label>
		<input type="text" name="txtName" class="form-control">
		</div>
		<div class="col-md-6">
		<label>Roll</label>
		<input type="text" name="txtRoll" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-4">
			<label>HTML</label>
			<input type="text" name="txtHtml" class="form-control">
		</div>
		<div class="col-md-4">
			<label>CSS</label>
			<input type="text" name="txtCss" class="form-control">
		</div>
		<div class="col-md-4">
			<label>PHP</label>
			<input type="text" name="txtPhp" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<input type="submit" name="btnAdd" value="Add" class="btn btn-success" style="margin-top: 10px;width: 99%;height: 45px;">
	</div>





	';
}

?>


<div class="pull-right">
	<input type="text" name="search" class="form-control" style="width: auto;display: inline-block;">
	<input type="submit" name="btnSearch" class="btn btn-default" value="Search">
</div>
<div class="clearfix"></div>
<br>



	<table class="table table-bordered">
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Roll-No.</th>
			<th>HTML</th>
			<th>CSS</th>
			<th>PHP</th>
			<th>Total</th>
			<th>Action</th>
		</tr>

		<?php

		$limit = 5;

		if (isset($_POST["btnSearch"])) {
			$name=$_POST['search'];
			$total_pages_sql="select count(*) from student where name='$name'";
		}else{
			$total_pages_sql="select count(*) from student";
		}
		$res=mysqli_query($con,$total_pages_sql);
		$total_items=mysqli_fetch_array($res)[0];
		$pages=ceil($total_items/$limit);

		//What page are we currently on?
		$page=min($pages,
			filter_input(INPUT_GET,'page',
				FILTER_VALIDATE_INT,array(
						'options'=>array(
							'default'=>1,
							'min_range'=>1,
						),
					)));

		//Calulate the offset for the query
		$offset =($page-1) * $limit;

		//Some information to display to the user
		$start = $offset + 1;
		$end = min(($offset + $limit),$total_items);

		//the back link
		$prevlink = ($page > 1) ?
		'<a href="?page=1" title="First page">&lsaquo; </a>
		<a href="?page='.($page-1).'" title="Previous page">&lsaquo; </a>' :
		'<span class="disabled">&lsaquo;</span>
		<span class="disabled">&lsaquo;</span>';


		//The "forward" link
		$nextlink = ($page < $pages) ?

		'<a href="?page='.($page+1).'" title="Next page">&rsaquo; </a>
		<a href="?page='.$pages.'" title="Last page">&rsaquo; </a>' :
		'<span class="disabled">&rsaquo;</span>
		<span class="disabled">&rsaquo;</span>';

		//Display the paging information
		// echo '<div id="paging"><p>',
		// $prevlink,'Page',$page,'of',$pages,
		// 'pages,displaying',$start,'-',$end,
		// 'of',$total_items,'result',$nextlink,'</p></div>';


		if (isset($_POST["btnSearch"])) {
		 	$name=$_POST['search'];

		 	$sql="select * from student where name='$name'";
		 	$result=$con->query($sql);
		}else{
			$sql="select * from student LIMIT".$limit."OFFSET".$offset;
			$result=$con->query($sql);
		}

		while ($row=$result->fetch_object()) {
			$total=$row->html+$row->css+$row->php;
			echo '<tr>
				<td>'.$row->id.'.</td>
				<td>'.$row->name.'</td>
				<td>'.$row->roll.'</td>
				<td>'.$row->html.'</td>
				<td>'.$row->css.'</td>
				<td>'.$row->php.'</td>
				<td>'.$total.'</td>
				<td>
				<button type="submit" name="btnEdit" class="btn btn-primary" value='.$row->id.'> Edit </button>
				<button type="submit" name="btnDelete" class="btn btn-danger" value='.$row->id.'> Delete </button>
				</td>
			';
		}

		echo '</table>';
		echo '<nav aria-label="Page navigation">
		        <ul class="pagination">
		        <li>
		        	'.$prevlink.'
		        </li>';

		        for ($i=1;$i<$pages+1;$i++){
		        	echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
		        }
		        echo '<li>
		        			'.$nextlink.'
		        		</li>
		        </ul>
		      </nav>';

		 ?>
	</table>
</form>
</div>
</body>
</html>
