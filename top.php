<?php
include "library/conn.php";
include "library/global.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<link href="library/style.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>	
<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>

<img src="img_interface/logo.png" style="width:200px;height:100px;"/>
<a href="logout.php">
<div class="logout">Logout</div>
</a>

<div id="page-wrap">
   <ul class="dropdown" align="center">
   			<li><a href="mainmenu.php">Home</a>
        	</li>
        	<li><a href="#">Admin</a>
        		<ul class="sub_menu">		
                   <li><a href="list-user.php">User</a></li>                            
                   <li><a href="list-packages.php">Buy-Sale Packages</a></li>                            
                   <li><a href="update-nonactive.php">Nonactiving old Ads</a></li>                            
        		</ul>
        	</li>
			<li><a href="#">Master</a>
        		<ul class="sub_menu">				   
                   <li><a href="list-member.php">Member</a></li>	
				   <li><a href="list-slidemenu.php">Slide Menu</a></li>
				   <li><a href="list-pages.php">Page</a></li>
				   <li><a href="list-currency.php">Currency</a></li>
				   <li><a href="list-country.php">Country</a></li>
        		</ul>
        	</li>
        	<li><a href="#">World Trade Products</a>
        		<ul class="sub_menu">        		   
				   <li><a href="list-products.php">Products</a></li>
				   <li><a href="list-productspending.php">Products Pending</a></li>
				   <li><a href="list-category.php">Category Products</a></li>
                </ul>
        	</li>
        	<li><a href="#">Buy &amp; Sale Ads</a>
        		<ul class="sub_menu">
        			<li><a href="list-advertisement.php">Advertisements</a></li>
					<li><a href="list-advpending.php">Pending Advertisements</a></li>											
					<li><a href="list-promo.php">Advertisement Promo</a></li>
					<li><a href="list-advcategory.php">Category Advertisement</a></li>
					<li><a href="list-catfields.php">Category Advertisement Fields</a></li>
					<li>-</li>
					<li><a href="list-coinpurchase.php">List Coin Purchase</a></li>
					<li><a href="list-coinpurchaseconfirm.php">List Coin Purchase Confirmation</a></li>
        		</ul>
        	</li>
			<li><a href="#">S&amp;C</a>
        		<ul class="sub_menu">
        			<li><a href="list-snc.php">See Suggestions And Critics</a></li>
        		</ul>
        	</li>
            <li><a href="#">Reports</a>
        		<ul class="sub_menu">
        			<li><a href="list-productpending.php">View Unregistered Products</a></li>
                    <li><a href="list-productregistered.php">View Registered Products</a></li>
                    <li><a href="list-adpending.php">View Unregistered Ads</a></li>
                    <li><a href="list-adregistered.php">View Registered Ads</a></li>
                    <li><a href="">Gold Member Registration</a></li>
                    <li><a href="">Silver Member Registration</a></li>
        		</ul>
        	</li>        
        </ul>		
	</div>