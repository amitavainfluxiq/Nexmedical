<?php
//echo "SELECT * FROM users WHERE account_type='Doctor' and parent=".$AI->user->userID;
$parent = db_lookup_scalar("SELECT count(*) FROM users WHERE account_type='Doctor' and parent=".$AI->user->userID );

?>

<div class="container-fluid rep-dashboard-wrapper1">
  <div class="row ">


          <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 reptopblock1 dropdown">
              <div class="rtop_subdiv dropdown-toggle" data-toggle="dropdown">
                  <label><?php echo ($parent)?></label>
                  <span>Total Doctors Leads<br/>
                      in system</span>
              </div>
              <a href="lead_management?te_class=lead_management&te_mode=doctor" class="rtop_sublink">Manage leads now</a>
             <!-- <a href="javascript:void(0)" class="rtop_sublink dropdown-toggle" data-toggle="dropdown">Manage leads now</a>
              <ul class="dropdown-menu">
                  <li><a href="javascript:void(0)"> <img src="system/themes/nexmedicalbackend/images/People-Doctor-Male-icon.png" > ADD Doctor  </a></li>
                  <li><a href="javascript:void(0)"><img src="system/themes/nexmedicalbackend/images/People-Doctor-Male-icon2.png" > Doctor’s List </a></li>
              </ul>-->
          </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 reptopblock2" data-toggle="modal" data-target="#comingsoonmmodal">
        <!--  <div class="rtop_subdiv">
              <label>0</label>
            <span>Doctors entered into<br/>
Tracking Process</span>

          </div>

          <a href="javascript:void(0)" class="rtop_sublink">view process Tracking Report</a>-->


          <img src="system/themes/nexmedicalbackend/images/re_das_demo1.jpg" width="100%" >

      </div>

      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 reptopblock2" data-toggle="modal" data-target="#comingsoonmmodal">
          <!--<div class="rtop_subdiv">
              <label>0</label>
            <span>Doctors approved<br/>
for nms-100</span>

          </div>

          <a href="javascript:void(0)" class="rtop_sublink">view approved doctors </a>-->


          <img src="system/themes/nexmedicalbackend/images/re_das_demo2.jpg" width="100%" >

      </div>


      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 reptopblock2" onclick="window.location.href = 'resources'">
          <!--<div class="rtop_subdiv">
              <label>0</label>
            <span>RESOURCES AVAILABLE<br/>
FOR REVIEW</span>

          </div>

          <a href="javascript:void(0)" class="rtop_sublink">VIEW RESOURCES LIBRARY </a>-->

          <img src="system/themes/nexmedicalbackend/images/re_das_demo3.jpg" width="100%" >




      </div>



      <div class="clearfix"></div>



</div>

    </div>




<div class="container-fluid rep-dashboard-wrapper1" style="padding-top: 0px;">
    <div class="row ">

        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 rep2block1" data-toggle="modal" data-target="#comingsoonmmodal" style="padding: 0px; background: #000;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo4.jpg" width="100%" style="opacity: 0.5;" >

        </div>

       <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 rep2block2">
            <h2>Recent  Doctors added to System </h2>
            <a href="javascript:void(0)" class="viewall_blink">View All </a>

            <div class="clearfix"></div>

             <ul>

                 <li>
                    <span> <img src="system/themes/nexmedicalbackend/images/re_das_demo6.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>

                 <li>
                     <span> <img src="system/themes/nexmedicalbackend/images/logo_pic.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>

                 <li>
                     <span> <img src="system/themes/nexmedicalbackend/images/logo_pic.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>

                 <li>
                     <span> <img src="system/themes/nexmedicalbackend/images/re_das_demo6.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>

                 <li>
                     <span> <img src="system/themes/nexmedicalbackend/images/logo_pic.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>

                 <li>
                     <span> <img src="system/themes/nexmedicalbackend/images/logo_pic.jpg"></span>

                     <label>
                         Lorem ipsum
                         <strong>Today</strong>

                     </label>


                 </li>



              </ul>


            <div class="clearfix"></div>
        </div>-->
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 rep2block2">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo5.jpg" width="100%">

        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 rep2block1" data-toggle="modal" data-target="#comingsoonmmodal" style="padding: 0px; background: #000;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo4.jpg" width="100%" style="opacity: 0.5;" >

        </div>






        <div class="clearfix"></div>

        </div>


        </div>


<div class="container-fluid rep-dashboard-wrapper2" style="padding-top: 0px;">
    <div class="row ">

        <div class="rep3block1" style="padding: 0px;background: #000;float: left;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo7.jpg" style="opacity: 0.5;">

        </div>

        <div class="rep3block2" style="padding: 0px;background: #000;float: right;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo8.jpg" style="opacity: 0.5;">

        </div>

        <div class="clearfix"></div>

    </div>


</div>



<div class="container-fluid rep-dashboard-wrapper3" style="padding-top: 0px;">
    <div class="row ">

        <div class="rep4block" style="padding: 0px;background: #000;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo9.jpg" width="100%" style="opacity: 0.5;">

        </div>
        <div class="clearfix"></div>

    </div>


</div>


<div class="container-fluid rep-dashboard-wrapper4" style="padding-top: 0px;">
    <div class="row ">

        <div class="rep5block1" style="padding: 0px;background: #000; float: left;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo10.jpg" width="100%" style="opacity: 0.5;">
        </div>

        <div class="rep5block2" style="padding: 0px;background: #000; float: right;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo11.jpg" width="100%" style="opacity: 0.5;">
        </div>


        <div class="clearfix"></div>

    </div>


</div>



<div class="container-fluid rep-dashboard-wrapper2" style="padding-top: 0px;">
    <div class="row ">

        <div class="rep3block1" style="padding: 0px;background: #000; float: left;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo12.jpg" style="opacity: 0.5;">

        </div>

        <div class="rep3block2" style="padding: 0px;background: #000; float: right;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo13.jpg" style="opacity: 0.5;">

        </div>

        <div class="clearfix"></div>

    </div>


</div>


<div class="container-fluid rep-dashboard-wrapper5" style="padding-top: 0px;">
    <div class="row ">

        <div class="rep6block1" style="padding: 0px;background: #000;float: left;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo14.jpg" style="opacity: 0.5;">
        </div>

        <div class="rep6block2" style="padding: 0px;background: #000;float: right;">
            <img src="system/themes/nexmedicalbackend/images/re_das_demo15.jpg" style="opacity: 0.5;">
        </div>


        <div class="clearfix"></div>

    </div>


</div>


    <!--coming soon modal-->
    <div class="modal fade comingsoonmmodal" id="comingsoonmmodal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="comingsoonmmodal_logo">
                    <h4>coming soon</h4>

                </div>

            </div>

        </div>
    </div>




