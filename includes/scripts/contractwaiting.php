<?php
/**
 * Created by PhpStorm.
 * User: kta
 * Date: 1/17/17
 * Time: 12:37 PM
 */

global $AI;

$salesrepname = db_lookup_scalar("SELECT salesrepname FROM rep_contract WHERE userID = ".db_in($AI->user->userID));

?>


<div class="contract_waitingdiv1" style=" font-family: 'proxima_nova_rgregular'!important;">

    <div class="container contract_waitingdiv_block1" >
        <table width="100%"  border="0">
<tr><td valign="middle">
        Congrats Samsuj Jaman!<br/><br/>

        Your employment is now in its final review. Your Exhibit A - Compensation
        form is now being generated.<br/><br/>

        You will be notified via email as soon as your form is available.<br/><br/>

        Thank You For Your Patience,

        <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="contract_waitingdiv_logo">
    </td></tr>
        </table>
    </div>




</div>


