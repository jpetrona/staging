<?php
/*
Template Name: thankyou
*/
?>
<!DOCTYPE html>



<html <?php language_attributes(); ?>>

<head>

<meta charset="<?php bloginfo('charset'); ?>" />

<title>Retirely</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="author" content="retirely">

<meta name="description" content="">



<!--fonts-->



<link href='//fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,800,600' rel='stylesheet' type='text/css'>

<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<link rel="profile" href="http://gmpg.org/xfn/11" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/ajax/bootstrap.css">

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">


<script src="<?php bloginfo('template_directory'); ?>/js/ajax/jquery.js"></script> 


<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!--[if lt IE 9]>

        <script src="<?php bloginfo('template_directory'); ?>/js/ajax/html5shiv.js"></script>

        <script src="<?php bloginfo('template_directory'); ?>/js/ajax/respond.min.js"></script>

        <![endif]-->

<!--favicon-->



<link href="<?php bloginfo('template_directory'); ?>/images/favicon.png" rel="shortcut icon">

<?php wp_head(); ?>

</head>

<body>

<header role="navigation" class="navbar navbar-default navbar-fixed-top">

  <div class="top-bar">

    <div class="container">

      <div class="row">

        <div class="col-sm-12 login-nav">

          <ul class="clearfix">

            <?php if(!isset($_SESSION['advisorid'])) { ?>

            <li><a onClick="showSignIn()" href="#">Advisor</a></li>

            <li><a onClick="showSignIn()" href="#">Login</a></li>

            <?php } else {

          echo '<li class="welcome">welcome <span class="emp">'.$_SESSION['name'].'</span></li>
										  <li><a href="javascript:void(0);" onClick="advisorSignOut();">Logout</a></li>';
                }
              ?>

          </ul>

        </div>

        <!--login-nav--> 

        

      </div>

      <!--row--> 

      

    </div>

    <!--container--> 

    

  </div>

  <!--top-bar-->

  

  <nav class="container">

    <div class="navbar-header">

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
<div id="logo">
                            <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" /></a></div>
      <!--<a class="navbar-brand" href="#">retirely</a> --></div>

    <!--navbar-header-->
  </nav>

</header>

<section id="home">

  <div class="container">

    <div class="row">
      <div class="col-lg-12">
      <h1>Thank You</h1>
      </div>
      <!--col-->
    </div>
    <!--row--> 
  </div>
  <!--jumbotron--> 
</section>
</body>
</html>