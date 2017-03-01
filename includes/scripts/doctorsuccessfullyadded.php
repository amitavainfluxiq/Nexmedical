<?php

global $AI;


require_once(ai_cascadepath('includes/plugins/landing_pages/class.landing_pages.php'));
$landing_page = new C_landing_pages('Add Doctor');


if(!isset($landing_page->session['form_data'])){
    util_redirect( 'dashboard' );
}

$formadata = $landing_page->session['form_data'];

$username = $landing_page->session['form_data']['username'];

$lead_id = 0;

$lead_det = $AI->db->GetAll("SELECT lead_id FROM users WHERE username = '".$username."'");

$lead_id = $lead_det[0]['lead_id'];

$repdetails = $AI->db->GetAll("SELECT `lead_management`.id,users.first_name,users.last_name FROM `lead_management` LEFT JOIN users ON users.userID = `lead_management`.`ownerID` WHERE `lead_management`.`id` = ".$lead_id);

unset($landing_page->session['lead_id']);
unset($landing_page->session['created_user']);

/*if(util_is_POST()) {

    if(isset($_POST['welcome_mail'])){
        $email_name = 'docttoradd';
        $send_to = $formadata['email'];
        $send_from = 'info@nexmedsolutions.com';

        $vars = array();
        $vars['fname'] = $formadata['first_name'];
        $vars['lname'] = $formadata['last_name'];
        $vars['url'] = 'https://nexmedsolutions.net/doctor-login';
        $vars['passcode'] = $formadata['identity'];
        $vars['repname'] = @$repdetails[0]['first_name']." ".@$repdetails[0]['last_name'];
        $defaults = array();

        $se = new C_system_emails($email_name);
        $se->set_from($send_from);
        $se->set_defaults_array($defaults);
        $se->set_vars_array($vars);
        $se->send($send_to);
    }
}*/

?>

<script>
    function send_mail(){
        $.post('doctorwelcomemail',{email:'<?php echo $formadata['email']; ?>',first_name:'<?php echo $formadata['first_name']; ?>',last_name:'<?php echo $formadata['last_name']; ?>',identity:'<?php echo $formadata['identity']; ?>',rep_first_name:'<?php echo @$repdetails[0]['first_name']; ?>',rep_last_name:'<?php echo @$repdetails[0]['last_name']; ?>'},function (res) {
            console.log(res);
        })
    }
</script>


<div class="container-fluid  adddoctor_banner_block">

    <div class="container">
        <h2>ADD Doctor</h2>


    </div>

</div>

<div class="container-fluid adddoctor_body_wrapper">

<div class="add_doctor_formconbox">
    <h2>Doctor Successfully Added</h2>

    <div class="doctorsuccessfullyadded_box">

        <label>DR. <span><?php echo $landing_page->session['form_data']['first_name'] ; ?> <?php echo $landing_page->session['form_data']['last_name'] ; ?></span> has been successfully added.</label>

        <label>Doctor's Username: <span><?php echo $landing_page->session['form_data']['username']; ?></span></label>

          <label>Password: <span><?php echo $landing_page->session['form_data']['password']; ?></span></label>

         <label>Personal Login Identifier: <?php echo $landing_page->session['form_data']['identity']; ?></label>


    </div>


    <div class="ssfullyadd_doctor_btncon">
        <input type="button" name="welcome_mail" value="EMAIL WELCOME LETTER NOW" class="sadd_btn" onclick="send_mail()">
        <a href="lead_management?te_class=lead_management&te_mode=update&listtype=doctor&te_key=<?php echo $lead_id; ?>&te_row=0"><input type="button" value="VIEW DOCTOR'S LEAD FOLDER" class="sadd_btn"></a>
        <a href="add-doctor"><input type="button" value="ADD NEW DOCTOR" class="sadd_btn"></a>

        <div class="clearfix"></div>
        </div>

</div>




</div>