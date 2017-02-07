<?php


global $AI;


require_once(ai_cascadepath('includes/plugins/landing_pages/class.landing_pages.php'));
require_once(ai_cascadepath('includes/plugins/pop3/api.php'));
require_once ai_cascadepath('includes/modules/user_mails/includes/class.te_user_mails.php');
require_once ai_cascadepath('includes/plugins/user_management/includes/class.te_user_management.php');

$te_user_manager = new C_te_user_management();

$landing_page = new C_landing_pages('Add Representatives');
$landing_page->pp_create_campaign = false;

$landing_page->css_error_class = 'lp_error';

//add validation rule

$landing_page->add_validator('username', 'is_length', 3,'Invalid User Name');
$landing_page->add_validator('first_name', 'is_length', 3,'Invalid First Name');
$landing_page->add_validator('last_name', 'is_length', 3,'Invalid Last Name');
//$landing_page->add_validator('last_name', 'is_length', 3,'Invalid Last Name');
$landing_page->add_validator('company', 'is_length', 3,'Invalid  Company');
$landing_page->add_validator('city', 'is_length', 3,'Invalid  City');
$landing_page->add_validator('address', 'is_length', 3,'Invalid Address');
$landing_page->add_validator('state', 'is_length', 1,'Invalid State');
$landing_page->add_validator('zip', 'is_length', 3,'Invalid Zip');
$landing_page->add_validator('email', 'util_is_email','','Invalid Email Address');


if(util_is_POST()) {
    $landing_page->validate();
    $err = $AI->user->validate_password($_POST['password']);

    if (!empty($_POST['username'])){
        $err_arr = array();
        if(strlen($_POST['username'])<3) {
            $err_arr[] ='Username must be at least 3 characters.';
        }
        if(preg_match('/[^0-9A-Za-z-]/',$_POST['username'])) {
            $err_arr[] ='Username must only contain letters, numbers, and dashes.';
        }
        if(substr($_POST['username'],0,1)=='-' || substr($_POST['username'],-1)=='-') {
            $err_arr[] ='Username must not start or end with dash.';
        }

        if(count($err_arr) == 0){
            $lookup_userID = db_lookup_scalar("SELECT userID FROM users WHERE username = '" . db_in( $_POST['username'] ) . "';");
            if( is_numeric($lookup_userID)  )
            {
                $err_arr[] = 'Sorry, that username has already been taken, please choose another.';
            }
        }
    }

    if($landing_page->has_errors()) { $landing_page->display_errors(); }
    elseif (count($err_arr) > 0){
        $js[]="jonbox_alert('".implode('<br>',$err_arr)."');";
        if(count($js)>0) $AI->skin->js_onload("//DRAW LP ERRORS:\n\n".implode("\n\n",$js));
    }
    elseif($err !== true) {
        $js[] = "jonbox_alert('" . $err . "');";
        if (count($js) > 0) $AI->skin->js_onload("//DRAW LP ERRORS:\n\n" . implode("\n\n", $js));
    }elseif($_POST['password'] != $_POST['confirmpassword']){
        $js[] = "jonbox_alert('Passwords does not match');";
        if (count($js) > 0) $AI->skin->js_onload("//DRAW LP ERRORS:\n\n" . implode("\n\n", $js));
    }else {
        //save lead
        $lead=$landing_page->save_lead();
        //save user as Representatives
        $user=$landing_page->save_user('Approved Reps');

        $AI->user->login($_POST['username'],$_POST['password']);
        //echo "<pre>";
        //print_r($lead);
        //print_r($user);
        //print_r(db_lookup_scalar("select lead_id from users where userid = ". $AI->user->userID));
        //echo "</pre>";
        //exit;

        require_once( ai_cascadepath('includes/plugins/tags/class.tags.php') );
        $new_tag_list=['New Pre-Qualified Rep'];
        $tags = new C_tags('lead_management',db_lookup_scalar("select lead_id from users where userid = ". $AI->user->userID));
        //$old_tag_list = $tags->get_current_tags();
        $tags->add($new_tag_list);


        /****************Add mail Table[start]*********************/
        $te_user_mails = new C_te_user_mails();
        $te_user_mails->insert_data(array('userID'=>@$landing_page->session['created_user'],'email'=>strtolower($_POST['username']).'@nexmedsolutions.com','password'=>$_POST['password']));

        /****************Add mail Table[end]*********************/


        $cpanelusr = 'nexmed';
        $cpanelpass = 'l0PS8AyMm0aB';
        $xmlapi = new xmlapi('galaxy.apogeehost.com');
        $xmlapi->set_port( 2083 );
        $xmlapi->password_auth($cpanelusr,$cpanelpass);
        $xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false
        $result = $xmlapi->api1_query($cpanelusr, 'Email', 'addpop', array(strtolower($_POST['username']).'@nexmedsolutions.com',$_POST['password'],'unlimited','nexmedsolutions.com'));
        require_once( ai_cascadepath('includes/plugins/system_emails/class.system_emails.php') );
        $email_name = 'Rep Signup Frontend';
        $send_to = $_POST['email'];
        //$send_from = 'ben@apogeeinvent.com';

        $vars = array();
        $vars['Username'] = $_POST['username'];
        $vars['FirstName'] = $_POST['first_name'];

        $defaults = array();
        //$defaults['email_subject'] = 'Default Email Subject';
        //$defaults['email_msg'] = 'Hello [[name]], this is the default content of your email.';

        $se = new C_system_emails($email_name);
        //$se->set_from($send_from);
        $se->set_defaults_array($defaults);
        $se->set_vars_array($vars);
        $myheaders = array('Bcc' => 'debasiskar007@gmail.com');
        if (!$se->send($send_to,$myheaders)) {
            //echo 47;exit;
        }



        util_redirect( 'dashboard' );
    }

}

$landing_page->refill_form();

?>


<div class="container-fluid information-form_wrapper">

    <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="nex_logo_rp2">

    <div class=" information-form_main">
        <form name="landing_page" id="landing_page" action="<?=$_SERVER['REQUEST_URI']?>" method="post">

        <input type="hidden" name="country" value="US">

    <div class="information-formconbox form-inline">

        <div class="form-group">
            <label>First Name<span>*</span></label>
            <input type="text" name="first_name" class="form-control" placeholder="First Name">

        </div>

        <div class="form-group">
            <label>Last Name<span>*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name">

        </div>

        <div class="form-group">
            <label>Company</label>
            <input name="company" type="text" class="form-control" placeholder="Company">

        </div>


        <div class="form-group">
            <label>PHONE NUMBER<span>*</span></label>
            <input type="text" name="phone" class="form-control" placeholder="Phone Number">

        </div>


        <div class="form-group">
            <label>Username<span>*</span></label>
            <input type="text" name="username" class="form-control" placeholder="Username">
            <p class="noteclass">*PLEASE NOTE: Username will be associated with your NEX Medical Solutions email address. IE, if you choose your username to be JohnDoe, your NEX Medical Solutions email address will be JohnDoe@nexmedsolutions.com. USERNAMES cannot be changed.</p>
        </div>

        <div class="form-group">
            <label>Email Address<span>*</span></label>
            <input type="email" name="email" class="form-control" placeholder="Email Address">

        </div>



        <div class="form-group">
            <label>Password<span>*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Password">

        </div>
        <div class="clearfix"></div>
        <div class="form-group">
            <label>Confirm Password<span>*</span></label>
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">

        </div>
        <div class="form-group">
            <label>Address<span>*</span></label>

            <textarea name="address"  class="form-control" placeholder="Address"></textarea>


        </div>

        <div class="form-group">
            <label>Address 2 </label>

            <textarea name="address_2"  class="form-control" placeholder="Address 2"></textarea>


        </div>


        <div class="form-group">
            <label>City<span>*</span></label>

            <input name="city" type="text" class="form-control" placeholder="City">


        </div>


        <div class="form-group">
            <label>State<span>*</span></label>

<!--            <input name="state" type="text" class="form-control" placeholder="State">-->
            <?php $landing_page->draw_region_select('',true,'US','state','form-control'); ?>



        </div>

        <div class="form-group">
            <label>Zip Code<span>*</span></label>

            <input name="zip" type="text" class="form-control" placeholder="Zip">


        </div>


<div class="clearfix"></div>

<input type="submit" class="information-form-btn" value="Next">


    </div>

    </form>


    <div class="information-form-textcon">
        <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="nex_logo_rp1">

        <h2><span>NEX Medical Solutions</span> Sales Rep Registration</h2>
  <!--<h3><span>Welcome!</span> This is the first step to become a Rep for NEX Medical Solutions! We are happy you have joined our team and will help us accomplish our mission of providing only the best-quality products and services to the medical industry. We are here for you every step of the way and have an excellent Rep support system to help you succeed! </h3>-->

        <h3>Be part of the team that provides the healthcare community with cutting-edge technology and state-of-the-art solutions. We are committed to our goal of improving healthcare solutions across the nation and we need you. Sign in now and let’s get.</h3>

    </div>

</div>
</div>