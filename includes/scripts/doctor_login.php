<?php
if(util_is_POST()) {
    //print_r($_POST);
    $lookup_userID = db_lookup_scalar("SELECT userID FROM users WHERE identity = '" . db_in( base64_encode(strtolower($_POST['identifier']) ) ). "'");
   //echo $lookup_userID;
   // exit;
    if($lookup_userID!=''){
        $x=$AI->user->auto_login($lookup_userID,true);
        /*print_r($x);
        echo "<br/>";
        print_r($AI->user);*/
        util_redirect('dashboard');
    }
}

?>



<div class="container-fluid doctor_login_wrapper">
    <table width="100%" border="0">
        <tr>
            <td valign="middle">

    <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="doctor-login-logo">

    <h2>doctor’s login</h2>

    <div class="doctor_login_boxcon">

        <form action="" method="post">

   <div class="form-group"><input name="identifier" type="text" placeholder="PERSONAL IDENTIFER" class="form-control"></div>

        <input type="submit" value="sign in" class="doctor_login_btn">


        <div class="login_bottom_con">
            <label>Not registered? <a href="javascript:void(0)"> Get More Info Here.</a></label>

            <span><a href="javascript:void(0)">Forgot your password?</a> </span>

          <div class="clearfix"></div>

        </div>

        </form>


    </div>

            </td>
        </tr>
    </table>
</div>