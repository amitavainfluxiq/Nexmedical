<?php


//set and submit landing page 2nd step

global $AI;


require_once(ai_cascadepath('includes/plugins/landing_pages/class.landing_pages.php'));
require_once(ai_cascadepath('includes/plugins/pop3/api.php'));
require_once ai_cascadepath('includes/modules/user_mails/includes/class.te_user_mails.php');
require_once ai_cascadepath('includes/plugins/user_management/includes/class.te_user_management.php');

$te_user_manager = new C_te_user_management();

$landing_page = new C_landing_pages('Add Doctor');
$landing_page->next_step = 'doctor-list';
$landing_page->pp_create_campaign = false;

$landing_page->css_error_class = 'lp_error';


//add validation rule

$landing_page->add_validator('first_name', 'is_length', 3,'Invalid First Name');
$landing_page->add_validator('last_name', 'is_length', 3,'Invalid Last Name');
//$landing_page->add_validator('last_name', 'is_length', 3,'Invalid Last Name');
//$landing_page->add_validator('company', 'is_length', 3,'Invalid  Company');
$landing_page->add_validator('city', 'is_length', 3,'Invalid  City');
$landing_page->add_validator('address_1', 'is_length', 3,'Invalid Address');
$landing_page->add_validator('state', 'is_length', 1,'Invalid State');
$landing_page->add_validator('zip_code', 'is_length', 3,'Invalid Zip');
$landing_page->add_validator('email', 'util_is_email','','Invalid Email Address');
$landing_page->add_validator('gmt_offset', 'is_length', 3,'Invalid timezone');


$timezone_res = db_query('SELECT timezone FROM time_zone_by_zip_code GROUP BY timezone;');
$timezone_html = '<select name="gmt_offset" id="gmt_offset" class="form-control" >';
$timezone_html .= '<option value="">(not set)</option>';
while($timezone_res && $tz_row = db_fetch_assoc($timezone_res))
{
    $timezone_html .='<option value="'.$tz_row['timezone'].'">'.h($tz_row['timezone']).'</option>';
}
$timezone_html .= '</select>';


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
    elseif($err !== true){
        $js[]="jonbox_alert('".$err."');";
        if(count($js)>0) $AI->skin->js_onload("//DRAW LP ERRORS:\n\n".implode("\n\n",$js));
    }
    else {

        //save lead
        $landing_page->save_lead();
        //save user as Representatives
        $landing_page->save_user('Doctor');


        /****************Add mail Table[start]*********************/
        $te_user_mails = new C_te_user_mails();
        $te_user_mails->insert_data(array('userID'=>@$landing_page->session['created_user'],'email'=>strtolower($_POST['username']).'@nexmedsolutions.com','password'=>$_POST['password']));

        /****************Add mail Table[end]********************88*/


        require_once( ai_cascadepath('includes/plugins/system_emails/class.system_emails.php') );
        $email_name = 'repsignup';
        $send_to = $_POST['email'];
        $send_from = 'ben@apogeeinvent.com';

        $vars = array();
        $vars['uname'] = $_POST['username'];
        $vars['pass'] = $_POST['password'];

        $defaults = array();

        /*$se = new C_system_emails($email_name);
        $se->set_from($send_from);
        $se->set_defaults_array($defaults);
        $se->set_vars_array($vars);*/

        $cpanelusr = 'nexmed';
        $cpanelpass = 'l0PS8AyMm0aB';
        $xmlapi = new xmlapi('galaxy.apogeehost.com');
        $xmlapi->set_port( 2083 );
        $xmlapi->password_auth($cpanelusr,$cpanelpass);
        $xmlapi->set_debug(0); //output actions in the error log 1 for true and 0 false
        $result = $xmlapi->api1_query($cpanelusr, 'Email', 'addpop', array(strtolower($_POST['username']).'@nexmedsolutions.com',$_POST['password'],'unlimited','nexmedsolutions.com'));

        $landing_page->clear_session();
        unset($landing_page->session['lead_id']);
        unset($landing_page->session['created_user']);
        unset($landing_page->session['created_order']);

        util_redirect( 'doctor-list' );
    }
}

$landing_page->refill_form();

$is_chk = 0;

if(isset($landing_page->session['form_data']['docscontac'][0]) && $landing_page->session['form_data']['docscontac'][0] == 1){
    $is_chk = 1;
}

?>

<script>
    $(function(){
        $('#adddocformbody').hide();
        var is_chk = '<?php echo $is_chk; ?>';

        if(is_chk == 1){
            $('.docscontac:first').prop("checked",true);
            $('#adddocformbody').show();
        }

        $(".docscontac").click(function(){
            var group = ".docscontac";
            //$(group).attr("checked",false);
            //$(this).attr("checked",true);
            $(group).prop("checked",false);
            $(this).prop("checked",true);

            if($(this).val() == 1) {
                $('#adddocformbody').show();
            }else{
                $('#adddocformbody').hide();
                $('#docContactModal').modal('show');
            }

        });
    });

    function generatepassword(){

        $('#passwordgenerator').modal('show');
        var pass=generatePasswords();
        $('#generate_password_confirm').removeAttr('checked');
        $('#pgenerate').val(pass);
    }


    function generatePasswords() {
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#*_&",
            retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }
    function usepassword() {
        if($('#generate_password_confirm').is(":checked")==true){
            $('#passwordgenerator').modal('hide');
            $('#pass').val($('#pgenerate').val());
        }

    }
</script>


<div class="container-fluid information-form_wrapper">
    <div class=" information-form_main">


    <form name="landing_page" id="adddocform" action="<?=$_SERVER['REQUEST_URI']?>" method="post">

        <div class="information-formconbox" style="margin-bottom: 15px;">
            <div class="information-form-textcon" style="width: 100%; padding-left: 0;">
                <h2>I have personal contact with this doctor’s office</h2>
            </div>
            <div style="clear: both;"></div>
            <div class="information-form-textcon" style="width: 100%; padding-top: 0; padding-left: 0;">
                <div>
                    <input name="docscontac[]" class="docscontac" type="checkbox" value="1" style="float: left;"><h3 style="float: left; margin-left: 7px; margin-right: 15px;">Yes</h3>

                    <input name="docscontac[]" class="docscontac" type="checkbox" value="0" style="float: left;"><h3 style="float: left; margin-left: 7px;">No</h3>
                </div>
            </div>
        </div>


        <div class="information-formconbox form-inline" id="adddocformbody">
        <input type="hidden" name="form_time" value="<?= date('Y-m-d H:i:s') ?>" />
        <div class="form-group">
            <label>Doctor’s First Name<span>*</span></label>
            <input type="text" name="first_name" class="form-control" placeholder="First Name">

        </div>

        <div class="form-group">
            <label>Doctor’s Last Name<span>*</span></label>
            <input type="text" name="last_name" class="form-control" placeholder="Last Name">

        </div>

        <div class="form-group">
            <label>Office Manager</label>
            <input name="office_manager" type="text" class="form-control" placeholder="Office Manager">

        </div>

        <div class="form-group">
            <label>Company</label>
            <input name="company" type="text" class="form-control" placeholder="Company">

        </div>

        <div class="form-group">
            <label>Email Address<span>*</span></label>
            <input type="email" name="email" class="form-control" placeholder="Email Address">

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
            <label>Password<span>*</span></label>
            <input type="password" id="pass" name="password" class="form-control" placeholder="Password">
<input type="button" onclick="generatepassword()" value="Generate Password" />
        </div>
        <div class="clearfix"></div>
        <div class="form-group hide">
            <label>Confirm Password<span>*</span></label>
            <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">

        </div>
        <div class="form-group">
            <label>Address<span>*</span></label>

            <textarea name="address_1"  class="form-control" placeholder="Address"></textarea>


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

            <!--<input name="bill_state" type="text" class="form-control" placeholder="State">-->
            <?php $landing_page->draw_region_select('',true,'US','state','form-control'); ?>


        </div>

        <div class="form-group">
            <label>Zip Code<span>*</span></label>

            <input name="zip_code" type="text" class="form-control" placeholder="Zip">


        </div>


        <div class="form-group">
            <label>Timezone<span>*</span></label>
            <?php echo $timezone_html; ?>
        </div>


        <div class="form-group">
            <label>Best Contact Time<span>*</span></label>
            <select id="besttime" name="besttime" class="form-control">
                <?php $landing_page->draw_besttime_options(); ?>
            </select>
        </div>


        <div class="clearfix"></div>

<input type="submit" class="information-form-btn" value="Next">


    </div>

    </form>


    <div class="information-form-textcon">


        <h2><span>NEX Medical Solutions</span> Doctor Registration</h2>
  <h3><span>Welcome!</span> This is the first step to become a Rep for NEX Medical Solutions! We are happy you have joined our team and will help us accomplish our mission of providing only the best-quality products and services to the medical industry. We are here for you every step of the way and have an excellent Rep support system to help you succeed! </h3>

    </div>

</div>
</div>



<!-- Modal -->
<div class="modal fade" id="docContactModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">&nbsp;</h4>
            </div>
            <div class="modal-body">By adding doctors whom you do not have contact with is grounds for immediate termination. Please make initial contact with the doctor’s office before adding them into the system.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="passwordgenerator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">&nbsp;Password Generator</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <input id="pgenerate" name="pgenerate">
                        <br/>
                        <input type="button" onclick="generatepassword()" value="Generate Password">
                        <br/>
                        <p>
                            <input type="checkbox" id="generate_password_confirm">
                            <label for="generate_password_confirm">I have copied this password to a secure location.</label>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" onclick="usepassword()" class="btn btn-default">Use Password</button>
                </div>
            </div>
        </div>
    </div>

<?php
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_@#';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

//echo randomPassword();
?>