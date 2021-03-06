<?php
/**
 * Created by PhpStorm.
 * User: iftekar
 * Date: 11/1/17
 * Time: 5:23 PM
 */

require_once( ai_cascadepath('includes/plugins/imap/imap.php') );
require_once( ai_cascadepath( 'includes/core/upload/class.upload.php' ) );

require_once "ImapClient/ImapClientException.php";
require_once "ImapClient/ImapConnect.php";
require_once "ImapClient/ImapClient.php";

use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;


global $AI;

$userid = $AI->user->userID;
$maildata = array('email'=>'dev007@nexmedsolutions.com','password'=>'P@ss0987');

$data = $AI->db->GetAll("SELECT * FROM user_mails WHERE userID = " . (int) $userid);

if(isset($data[0])){
    $password = base64_decode(base64_decode($data[0]['password']));

    $maildata =  array('email'=>$data[0]['email'],'password'=>$password);
}


$mailbox = 'galaxy.apogeehost.com';
$username = @$maildata['email'];
$password = @$maildata['password'];
$encryption = Imap::ENCRYPT_TLS; // or ImapClient::ENCRYPT_SSL or ImapClient::ENCRYPT_TLS or null

// open connection

try{
    $imap = new Imap($mailbox, $username, $password, $encryption);

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
    die();
}


$cururl = 'imapdetail?id='.$_GET['id'];

$stream=@imap_open("{galaxy.apogeehost.com/novalidate-cert}INBOX", $username, $password);
$uid = imap_uid($stream,$_GET['id']);

$imap->selectFolder('INBOX');
$countinbox = $imap->countMessages();
$messageheader=$imap->getMessageHeader($uid);
$msgbody=$imap->getBody($uid);
$status = imap_setflag_full($stream, $_GET['id'], "\\Seen \\Flagged");


$imap->selectFolder('INBOX.Sent');
$overallMessages = $imap->countMessages();

$imap->selectFolder('INBOX.Trash');
$trashcount = $imap->countMessages();

$imap->selectFolder('INBOX.Drafts');
$draftscount = $imap->countMessages();





$j=0;

$attachs = array();
$structure = imap_fetchstructure($stream, @$_GET['id']);

if(isset($structure->parts) && count($structure->parts)) {



    for ($i = 0; $i < count($structure->parts); $i++) {



        if (isset($structure->parts[$i]->disposition) && strtoupper($structure->parts[$i]->disposition) == 'ATTACHMENT') {

            $attachs[$j] = array(
                'is_attachment' => false,
                'filename' => '',
                'name' => '',
                'attachment' => '',
                'size'=>0);

            if($structure->parts[$i]->bytes) {
                $attachs[$j]['size'] = number_format($structure->parts[$i]->bytes/1024,2);
            }

            if($structure->parts[$i]->ifdparameters) {
                foreach($structure->parts[$i]->dparameters as $object) {
                    if(strtolower($object->attribute) == 'filename') {
                        $attachs[$j]['is_attachment'] = true;
                        $attachs[$j]['filename'] = $object->value;
                    }
                }
            }

            if($structure->parts[$i]->ifparameters) {
                foreach($structure->parts[$i]->parameters as $object) {
                    if(strtolower($object->attribute) == 'name') {
                        $attachs[$j]['is_attachment'] = true;
                        $attachs[$j]['name'] = $object->value;
                    }
                }
            }

            if($attachs[$j]['is_attachment']) {
                $attachs[$j]['attachment'] = imap_fetchbody($stream, @$_GET['id'], $i+1);
                if($structure->parts[$i]->encoding == 3) { // 3 = BASE64
                    $attachs[$j]['attachment'] = base64_decode($attachs[$j]['attachment']);
                }elseif($structure->parts[$i]->encoding == 4) { // 4 = QUOTED-PRINTABLE
                    $attachs[$j]['attachment'] = quoted_printable_decode($attachs[$j]['attachment']);
                }
            }

            $j++;
        }
    }
}

if(isset($_GET['mode'])){
    if($_GET['mode'] == 'download' && isset($_GET['attach_id'])){
        if(isset($attachs[$_GET['attach_id']])){
            $filename = $_SERVER['DOCUMENT_ROOT'].'/uploads/email_attach/'.rand().'_'.time().$attachs[$_GET['attach_id']]['name'];
            file_put_contents($filename, $attachs[$_GET['attach_id']]['attachment']);

            if(file_exists($filename)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($filename));
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                ob_clean();
                flush();
                readfile($filename);

                @unlink($filename);

                exit;
            }
        }
    }elseif ($_GET['mode'] == 'delete'){
        if(isset($_GET['id'])){
            imap_mail_move($stream, $_GET['id'], 'INBOX.Trash');
            imap_expunge($stream);
        }
        util_redirect('imapinbox');
    }
}


$attchmentstr='';


if(count($attachs)){
    $attchmentstr .= '<ul class="mailbox-attachments clearfix">';
    foreach($attachs as $key=>$row){
        $attchmentstr .='<li>
                            <span class="mailbox-attachment-icon">
                                                          <i class="fa fa-file-pdf-o"></i></span>

                                        <div class="mailbox-attachment-info">
                                            <a href="'.$cururl.'&mode=download&attach_id='.$key.'" class="mailbox-attachment-name"><span>Attachment</span> <i class="glyphicon glyphicon-paperclip"></i> '.$row['filename'].'</a>
                                            <span class="mailbox-attachment-size">
                                                             '.$row['size'].' KB
                                                              <a href="'.$cururl.'&mode=download&attach_id='.$key.'" class="btn btn-default btn-xs pull-right"><i class="glyphicon glyphicon-cloud-download"></i></a>
                                                            </span>
                                        </div>
                                    </li>';
    }
    $attchmentstr .= '</ul>';
}

$tos = $messageheader->to;
$tos = count($tos);




$replyBody = '<br><br><div>On '.date('D, M d, Y',$messageheader->udate).' at '.date('h:i A',$messageheader->udate).', '.$messageheader->fromaddress.' wrote:<div style="padding-left: 10px; border-left: solid #999999 1px;">'.trim(preg_replace('/\s\s+/', ' ', $msgbody['body'])).'</div></div>';

$forwardBody = '<div>---------- Forwarded message ----------<br>From: '.$messageheader->fromaddress.'<br>Date: '.date('D, M d, Y',$messageheader->udate).' at '.date('h:i A',$messageheader->udate).'<br>Subject: '.$messageheader->subject.'<br>To: '.$messageheader->toaddress.'</div><br><br><div>'.trim(preg_replace('/\s\s+/', ' ', $msgbody['body'])).'</div>';

global $AI;
$AI->skin->css('includes/plugins/imap/style.css');

$toaddr_arr = array();

if(isset($messageheader->from)){
    $reply = $messageheader->from;
    if(isset($reply[0])){
        $toaddr_arr[] = trim($reply[0]->mailbox)."@".trim($reply[0]->host);
    }
}

if(isset($messageheader->to)){
    $to = $messageheader->to;
    if(count($to)){
        foreach($to as $row){
            $mail2222 = trim($row->mailbox)."@".trim($row->host);
            if($mail2222 != $maildata['email']){
                $toaddr_arr[] = $mail2222;
            }
        }
    }
}

$resubject = $messageheader->subject;
if(!empty($resubject)){
    if(substr($resubject, 0, 3) != 'Re:'){
        $resubject = 'Re: '.$resubject;
    }
}

$fwdsubject = $messageheader->subject;
$fwdsubject = 'Fwd: '.$fwdsubject;

if(util_is_POST()) {
    require_once( ai_cascadepath('includes/plugins/system_emails/class.system_emails.php') );
    require_once( ai_cascadepath('includes/core/classes/email.php') );

    $mailbody = $_POST['body'];
    $mailbody = stripslashes($mailbody);

    $boundary = "------=".md5(uniqid(rand()));

    $msg1 = '';
    $msg2 = '';
    $msg3 = '';

    $header = "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $header .= "\r\n";

    $msg1 .= "--$boundary\r\n";
    $msg1 .= "Content-Type: text/html;\r\n\tcharset=\"utf-8\"\r\n";
    $msg1 .= "Content-Transfer-Encoding: 8bit \r\n";
    $msg1 .= "\r\n\r\n" ;
    $msg1 .= html_entity_decode($mailbody)."\r\n";
    $msg1 .= "\r\n\r\n";
    $msg3 .= "--$boundary--\r\n";

    if(isset($_POST['ai_upload_add'])){
        foreach($_POST['ai_upload_add'] as $row){
            $file2 = $row;
            $file_arr = explode('|',$file2);
            $file= $_SERVER['DOCUMENT_ROOT'].'/uploads/files/'.$file_arr[0].'/'.$file_arr[1];

            $filename=$file_arr[1];
            $ouv=fopen ("$file", "rb");$lir=fread ($ouv, filesize ("$file"));fclose
            ($ouv);
            $attachment = chunk_split(base64_encode($lir));

            $msg2 .= "--$boundary\r\n";
            $msg2 .= "Content-Transfer-Encoding: base64\r\n";
            $msg2 .= "Content-Disposition: attachment; filename=\"$filename\"\r\n";
            $msg2 .= "\r\n";
            $msg2 .= $attachment . "\r\n";
            $msg2 .= "\r\n\r\n";
        }
    }

    $toaddr = array();
    if(isset($_POST['toaddrs']))
        $toaddr = $_POST['toaddrs'];
    if(!empty($_POST['toaddrcus'])){
        $toaddr[] = $_POST['toaddrcus'];
    }

    $toaddr = array_unique($toaddr);


    $subject = '';
    if($_POST['mailtype'] == 'reply'){
        $subject = $_POST['resubject'];
    }

    if($_POST['mailtype'] == 'forward'){
        $subject = $_POST['fwdsubject'];
    }

    if(isset($_POST['ai_upload_add'])){

        $mailbody .= '<br><br><br>';

        foreach($_POST['ai_upload_add'] as $row){
            $file = $row;
            $file_arr = explode('|',$file);
            $mailbody .= '<a href="http://nexmedsolutions.com/uploads/files/'.$file_arr[0].'/'.strtolower($file_arr[1]).'">'.strtolower($file_arr[1]).'</a><br>';
        }
    }

    $email_name = 'imapsent';
    $send_to = implode(',',$toaddr);

    $default_vars = array
    (
        'email_msg' => $mailbody,
        'email_subject' => $subject,
        'title' => $email_name
    );


    if($_POST['subtype'] == 'drafts'){
        imap_append($stream, "{galaxy.apogeehost.com}INBOX.Drafts"
            , "From: ".$maildata['email']."\r\n"."To: ".$send_to."\r\n"."Subject: ".$subject."\r\n"."$header\r\n"."$msg1\r\n"."$msg2\r\n"."$msg3\r\n");
        imap_close ($stream);
        util_redirect('imapdrafts');
    }elseif ($_POST['subtype'] == 'send'){
        $sys_email = new C_system_emails($email_name);

        $sys_email->set_from($maildata['email']);
        $sys_email->set_from_name($maildata['name']);

        $sys_email->encode_vars=false;
        $sys_email->set_vars_array(array());
        $sys_email->set_defaults_array($default_vars);




        if($sys_email->send($send_to)){
            imap_append($stream, "{galaxy.apogeehost.com}INBOX.Sent"
                , "From: ".$maildata['email']."\r\n"."To: ".$send_to."\r\n"."Subject: ".$subject."\r\n"."$header\r\n"."$msg1\r\n"."$msg2\r\n"."$msg3\r\n");
            imap_close ($stream);

            if(count($toaddr)){
                foreach($toaddr as $row){
                    $mailres = $AI->db->GetAll("SELECT * FROM `mail_id_list` WHERE `userID`=".(int)$userid." AND `mail` LIKE '".$row."'");
                    if(count($mailres) == 0){
                        db_query("INSERT INTO `mail_id_list` ( `userID`, `mail`) VALUES ( ".$userid.", '".$row."');");
                    }
                }
            }

            util_redirect('imapsentbox');
        }

        if($sys_email->has_errors())
        {
            print_r($sys_email->get_errors());
        }

    }else{
        util_redirect('imapinbox');
    }

}

?>

<script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
<script type="text/javascript" src="includes/plugins/imap/imap.js"></script>

<script>

    function replymail() {
        $('.replybox').show();
        $('.replybox2').hide();
        $('#mailtype').val('reply');

        $('span.toaddrspan:not(:first)').remove();
        $('#compose-textarea').html($('#replybody').val());

        tinymceinit22();
    }

    function replyallmail(){
        $('.replybox').show();
        $('.replybox2').hide();
        $('#mailtype').val('reply');
        $('#compose-textarea').html($('#replybody').val());

        tinymceinit22();
    }

    function forwardmail() {
        $('.replybox').show();
        $('.replybox2').hide();
        $('#mailtype').val('forward');

        $('span.toaddrspan').remove();
        $('#compose-textarea').html($('#forwardbody').val());

        tinymceinit22();
    }

    function tinymceinit22() {

        tinymce.init({
            selector: 'textarea#compose-textarea',
            height: 500,
            //width:100%,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools code toc'
            ],
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor link | code'
        });

    }

</script>

<textarea id="replybody" style="display: none;"><?php echo $replyBody; ?></textarea>
<textarea id="forwardbody" style="display: none;"><?php echo $forwardBody; ?></textarea>

<div class="mailinbox">
    <div class="mailinboxblock">
        <div class="mailinboxheader">

            <div class="maillogodiv"></div>

            <div class="clearfix"></div>
        </div>
        <div class="mailinboxwrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row row-eq-height">
                    <!-- /mailleft.col -->
                    <div class="col-md-2 col-sm-3 col-xs-12 mailinboxleft">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title">Folders</h3>
                               <!-- <div class="box-tools">
                                    <button type="button" class="btn btn-box-tool" class="navbar-toggle" data-toggle="collapse"  data-target="#navbar-collapse-1"><span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </div>-->
                            </div>
                            <div class="box-body no-padding navbar-collapse" id="navbar-collapse-1">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="imapcreate"><span class="glyphicon glyphicon-pencil"></span>Compose</span></a></li>
                                    <li class="activemail"><a href="/~nexmed/imapinbox"><span class="glyphicon glyphicon-inbox"></span>Inbox <span class="label label-green pull-right"><?php echo $countinbox; ?></span></a></li>
                                    <li><a href="/~nexmed/imapdrafts"><span class="glyphicon glyphicon-folder-open"></span> Drafts<span class="label label-red pull-right"><?php echo $draftscount; ?></span></a></li>
                                    <li><a href="/~nexmed/imapsentbox"><span class="glyphicon glyphicon-envelope"></span> Sent Mail <span class="label label-red pull-right"><?php echo $overallMessages; ?></span></a></li>
                                    <li><a href="/~nexmed/imaptrash"><span class="glyphicon glyphicon-trash"></span> Trash<span class="label label-red pull-right"><?php echo $trashcount; ?></span></a></li>
                                    <li><a href="set-signature"><span class="glyphicon glyphicon-cog"></span> Settings</span></a></li>
                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /mailleft.col -->
                    <!-- /mailright.col -->
                    <div class="col-md-10 col-sm-9 col-xs-12 mailinboxright readmailinboxouterwrapper">
                        <div class="new_form_header">

                            <h2><span>INBOX:</span> <?php echo $messageheader->subject ; ?></h2>



                            <div class="clearfix"></div>
                        </div>


                        <div class="box box-primary readmailinboxwrapper">
                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <span class="mailbox-read-time pull-right"><?php echo date('F d,Y h:i A',$messageheader->udate);?></span>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding" style="margin-top: 15px;">
                                <div class="mailbox-controls with-border">
                                    <div class="pull-left readmailheadercontrol">
                                        <!--<a type="button" class="btn replybtn"  href="imapcreate?type=replyIn&id=<?php //echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-left"></i> Reply</a>-->
                                        <?php //if($tos > 1){?>
                                            <!--<a type="button" class="btn replybtn"  href="imapcreate?type=replyAllIn&id=<?php// echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-left"></i> Reply To All</a>-->
                                        <?php //} ?>
                                        <!--<a type="button" class="btn forwardbtn" href="imapcreate?type=forwardIn&id=<?php //echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-right"></i> Forward</a>-->
                                        <a type="button" class="btn trashbtn" href="<?php echo $cururl?>&mode=delete"><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                    </div>
                                </div>
                                <div class="mailbox-read-info">
                                    <h5 class="form-control"><span class="span1">From</span> <span class="span2"> <?php echo $messageheader->from[0]->personal." < ".$messageheader->from[0]->mailbox."@".$messageheader->from[0]->host." >"; ?> </span></h5>
                                    <h5 class="form-control"><span class="span1">Subject</span> <span class="span2"><?php echo $messageheader->subject ; ?></span> </h5>
                                </div>
                                <!-- /.mailbox-read-info -->

                                <!-- /.mailbox-controls -->
                                <div class="mailbox-read-message">
                                    <?php echo $msgbody['body']; ?>
                                </div>
                                <!-- /.mailbox-read-message -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <?php echo $attchmentstr; ?>
                            </div>
 <!--                           <div class="mailbox-controls with-border">
                                <div class="pull-left readmailheadercontrol">
                                    <a type="button" class="btn replybtn"  href="imapcreate?type=replyIn&id=<?php //echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-left"></i> Reply</a>
                                    <?php //if($tos > 1){?>
                                    <a type="button" class="btn replybtn"  href="imapcreate?type=replyAllIn&id=<?php// echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-left"></i> Reply To All</a>
                                    <?php// } ?>
                                    <a type="button" class="btn forwardbtn" href="imapcreate?type=forwardIn&id=<?php //echo @$_GET['id']; ?>"><i class="glyphicon glyphicon-arrow-right"></i> Forward</a>
                                    <a type="button" class="btn trashbtn" href="<?php //echo $cururl?>&mode=delete"><i class="glyphicon glyphicon-trash"></i> Trash</a>
                                </div>
                            </div>
-->
                            <div style="clear: both;"></div>

                            <div class="form-group form-control replybox2" style="padding-bottom: 18px; height: 70px;">
                                Click here to <a href="javascript:void(0);" onclick="replymail()">Reply</a><?php echo ($tos > 1)?', <a href="javascript:void(0);" onclick="replyallmail()">Reply to all</a>':''; ?> or <a href="javascript:void(0);" onclick="forwardmail()">Forward</a>
                            </div>

                            <form action="<?=$_SERVER['REQUEST_URI']?>" method="post" class="writemailinboxwrapper ">

                                <input type="hidden" name="mailtype" id="mailtype">
                                <input type="hidden" name="resubject" value="<?php echo $resubject;?>">
                                <input type="hidden" name="fwdsubject" value="<?php echo $fwdsubject;?>">

                            <div class="form-group toaddrcls form-control replybox" style="padding-bottom: 18px; display: none;">
                                <div class="clearfix"></div>
                                <?php
                                if(count($toaddr_arr)){
                                    foreach($toaddr_arr as $row){
                                        ?>
                                        <span class="toaddrspan">
                                            <input type="hidden" name="toaddrs[]" value="<?php echo trim($row)?>" >
                                            <?php echo trim($row)?>
                                            <a onclick="mailclose(this)" href="javascript:void();">x</a>
                                        </span>
                                        <?php
                                    }
                                }
                                ?>

                                <select name="mailselect" id="mailselect" style="display:none">
                                </select>
                            </div>

                            <div class="form-group replybox" id="replybody" style="display: none;">
                                <textarea name="body" id="compose-textarea" class="form-control"></textarea>
                            </div>
                                <div class="replybox" style="display: none;">
                                    <?php

                                    $upload = new C_upload('','');
                                    $upload->run();

                                    ?>
                                </div>
                            <div class="box-footer replybox" style="display: none;">
                                <div class="pull-left">
                                    <button type="submit" name="subtype" class="btn btnsend" value="send">Send</button>
                                    <button type="submit" name="subtype" class="btn btndraft" value="drafts">Draft</button>
                                </div>
                            </div>

                            </form>


                        </div>
                        <!-- /. box -->
                    </div>
                    <!-- /mailright.col -->
                </div>
            </section>
        </div>
    </div>
</div>