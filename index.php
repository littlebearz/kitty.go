<?php
session_start();
include('database.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="compares fule efficency of car models in Canada">

<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure.css">
        <link rel="stylesheet" href="css/layouts/email.css">
	<style type="text/css">
canvas{
width:100% !important;
max-width:800px;
height:auto !important;
}
.searchQ
	{
	color: #000;
	background: #ffa20f;
border: 2px outset #d7b9c9
pure-button pure-button-primary
} 
	</style>
<script src="/lib/chart/Chart.js"></script>
</head>
<body>
<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
        <a href="#" class="nav-menu-button">Search</a>

        <div class="nav-inner">
			<div class="pure-menu pure-menu-open">
			<form action="index.php" method="post" class="pure-form pure-form-stacked"> 
				<a class="pure-menu-heading" href="/">Kitty Fuel</a>
				<input type="text" name="carSearch" maxlength="10" placeholder="Make" class="pure-u-4-5 pure-input-rounded"> 
				<input type="text" name="year" maxlength="4" placeholder="Year" class="pure-u-4-5 pure-input-rounded">
				<input type="submit" value="Search" class="pure-button pure-button-primary pure-u-4-5">
			</form>
			<?php
			/*
				<ul> 
				<li><a href="#"> $carName= $_POST['carSearch']; echo $carName;?><span class="email-count"></a></li>
				<ul>
			*/
			?>
			</div>
        </div>
    </div>

    <div id="list" class="pure-u-1">

		<div class="email-item email-item-selected">
		<?php
		$carName= strtoupper($_REQUEST['carSearch']); 
		$year=trim($_REQUEST['year']);

		$database=new DB;
		if ($carName=="")
		{
		$sqlSelect = "SELECT DISTINCT BINARY(manufacturer) id,manufacturer, model, year FROM `fueldata` order by manufacturer limit 0,15;";
		
		}
		if (($carName=="")AND($year!=""))
		{
		$sqlSelect = "SELECT id,manufacturer, model, year FROM `fueldata` WHERE `year` = '$year' limit 0,15;";
		}

		if (($carName!="")AND($year!=""))
		{
		$sqlSelect = "SELECT id,manufacturer, model, year FROM `fueldata` WHERE `manufacturer` like '%$carName%' and `year` = '$year' limit 0,20;";
		}
		$data = $database->getQuery($sqlSelect); // This will run the SQL statment and return and associative array.
			foreach($data as $d)
			{
			echo "<div class=email-subject>";
			echo "<h4 class=email-name>".$d['manufacturer']." | ".$d['model']." | ".$d['year']."</h4>";
			echo "<a href=./index.php?carSearch=";
			echo $d['manufacturer'];
			echo "&mod=";
			echo $d['model'];
			echo "&yer=";
			echo $d['year']."&k1=";
			echo $d['id'];
			echo ">";
			echo "<img src=green.png>";	
			echo "</a> | ";
			
			echo "<a href=./index.php?carSearch=";
			echo $d['manufacturer'];
			echo "&mod=";
			echo $d['model'];
			echo "&yer=";
			echo $d['year']."&k2=";
			echo $d['id'];
			echo ">";
			echo "<img src=yellow.png>";	
			echo "</a> | ";
			
			echo "<a href=./index.php?carSearch=";
			echo $d['manufacturer'];
			echo "&mod=";
			echo $d['model'];
			echo "&yer=";
			echo $d['year']."&k3=";
			echo $d['id'];
			echo ">";
			echo "<img src=red.png>";	
			echo "</a>";
			echo "</div>";
			}
		
		?>
		</div>

    </div>
<?php
$k1=trim($_REQUEST['k1']);
$k2=trim($_REQUEST['k2']);
$k3=trim($_REQUEST['k3']);
	if ($k1!=null)
		{
			$sqlSelect = "SELECT * FROM `fueldata` WHERE `id` = '$k1';";
			$data = $database->getQuery($sqlSelect); // This will run the SQL statment and return and associative array.
						foreach($data as $d)
				{
				$_SESSION['k1']['cityL']=$d['cityL'];
				$_SESSION['k1']['hwyL']=$d['hwyL'];
				$_SESSION['k1']['manufacturer']=$d['manufacturer'];
				$_SESSION['k1']['model']=$d['model'];
				$_SESSION['k1']['id']=$d['id'];
				}
		}
	if ($k2!=null)
		{
			$sqlSelect = "SELECT * FROM `fueldata` WHERE `id` = '$k2';";
			$data = $database->getQuery($sqlSelect); // This will run the SQL statment and return and associative array.
						foreach($data as $d)
				{
				$_SESSION['k2']['cityL']=$d['cityL'];
				$_SESSION['k2']['hwyL']=$d['hwyL'];
				$_SESSION['k2']['manufacturer']=$d['manufacturer'];
				$_SESSION['k2']['model']=$d['model'];
				$_SESSION['k2']['id']=$d['id'];
				}
		}
	if ($k3!=null)
		{
			$sqlSelect = "SELECT * FROM `fueldata` WHERE `id` = '$k3';";
			$data = $database->getQuery($sqlSelect); // This will run the SQL statment and return and associative array.
						foreach($data as $d)
				{
				$_SESSION['k3']['cityL']=$d['cityL'];
				$_SESSION['k3']['hwyL']=$d['hwyL'];
				$_SESSION['k3']['manufacturer']=$d['manufacturer'];
				$_SESSION['k3']['model']=$d['model'];
				$_SESSION['k3']['id']=$d['id'];
				}
		}
?>
    <div id="main" class="pure-u-1">
        <div class="email-content">
            <div class="email-content-header pure-g">
                <div class="pure-u-1-2">
                    <h1 class="email-content-title">Fuel Consumption Comparison for Vehicles</h1>
                    <p class="email-content-subtitle">
                        Generated by <a><?php echo $_SERVER['REQUEST_TIME_FLOAT'];?></a> at <span style="width:55%;"><?php echo date('r');?></span>
                    </p>	
                </div>

                <div class="email-content-controls pure-u-1-2">
					<p>Grey field is city litre per 100Km</p>
					<p>Blue field is highway litre per 100Km</p>
					<!--
                    <button class="secondary-button pure-button">Meow</button>
                    <button class="secondary-button pure-button">Meow</button>
                    <button class="secondary-button pure-button">Meow</button>
					-->
                </div>
            </div>

            <div class="email-content-body">
				<canvas id="myChart" width="640" height="420"></canvas>
	<script>

		var barChartData = {
			labels : ["<?php echo $_SESSION['k1']['manufacturer'].' '.$_SESSION['k1']['model'];?>","<?php echo $_SESSION['k2']['manufacturer'].' '.$_SESSION['k2']['model'];?>","<?php echo $_SESSION['k3']['manufacturer'].' '.$_SESSION['k3']['model'];?>"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					data : [<?php echo $_SESSION['k1']['cityL'];?>,<?php echo $_SESSION['k2']['cityL'];?>,<?php echo $_SESSION['k3']['cityL'];?>]
				},
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					data : [<?php echo $_SESSION['k1']['hwyL'];?>,<?php echo $_SESSION['k2']['hwyL'];?>,<?php echo $_SESSION['k3']['hwyL'];?>]
				}
			]
			
		}

	var myLine = new Chart(document.getElementById("myChart").getContext("2d")).Bar(barChartData);
	
	</script>
			 <div class="pure-g">
		<h4 class=pure-u-1-1>Vehicle ID</h4>
        <div class="pure-u-1-3">
            <!--
            By default, grid units don't have any margin/padding.
            If you want to add these, put them in a child container.
            -->
            <p><?php echo $_SESSION['k1']['id'];?></p>
			<p><?php
				echo $_SESSION['k1']['cityL']." litre/100Km in the city.</br>";
				echo $_SESSION['k1']['hwyL']." litre/100Km on the highway.";
				?>
			</p>
        </div>

        <div class="pure-u-1-3">
            <p><?php echo $_SESSION['k2']['id'];?></p>
						<p><?php
				echo $_SESSION['k2']['cityL']." litre/100Km in the city.</br>";
				echo $_SESSION['k2']['hwyL']." litre/100Km on the highway.";
				?>
			</p>
        </div>

        <div class="pure-u-1-3">
            <p><?php echo $_SESSION['k3']['id'];?></p>
						<p><?php
				echo $_SESSION['k3']['cityL']." litre/100Km in the city.</br>";
				echo $_SESSION['k3']['hwyL']." litre/100Km on the highway.";
				?>
			</p>
        </div>
    </div>
			<?php 
			$city_consumption=[
						$_SESSION['k1']['model']=>$_SESSION['k1']['cityL'],
						$_SESSION['k2']['model']=>$_SESSION['k2']['cityL'],
						$_SESSION['k3']['model']=>$_SESSION['k3']['cityL']
							];
			$hwy_consumption=[
						$_SESSION['k1']['model']=>$_SESSION['k1']['hwyL'],
						$_SESSION['k2']['model']=>$_SESSION['k2']['hwyL'],
						$_SESSION['k3']['model']=>$_SESSION['k3']['hwyL']
							];	
			asort($city_consumption);
			foreach ($city_consumption as $key => $val) {
				$personalized_message=$key." has the best city fuel consumption:".$val."/100km";
				break;
			}
			asort($hwy_consumption);
			foreach ($hwy_consumption as $key => $val) {
				$hc[$key]=$val;
				$personalized_message.=$key." has the best hwy fuel consumption:".$val."/100km";
				break;
			}
			include('personalize.php');?>
            </div>
        </div>
		
</div>

<script src="http://yui.yahooapis.com/3.14.1/build/yui/yui.js"></script>
<script>
    YUI().use('node-base', 'node-event-delegate', function (Y) {

        var menuButton = Y.one('.nav-menu-button'),
            nav        = Y.one('#nav');

        // Setting the active class name expands the menu vertically on small screens.
        menuButton.on('click', function (e) {
            nav.toggleClass('active');
        });

        // Your application code goes here...

    });
</script>

<script>
YUI().use('node-base', 'node-event-delegate', function (Y) {
    // This just makes sure that the href="#" attached to the <a> elements
    // don't scroll you back up the page.
    Y.one('body').delegate('click', function (e) {
        e.preventDefault();
    }, 'a[href="#"]');
});
</script>
</body>
</html>
