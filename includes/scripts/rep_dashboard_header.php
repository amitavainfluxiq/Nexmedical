<?php
global $AI;

$isApprovedReps = 0;

$tag_list_arr = array();
$lead_id = db_lookup_scalar("SELECT lead_id FROM users WHERE userID = ".db_in($AI->user->userID));

$tag_list = $AI->db->GetAll("SELECT tag_id FROM tags_lead_management AS t2f WHERE t2f.foreign_id = ".db_in($lead_id));

if(count($tag_list)){
    foreach ($tag_list as $row){
        $tag_list_arr[] = $row['tag_id'];
    }
}

if(in_array(23,$tag_list_arr)){
    $isApprovedReps = 1;
}

?>


<!--<div class="container-fluid menu_block1">

<div clas
}s="col-lg-6 col-md-6 col-sm-12 col-xs-12 topmenu_left">
    <a href="javascript:void(0)">Dashboard</a>
    <a href="javascript:void(0)">Success Center </a>
    <a href="javascript:void(0)"> Manage Doctors</a>

</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 topmenu_right">
<div class="topmenu_right_menu">
    <a href="javascript:void(0)"> <span class="badge badge1">3</span> <i class="glyphicon glyphicon-envelope"></i> Messages</a>
    <a href="javascript:void(0)"><span class="badge badge2">1</span> <i class="glyphicon glyphicon-bell"></i>  Notifications </a>
    <a href="javascript:void(0)"> <span class="badge badge3">5</span> <i class="glyphicon glyphicon-list"></i>   Tasks</a>
</div>
    <div class="topmenu_right_user">
        <img src="system/themes/nexmedicalbackend/images/user_demoimg.png" class="top_userimg">
       <h4><span>Rep Name</span></h4>
        <span class="top_right_arrow"><i class=" glyphicon glyphicon-menu-down"></i></span>

        <div class="clearfix"></div>
        </div>

    <div class="clearfix"></div>

</div>



    <div class="clearfix"></div>

</div>-->



<div class="container-fluid menu_block2">



    <div class="menu_block2_logo"><img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="nex_logo"></div>
    <div class="menu_block2_link">
        <span class="menuicon"><img src="system/themes/nexmedicalbackend/images/menuicon.png" ></span>

        <ul class="menu_block2_ullink">

           <li> <a href="dashboard" class="nlink1"> Dashboard</a></li>


            <li class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle nlink2" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">manage email <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li> <a href="imapinbox" class="nlink2_sub1">Inbox</a></li>
                    <li><a href="user-mail-manager" class="nlink2_sub2">Email Manager</a></li>
                </ul>
            </li>


            <li class="dropdown">

                <?php if($isApprovedReps == 1) { ?>
                    <a href="javascript:void(0)" class="dropdown-toggle nlink3" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Manage Doctors <span class="caret"></span></a>
                <?php }else{ ?>
                    <a href="javascript:void(0)" class="nlink3">Manage Doctors</a>
                <?php } ?>
                <ul class="dropdown-menu">
                    <li>  <a href="add-doctor" class="nlink3_sub1">ADD Doctor</a></li>
                    <li>  <a href="lead_management?te_class=lead_management&te_mode=doctor" class="nlink3_sub2">Doctor’s List</a></li>
                </ul>
            </li>

            <li class="dropdown">

                <?php if($isApprovedReps == 1) { ?>
                    <a href="javascript:void(0)" class="dropdown-toggle nlink4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Reps <span class="caret"></span></a>
                <?php }else{ ?>
                    <a href="javascript:void(0)" class="nlink4">My Reps</a>
                <?php } ?>
                <ul class="dropdown-menu">
                    <li>  <a href="lead_management?te_class=lead_management&te_mode=approvedrep" class="nlink4_sub1">Rep List</a></li>
                    <li>
                        <!--<a href="genealogy?te_class=genealogy&r=<?php /*echo $AI->user->userID;*/?>" class="nlink4_sub2">Genealogy</a>-->
                        <a href="javascript:void(0)" class="nlink4_sub2">Genealogy</a>
                    </li>
                </ul>
            </li>

            <li> <a href="javascript:void(0)" onclick="js:$('#comingsoonmmodal').modal('show')" class="nlink7">traning center </a> </li>
            <li> <a href="javascript:void(0)" class="nlink5">webinars </a> </li>
            <li> <a href="<?php echo ($isApprovedReps == 1)?'resources':'javascript:void(0)';?>" class="nlink6">Employment documents </a> </li>

        </ul>

        <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>

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


