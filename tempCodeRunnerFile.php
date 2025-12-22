<?php
session_start();
error_reporting(0);
include("include/config.php");
if(isset($_POST['submit']))
{
$username=$_POST['username'];
$password=md5($_POST['password']);
$ret=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($ret);
if($num>0)
{
$extra="change-password.php";//
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
$extra="index.php";
$host = $_SERVER['HTTP_HOST'];
$uri = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
17
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home Service | Admin login</title>
<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link type="text/css" href="css/theme.css" rel="stylesheet">
<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
</head>
<body>
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
<i class="icon-reorder shaded"></i>
</a>
<a class="brand" href="index.html">
Home Service | Admin
</a>
18
<div class="nav-collapse collapse navbar-inverse-collapse">
<ul class="nav pull-right">
<li><a href="http://localhost/shopping/">
Back to Portal
</a></li>
</ul>
</div><!-- /.nav-collapse -->
</div>
</div><!-- /navbar-inner -->
</div><!-- /navbar -->
<div class="wrapper">
<div class="container">
<div class="row">
<div class="module module-login span4 offset4">
<form class="form-vertical" method="post">
<div class="module-head">
<h3>Sign In</h3>
</div>
19
<span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
<div class="module-body">
<div class="control-group">
<div class="controls row-fluid">
<input class="span12" type="text" id="inputEmail" name="username" placeholder="Username">
</div>
</div>
<div class="control-group">
<div class="controls row-fluid">
<input class="span12" type="password" id="inputPassword" name="password" placeholder="Password">
</div>
</div>
</div>
<div class="module-foot">
<div class="control-group">
<div class="controls clearfix">
<button type="submit" class="btn btn-primary pull-right" name="submit">Login</button>
</div>
</div>
20
</div>
</form>
</div>
</div>
</div>
</div><!--/.wrapper-->
<div class="footer">
<div class="container">
<b class="copyright">&copy; SRM University </b> Adarsh Khati 20IT103003
</div>
</div>
<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>
6.2 Code for Category
<?php
session_start();
error_reporting(0);
include('includes/config.php');
$cid=intval($_GET['cid']);
if(isset($_GET['action']) && $_GET['action']=="add"){
$id=intval($_GET['id']);
if(isset($_SESSION['cart'][$id])){
$_SESSION['cart'][$id]['quantity']++;
21
}else{
$sql_p="SELECT * FROM products WHERE id={$id}";
$query_p=mysqli_query($con,$sql_p);
if(mysqli_num_rows($query_p)!=0){
$row_p=mysqli_fetch_array($query_p);
$_SESSION['cart'][$row_p['id']]=array("quantity" => 1, "price" => $row_p['productPrice']);
echo "<script>alert('Product has been added to the cart')</script>";
echo "<script type='text/javascript'> document.location ='my-cart.php'; </script>";
}else{
$message="Product ID is invalid";
}
}
}
// COde for Wishlist
if(isset($_GET['pid']) && $_GET['action']=="wishlist" ){
if(strlen($_SESSION['login'])==0)
{
header('location:login.php');
}
else
{
mysqli_query($con,"insert into wishlist(userId,productId) values('".$_SESSION['id']."','".$_GET['pid']."')");
echo "<script>alert('Product aaded in wishlist');</script>";
header('location:my-wishlist.php');
}
}
?>
<!DOCTYPE html>
22
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keywords" content="MediaCenter, Template, eCommerce">
<meta name="robots" content="all">
<title>Product Category</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<!-- Customizable CSS -->
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/purplee.css">
<link rel="stylesheet" href="assets/css/owl.carousel.css">
<link rel="stylesheet" href="assets/css/owl.transitions.css">
<!--<link rel="stylesheet" href="assets/css/owl.theme.css">-->
<link href="assets/css/lightbox.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/animate.min.css">
<link rel="stylesheet" href="assets/css/rateit.css">
<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
<!-- Demo Purpose Only. Should be removed in production -->
<link rel="stylesheet" href="assets/css/config.css">
23
<link href="assets/css/purplee.css" rel="alternate stylesheet" title="Purple color">
<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
<!-- Demo Purpose Only. Should be removed in production : END -->
<!-- Icons/Glyphs -->
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<!-- Fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
<!-- Favicon -->
<link rel="shortcut icon" href="images/logoo.png">
<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
<!--[if lt IE 9]>
<script src="assets/js/html5shiv.js"></script>
<script src="assets/js/respond.min.js"></script>
<![endif]-->
</head>
<body class="cnt-home">
24
<header class="header-style-1">
<!-- ============================================== TOP MENU ============================================== -->
<?php include('includes/top-header.php');?>
<!-- ============================================== TOP MENU : END ============================================== -->
<?php include('includes/main-header.php');?>
<!-- ============================================== NAVBAR ============================================== -->
<?php include('includes/menu-bar.php');?>
<!-- ============================================== NAVBAR : END ============================================== -->
</header>
<!-- ============================================== HEADER : END ============================================== -->
</div><!-- /.breadcrumb -->
<div class="body-content outer-top-xs">
<div class='container'>
<div class='row outer-bottom-sm'>
<div class='col-md-3 sidebar'>
<!-- ================================== TOP NAVIGATION ================================== -->
<div class="side-menu animate-dropdown outer-bottom-xs">
<div class="side-menu animate-dropdown outer-bottom-xs">
<div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categories</div>
25
<nav class="yamm megamenu-horizontal" role="navigation">
<ul class="nav">
<li class="dropdown menu-item">
<?php $sql=mysqli_query($con,"select id,subcategory from subcategory where categoryid='$cid'");
while($row=mysqli_fetch_array($sql))
{
?>
<a href="sub-category.php?scid=<?php echo $row['id'];?>" class="dropdown-toggle"><i class="icon fa fa-store fa-fw"></i>
<?php echo $row['subcategory'];?></a>
<?php }?>
</li>
</ul>
</nav>
</div>
</div><!-- /.side-menu -->
<!-- ================================== TOP NAVIGATION : END ================================== --> <div class="sidebar-module-container">
<h3 class="section-title">shop by</h3>
<div class="sidebar-filter">
<!-- ============================================== SIDEBAR CATEGORY ============================================== -->
<div class="sidebar-widget wow fadeInUp outer-bottom-xs ">
<div class="widget-header m-t-20">
<h4 class="widget-title">Category</h4>
</div>
<div class="sidebar-widget-body m-t-10">
26
<?php $sql=mysqli_query($con,"select id,categoryName from category");
while($row=mysqli_fetch_array($sql))
{
?>
<div class="accordion">
<div class="accordion-group">
<div class="accordion-heading">
<a href="category.php?cid=<?php echo $row['id'];?>" class="accordion-toggle collapsed">
<?php echo $row['categoryName'];?>
</a>
</div>
</div>
</div>
<?php } ?>
</div><!-- /.sidebar-widget-body -->
</div><!-- /.sidebar-widget -->
<!-- ============================================== COLOR: END ============================================== -->
</div><!-- /.sidebar-filter -->
</div><!-- /.sidebar-module-container -->
</div><!-- /.sidebar -->
<div class='col-md-9'>
<!-- ========================================== SECTION – HERO ========================================= -->
<!-- <div id="category" class="category-carousel hidden-xs">
27
<div class="item">
<div class="image">
<img src="assets/images/banners/cat-banner-1.jpg" alt="" class="img-responsive">
</div> -->
<!-- <div class="container-fluid">
<div class="caption vertical-top text-left">
<div class="big-text">
<br />
</div>
<?php $sql=mysqli_query($con,"select categoryName from category where id='$cid'");
while($row=mysqli_fetch_array($sql))
{
?>
<div class="excerpt hidden-sm hidden-md">
<?php echo htmlentities($row['categoryName']);?>
</div>
<?php } ?>
</div>
</div> -->
<!-- </div>
</div> -->
<div class="search-result-container">
<div id="myTabContent" class="tab-content">
28
<div class="tab-pane active " id="grid-container">
<div class="category-product inner-top-vs">
<div class="row">
<?php
$ret=mysqli_query($con,"select * from products where category='$cid'");
$num=mysqli_num_rows($ret);
if($num>0)
{
while ($row=mysqli_fetch_array($ret))
{?>
<div class="col-sm-6 col-md-4 wow fadeInUp">
<div class="products">
<div class="product">
<div class="product-image">
<div class="image">
<a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><img src="assets/images/blank.gif" data-echo="admin/productimages/<?php echo htmlentities($row['id']);?>/<?php echo htmlentities($row['productImage1']);?>" alt="" width="200" height="300"></a>
</div><!-- /.image -->
</div><!-- /.product-image -->
<div class="product-info text-left">
<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['productName']);?></a></h3>
<div class="rating rateit-small"></div>
<div class="description"></div>
29
<div class="product-price">
<span class="price">
Rs. <?php echo htmlentities($row['productPrice']);?> </span>
<span class="price-before-discount">Rs. <?php echo htmlentities($row['productPriceBeforeDiscount']);?></span>
</div><!-- /.product-price -->
</div><!-- /.product-info -->
<div class="cart clearfix animate-effect">
<div class="action">
<ul class="list-unstyled">
<li class="add-cart-button btn-group">
<?php if($row['productAvailability']=='In Stock'){?>
<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
<i class="fa fa-shopping-cart"></i>
</button>
<a href="category.php?page=product&action=add&id=<?php echo $row['id']; ?>">
<button class="btn btn-primary" type="button">Add to cart</button></a>
<?php } else {?>
30
<div class="action" style="color:red">Out of Stock</div>
<?php } ?>
</li>
<li class="lnk wishlist">
<a class="add-to-cart" href="category.php?pid=<?php echo htmlentities($row['id'])?>&&action=wishlist" title="Wishlist">
<i class="icon fa fa-heart"></i>
</a>
</li>
</ul>
</div><!-- /.action -->
</div><!-- /.cart -->
</div>
</div>
</div>
<?php } } else {?>
<div class="col-sm-6 col-md-4 wow fadeInUp"> <h3>No Product Found</h3>
</div>
<?php } ?>
31
</div><!-- /.row -->
</div><!-- /.category-product -->
</div><!-- /.tab-pane -->
</div><!-- /.search-result-container -->
</div><!-- /.col -->
</div></div>
<?php include('includes/footer.php');?>
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/echo.min.js"></script>
<script src="assets/js/jquery.easing-1.3.min.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script>
<script src="assets/js/jquery.rateit.min.js"></script>
<script type="text/javascript" src="assets/js/lightbox.min.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
32
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/scripts.js"></script>
<!-- For demo purposes – can be removed on production -->
<script src="switchstylesheet/switchstylesheet.js"></script>
<script>
$(document).ready(function(){
$(".changecolor").switchstylesheet( { seperator:"color"} );
$('.show-theme-options').click(function(){
$(this).parent().toggleClass('open');
return false;
});
});
$(window).bind("load", function() {
$('.show-theme-options').delay(2000).trigger('click');
});
</script>
<!-- For demo purposes – can be removed on production : End -->
</body>
</html>