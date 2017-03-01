<?php
/**
 * Created by PhpStorm.
 * User: kta
 * Date: 1/27/17
 * Time: 11:34 AM
 */
global $AI;

$parent = db_lookup_scalar("SELECT parent FROM users WHERE userID=".$AI->user->userID );
$email = db_lookup_scalar("SELECT email FROM user_mails WHERE userID=".$parent );
$array = db_lookup_assoc("SELECT * FROM users WHERE userID=".$parent);
?>

<div class="container-fluid home_top_menu1">
    <div class="home_top_menu1devider"></div>
    <div class="container">
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 topmenu1_left">
             <?php if($array['phone']!=''){
                 ?>

             Call REP:  <a href="tel:<?php echo @$array['phone']; ?>"><?php echo @$array['phone']; ?></a>   <span>|</span>
             <?php } ?>
             EMail REP:  <a href="mailto:<?php echo @$email; ?>"><?php echo @$email; ?></a>

         </div>

        <?php if(!$AI->user->is_logged_in()){ ?>
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 topmenu1_right">
             <a href="javascript:void(0)"> REP LOGIN</a>   <span>|</span>  <a href="javascript:void(0)"> DOCTOR LOGIN</a>

         </div>
        <?php } ?>
          <div class="clearfix"></div>

    </div>


</div>

<div class="container-fluid home_top_menu2">

    <div class="container">

        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 topmenu2_left">
            <a href="javascript:void(0)"><img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="homenex_logo"></a>

        </div>
        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 topmenu2_right">
            <nav class="navbar navbar-default">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Menu</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>


                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="dashboard">Home</a></li>
                            <li><a href="doctors-about">About us</a></li>
                            <li><a href="nms100">NMS-100</a></li>
                            <li><a href="doctors-videos">Videos</a></li>
                            <li><a href="resources">RESOURCES</a></li>
                            <li><a href="doctors-contact">Contact</a></li>

                        </ul>

                    </div><!--/.nav-collapse -->

            </nav>
<div class="clearfix"></div>

        </div>
        <div class="clearfix"></div>

        </div>


    </div>













