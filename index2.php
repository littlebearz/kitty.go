<?php
session_start();
include('database.php');

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="compares the fule ecnomny of car models sold in Canada">

<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.4.2/pure.css">
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/email-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="css/layouts/email.css">
    <!--<![endif]-->
	<!--consider removing this entierly if we don't end up using custom CSS
	<style type="text/css">
.searchQ
	{
	color: #000;
	background: #ffa20f;
border: 2px outset #d7b9c9
pure-button pure-button-primary
} 
	</style>
	-->
</head>
<body>
<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
		
        <a href="#" class="nav-menu-button">Search</a>

        <div class="nav-inner">
            <!-- <button class="primary-button pure-button">Compose</button>

            <div class="pure-menu pure-menu-open">
                <ul>
                    <li><a href="#">Inbox <span class="email-count">(2)</span></a></li>
                    <li><a href="#">Important</a></li>
                    <li><a href="#">Sent</a></li>
                    <li><a href="#">Drafts</a></li>
                    <li><a href="#">Trash</a></li>
                    <li class="pure-menu-heading">Labels</li>
                    <li><a href="#"><span class="email-label-personal"></span>Personal</a></li>
                    <li><a href="#"><span class="email-label-work"></span>Work</a></li>
                    <li><a href="#"><span class="email-label-travel"></span>Travel</a></li>
                </ul>
            </div>
			-->
			<div class="pure-menu pure-menu-open">
			<!--INDEX2.PHP 1/3-->
			<form action="index2.php" method="post" class="pure-form pure-form-stacked"> 
				<!--INDEX2.PHP  -->
				<a class="pure-menu-heading" href="index2.php">Kitty Fuel</a>
				<input type="text" name="carSearch" maxlength="10" placeholder="Make" class="pure-u-4-5 pure-input-rounded"> 
				<input type="text" name="yearSearch" maxlength="4" placeholder="Year" class="pure-u-4-5 pure-input-rounded">
				<input type="submit" value="Search" class="pure-button pure-button-primary pure-u-4-5">
			</form>
			</div>
        </div>
    </div>

    <div id="list" class="pure-u-1">
		<h4 class="email-subject">Selected Cars:</h4>

		<?php	
		//initialize and increment counter 
			if ( $_SESSION['j']==null) {$_SESSION['j']=1;}

		//for testing	echo "<p> "+$_SESSION['j']+" </p> <br>";
		//store & display last 3 selected results 

		if ($_REQUEST['mod'] != null){ 
		
			if ($_SESSION['mod1']==null) {
				$_SESSION['mod1']=$_REQUEST['carSearch']." ".str_replace("%"," ",$_REQUEST['mod'])." ".$_REQUEST['yer'];
			}
		
			$mod2 = $_REQUEST['carSearch']." ".str_replace("%"," ",$_REQUEST['mod'])." ".$_REQUEST['yer'];
			
			if ($_SESSION['mod1']!= $mod2){
			$_SESSION['j']=$_SESSION['j']+1;
			$_SESSION['mod1'] = $mod2;
			}
			/**for testing
			echo"<br>";
			echo $_SESSION['mod1'];
			echo"<br>";
			echo $mod2;*/
			if ($_SESSION['j']>3) {$_SESSION['j']=1;}
			
			if ($_SESSION['j']==1){$_SESSION['k1'] = $_REQUEST['carSearch']." ".str_replace("%"," ",$_REQUEST['mod'])." ".$_REQUEST['yer'];}
			if ($_SESSION['j']==2){$_SESSION['k2'] = $_REQUEST['carSearch']." ".str_replace("%"," ",$_REQUEST['mod'])." ".$_REQUEST['yer'];}
			if ($_SESSION['j']==3){$_SESSION['k3'] = $_REQUEST['carSearch']." ".str_replace("%"," ",$_REQUEST['mod'])." ".$_REQUEST['yer'];}			
		}
			if ($_SESSION['k1']!=null){
				echo "<div class='email-item email-item-selected2 pure-g'>";
				echo "<div class='pure-u-3-4'>";
				echo "<h5 class='email-name'>";
				echo "<a href=";
				echo ">";
				echo $_SESSION['k1'];
				echo "</a>";
				echo "</h5>";
				echo "</div>";
				echo "</div>";
				}

			if ($_SESSION['k2']!=null){
				echo "<div class='email-item email-item-selected2 pure-g'>";
				echo "<div class='pure-u-3-4'>";
				echo "<h5 class='email-name'>";
				echo "<a href=";
				echo ">";
				echo $_SESSION['k2'];
				echo "</a>";
				echo "</h5>";
				echo "</div>";
				echo "</div>";
			}
			
			if ($_SESSION['k3']!=null){
				$k3 = $_REQUEST['mod']; 
				echo "<div class='email-item email-item-selected2 pure-g'>";
				echo "<div class='pure-u-3-4'>";
				echo "<h5 class='email-name'>";
				echo "<a href=";
				echo ">";
				echo $_SESSION['k3'];
				echo "</a>";
				echo "</h5>";
				echo "</div>";
				echo "</div>";
			}
		
		?>
		
		<?php
		//This is where the user searched car is queyed and displayed 
		$carName= strtoupper($_REQUEST['carSearch']);
		if ($carName!=null)
		{
		echo "<h5 class='email-name'>Found cars:</h5>";
		$database=new DB;
		/**NOTE: IF YOU SAY year LIKE "%$year%" and the user inputs 2013, the query will output all the years including years 2000-2014 
		 *		 I tried to fix this by saying year = '$year' but that outputs nothing */
		$sqlSelect = "SELECT manufacturer, model, year FROM `fueldata` WHERE manufacturer like '%$carName%' and year like '%$year%';";
		$data = $database->getQuery($sqlSelect); // This will run the SQL statment and return and associative array.
			foreach($data as $d)
			{
			echo "<div class='email-item email-item-unread pure-g'>";
			echo "<div class='pure-u-3-4'>";
			echo "<h5 class='email-name'>";
			//INDEX2.PHP
			echo "<a href=./index2.php?carSearch=";
			echo str_replace(" ","%",$d['manufacturer']);
			echo "&mod=";
			echo str_replace(" ","%",$d['model']);
			echo "&yer=";
			echo str_replace(" ","%",$d['year']);
			echo "&c=";
			echo $_SESSION['j'];
			echo ">";
	
			echo $d['manufacturer'];
			echo " &nbsp;";
			echo $d['model'];
			echo " &nbsp; ";
			echo $d['year'];
			
			echo "</a>";
			echo "</h5>";
			echo "</div>";
			echo "</div>";
			}
		}
		?>

		<!--
        <div class="email-item email-item-selected pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Tilo Mitra&#x27;s avatar" height="64" width="64" src="img/common/tilo-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Tilo Mitra</h5>
                <h4 class="email-subject">Hello from Toronto</h4>
                <p class="email-desc">
                    Hey, I just wanted to check in with you from Toronto. I got here earlier today.
                </p>
            </div>
        </div>

        <div class="email-item email-item-unread pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Eric Ferraiuolo&#x27;s avatar" height="64" width="64" src="img/common/ericf-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Eric Ferraiuolo</h5>
                <h4 class="email-subject">Re: Pull Requests</h4>
                <p class="email-desc">
                    Hey, I had some feedback for pull request #51. We should center the menu so it looks better on mobile.
                </p>
            </div>
        </div>

        <div class="email-item email-item-unread pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="YUI&#x27;s avatar" height="64" width="64" src="img/common/yui-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">YUI Library</h5>
                <h4 class="email-subject">You have 5 bugs assigned to you</h4>
                <p class="email-desc">
                    Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Reid Burke&#x27;s avatar" height="64" width="64" src="img/common/reid-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Reid Burke</h5>
                <h4 class="email-subject">Re: Design Language</h4>
                <p class="email-desc">
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Andrew Wooldridge&#x27;s avatar" height="64" width="64" src="img/common/andrew-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Andrew Wooldridge</h5>
                <h4 class="email-subject">YUI Blog Updates?</h4>
                <p class="email-desc">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Yahoo! Finance&#x27;s Avatar" height="64" width="64" src="img/common/yfinance-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Yahoo! Finance</h5>
                <h4 class="email-subject">How to protect your finances from winter storms</h4>
                <p class="email-desc">
                    Mauris tempor mi vitae sem aliquet pharetra. Fusce in dui purus, nec malesuada mauris.
                </p>
            </div>
        </div>

        <div class="email-item pure-g">
            <div class="pure-u">
                <img class="email-avatar" alt="Yahoo! News&#x27; avatar" height="64" width="64" src="img/common/ynews-avatar.png">
            </div>

            <div class="pure-u-3-4">
                <h5 class="email-name">Yahoo! News</h5>
                <h4 class="email-subject">Summary for April 3rd, 2012</h4>
                <p class="email-desc">
                    We found 10 news articles that you may like.
                </p>
            </div>
        </div>
		-->
    </div>

    <div id="main" class="pure-u-1">
        <div class="email-content">
            <div class="email-content-header pure-g">
                <div class="pure-u-1-2">
                    <h1 class="email-content-title">Hello from Toronto</h1>
                    <p class="email-content-subtitle">
                        From <a>Tilo Mitra</a> at <span>3:56pm, April 3, 2012</span>
                    </p>
                </div>

                <div class="email-content-controls pure-u-1-2">
                    <button class="secondary-button pure-button">Reply</button>
                    <button class="secondary-button pure-button">Forward</button>
                    <button class="secondary-button pure-button">Move to</button>
                </div>
            </div>

            <div class="email-content-body">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <p>
                    Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
                <p>
                    Aliquam ac feugiat dolor. Proin mattis massa sit amet enim iaculis tincidunt. Mauris tempor mi vitae sem aliquet pharetra. Fusce in dui purus, nec malesuada mauris. Curabitur ornare arcu quis mi blandit laoreet. Vivamus imperdiet fermentum mauris, ac posuere urna tempor at. Duis pellentesque justo ac sapien aliquet egestas. Morbi enim mi, porta eget ullamcorper at, pharetra id lorem.
                </p>
                <p>
                    Donec sagittis dolor ut quam pharetra pretium varius in nibh. Suspendisse potenti. Donec imperdiet, velit vel adipiscing bibendum, leo eros tristique augue, eu rutrum lacus sapien vel quam. Nam orci arcu, luctus quis vestibulum ut, ullamcorper ut enim. Morbi semper erat quis orci aliquet condimentum. Nam interdum mauris sed massa dignissim rhoncus.
                </p>
                <p>
                    Regards,<br>
                    Tilo
                </p>
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
