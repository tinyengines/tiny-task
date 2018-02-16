<!DOCTYPE html>
<html lang="en-US" class="js"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<!--[if lt IE 9]>
	<script src="http://the102.sambwa.com/wp-content/themes/twentyfifteen/js/html5.js"></script>
	<![endif]-->
	<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
	<link rel="dns-prefetch" href="http://fonts.googleapis.com/">
	<link rel="dns-prefetch" href="http://s.w.org/">
	<link rel="stylesheet" id="twentyfifteen-fonts-css" href="./assets/fonts.css" type="text/css" media="all">
	<link rel="stylesheet" id="twentyfifteen-style-css" href="./assets/style.css" type="text/css" media="all">
	<script type="text/javascript" src="./assets/jquery.js.download"></script>
	<script type="text/javascript" src="./assets/jquery-migrate.min.js.download"></script>
	<meta name="generator" content="Tiny Task 0.1">
	<style>
	  .done {opacity: 0.3; color: #ddd !important;}
	  .done span {color: #ddd !important;}
	  .entry-content a {border-bottom: 0 !important;}
	</style>

	<?php
	/**    Returns the offset from the origin timezone to the remote timezone, in seconds.
	*    @param $remote_tz;
	*    @param $origin_tz; If null the servers current timezone is used as the origin.
	*    @return int;
	*/
	function get_timezone_offset($remote_tz, $origin_tz = null) {
	    if($origin_tz === null) {
	        if(!is_string($origin_tz = date_default_timezone_get())) {
	            return false; // A UTC timestamp was returned -- bail out!
	        }
	    }
	    $origin_dtz = new DateTimeZone($origin_tz);
	    $remote_dtz = new DateTimeZone($remote_tz);
	    $origin_dt = new DateTime("now", $origin_dtz);
	    $remote_dt = new DateTime("now", $remote_dtz);
	    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
	    return $offset;
	}
	?>

	<?php
		include('config.php');
	?>

<title><?php echo $tinytask_title; ?></title>


</head>
<body class="home blog logged-in wp-custom-logo">

<div id="page" class="hfeed site">

	<div id="sidebar" class="sidebar" style="position: fixed;">
		<header id="masthead" class="site-header" role="banner">
			<div class="site-branding">
				<img width="248" height="248" src="./assets/ttlogo.png" class="custom-logo" itemprop="logo" sizes="(max-width: 248px) 100vw, 248px">
			</div><!-- .site-branding -->
		</header><!-- .site-header -->
	</div><!-- .sidebar -->

	<div id="content" class="site-content">
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">			
				<article id="post-8" class="post-8 post type-post status-publish format-standard hentry category-uncategorized">
					
					<header class="entry-header"><h2 class="entry-title"></h2></header><!-- .entry-header -->

					<div class="entry-content">
						<p style="margin-bottom: 0px !important;">
							<?php echo $tinytask_introduction; ?><br/>
							<i style="font-size: 70%; position: relative; top: -12px; color: #aaa;">Email <a href= <?php echo "\"mailto:".$tinytask_email."\""; ?> ><?php echo $tinytask_email; ?></a> to submit task (the emails subject will be the task)</i>
							<div style="height: 15px;"></div>

							
							<!-- LOOP RESULTS HERE -->
							<?php 
							//Store Data in Database
							$con=mysqli_connect("localhost",<?php echo "\"".$tinytask_db_user."\""; ?>,<?php echo "\"".$tinytask_db_pass."\""; ?>,<?php echo "\"".$tinytask_db_name."\""; ?>);
							// Check connection
							if (mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

							// Perform queries 
							$results=mysqli_query($con,"SELECT * FROM Tasks ORDER BY Date DESC");
							while ($row_users = mysqli_fetch_array($results)) {
								$timestamp = strtotime($row_users['Date']);
								$dayNumber = date("z", $timestamp) + 1; 
								$offset = get_timezone_offset(<?php echo "'".$tinytask_timezone_server."'"; ?>, <?php echo "'".$tinytask_timezone_users."'"; ?>);
								$timestamp = $timestamp + $offset;
								$timeform = date("M d H:i", $timestamp);


							    //output a row here
							    if ($row_users['Completed'] == 1) {
							    	echo "<span class='done' id=outer".$row_users['ID'].">";
							    } else {
							    	echo "<span id=outer".$row_users['ID'].">";
							    }

							    echo "<span class='date' style='font-size: 100%; color: #aaa;'>". $timeform ."</span>&nbsp;&nbsp;<span class='message'>".($row_users['Label'])." </span>&nbsp;&nbsp;<span class='from' style='color: #aaa;'>". $row_users['From_Email'] ."</span>";
							    if ($row_users['Completed'] == 0) {
								    echo "<a href='javascript:void(0)' style='border: 0;' id=".$row_users['ID']." class='del'>&nbsp;&nbsp;<img src='./assets/complete.png' style='display: inline-block; width:20px;'></a>";
							    }  else {
								    echo "<a href='javascript:void(0)' style='border: 0;' id=".$row_users['ID']." class='remove'>&nbsp;&nbsp;<img src='./assets/delete.png' style='display: inline-block; width:20px;'></a>";
							    }
							    echo "</span><br/>";
							}
							mysqli_close($con);
							?>
							
						</p>
					</div><!-- .entry-content -->

					<footer class="entry-footer"></footer><!-- .entry-footer -->

				</article><!-- #post-## -->
			</main><!-- .site-main -->
		</div><!-- .content-area -->
	</div><!-- .site-content -->

</div><!-- .site -->
</body>
<script type="text/javascript">
/* <![CDATA[ */
var screenReaderText = {"expand":"<span class=\"screen-reader-text\">expand child menu<\/span>","collapse":"<span class=\"screen-reader-text\">collapse child menu<\/span>"};
/* ]]> */
</script>
<script type="text/javascript" src="./assets/functions.js.download"></script>
<script type="text/javascript">



jQuery(document).ready(function($){
	$(".del").live("click",function(){
		ajax("delete",$(this).attr("id"));
	});
 
	function ajax(action,id){
		if(action == "delete"){
			data = "id="+id;
		}
 
		$.ajax({
			type: "POST", 
			url: "./complete.php", 
			data : data,
			dataType: "json",
			success: function(response){
				var row_id = id;
				$("a[id='"+row_id+"']").fadeOut();
				$("span[id='outer"+row_id+"']").addClass('done');
			},
			error: function(res){
				//alert("Unexpected error! Try again.");
			}
		});
	}
});




</script>

</html>
