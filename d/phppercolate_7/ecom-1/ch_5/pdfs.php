<?php
//pdfs.php
require('../includes_2/config.inc.php');

require(MYSQL);

$page_title = 'PDFs';
include('includes/header.html');
echo '<h1>PDF Guides</h1>';
//print message if user not active
if(isset($_SESSION['user_id'])  && !isset($_SESSION['user_not_expired']))
	{
		echo '<div class="alert"><h4>Expired Account</h4>Thank you for your interest in this content,
		but your account is no longer current.  Please <a href="##">renew your account</a> in order to 
		view any of the PDFs listed below.</div>';
	}elseif(!isset($_SESSION['user_id']))
	{
		echo '<div class="alert">Thank you for your interest in this content.  You must be logged in
		as a registerted user to view any of the PDFs listed below.</div>';
	}
	
	
	//grab the pdfs
	$q = 'SELECT tmp_name, title, description, size 
	      FROM pdfs
	      ORDER BY date_created DESC';
		  $r = mysqli_query($dbc, $q);
		  if(mysqli_num_rows($r) >0)
		  		{
		  			//grab and display all pdfs
		  			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
						{
							echo '<div><h4><a href="view_pdf.php?id='.htmlspecialchars($row['tmp_name']).'" target="blank">
							     '.htmlspecialchars($row['title']).' </a>('.$row['size'].'kb)</h4>
							     <p>'.htmlspecialchars($row['description']).'</p></div>';
						}

//complete the page
}else{
	//no pdfs
	echo '<div class="alert alert-danger">There are currently no PDFs available to view.
										Please check back again.</div>';
   }

include('includes/footer.html');
?>