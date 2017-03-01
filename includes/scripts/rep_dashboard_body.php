<?php
//echo "SELECT * FROM users WHERE account_type='Doctor' and parent=".$AI->user->userID;
$parent = db_lookup_scalar("SELECT count(*) FROM users WHERE account_type='Doctor' and parent=".$AI->user->userID );

require_once( ai_cascadepath( 'includes/modules/documents/includes/class.te_documents.php' ) );
$te_documents = new C_te_documents();
$total_doc = $te_documents->get_total();

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


      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  reptopblock4">
          <div class="rtop_subdiv">
              <label><?php echo $total_doc; ?></label>
            <span>RESOURCES AVAILABLE<br/>
FOR REVIEW</span>

          </div>

          <a href="resources" class="rtop_sublink">VIEW RESOURCES LIBRARY </a>

<!--          <img src="system/themes/nexmedicalbackend/images/re_das_demo3.jpg" width="100%" >-->




      </div>



      <div class="clearfix"></div>



</div>

    </div>















