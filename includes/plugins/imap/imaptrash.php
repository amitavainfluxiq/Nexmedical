<?php
/**
 * Created by PhpStorm.
 * User: iftekar
 * Date: 11/1/17
 * Time: 5:23 PM
 */



namespace program;

require_once "ImapClient/ImapClientException.php";
require_once "ImapClient/ImapConnect.php";
require_once "ImapClient/ImapClient.php";

use SSilence\ImapClient\ImapClientException;
use SSilence\ImapClient\ImapConnect;
use SSilence\ImapClient\ImapClient as Imap;

$searchmail = array();
$keyword = '';

global $AI;

$userid = $AI->user->userID;
$maildata = array('email'=>'dev007@nexmedsolutions.com','password'=>'P@ss0987');

$data = $AI->db->GetAll("SELECT * FROM user_mails WHERE userID = " . (int) $userid);

if(isset($data[0])){
    $password = base64_decode(base64_decode($data[0]['password']));

    $maildata =  array('email'=>$data[0]['email'],'password'=>$password);
}

$cururl= 'imaptrash';

$mailbox = 'galaxy.apogeehost.com';
$username = @$maildata['email'];
$password = @$maildata['password'];
$encryption = Imap::ENCRYPT_TLS; // or ImapClient::ENCRYPT_SSL or ImapClient::ENCRYPT_TLS or null

// open connection

try{
    $imap = new Imap($mailbox, $username, $password, $encryption);

    /*
     * Or use advanced connect option like this
     *
    $imap = new ImapClient([
        'flags' => [
            'service' => ImapConnect::SERVICE_IMAP,
            'encrypt' => ImapConnect::ENCRYPT_SSL,
            'validateCertificates' => ImapConnect::VALIDATE_CERT,
        ],
        'mailbox' => [
            'remote_system_name' => 'imap.server.ru',
            'port' => 431,
        ],
        'connect' => [
            'username' => 'user',
            'password' => 'pass'
        ]
    ]);
    */

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
    die();
}



if(isset($_GET['mode'])){

    if($_GET['mode'] == 'delete'){
        if(util_is_POST()) {
            if(isset($_POST['mailids']) && count($_POST['mailids'])){
                $stream=@imap_open("{galaxy.apogeehost.com/novalidate-cert}INBOX.Trash", $username, $password);
                foreach ($_POST['mailids'] as $val){
                    imap_delete($stream, $val);
                }
                imap_expunge($stream);
            }
        }
    }else if($_GET['mode'] == 'search'){
        if(!empty($_POST['keyword'])){
            $keyword = $_POST['keyword'];
            $stream=@imap_open("{galaxy.apogeehost.com/novalidate-cert}INBOX.Trash", $username, $password);

            $searcharr = array();

            $typearr = array('SUBJECT','BCC','BODY','CC','SUBJECT','FROM','TEXT','TO');

            foreach ($typearr as $row){
                $res = imap_search($stream,$row.' "'.$keyword.'"');
                if($res){
                    $searcharr= array_merge($res,$searcharr);
                }
            }

            $searchmail = array_unique($searcharr);

        }else{
            util_redirect($cururl);
        }
    }else{
        util_redirect($cururl);
    }
}

// get all folders as array of strings
$folders = $imap->getFolders();
/*foreach($folders as $folder)
{
    print_r($folder);

}*/
$imap->selectFolder('INBOX');

$inboxno = $imap->countMessages();

// count messages in current folder
 $overallMessages = $imap->countMessages();
 $unreadMessages = $imap->countUnreadMessages();
$emails = $imap->getMessages();

$imap->selectFolder('INBOX.Sent');

// count messages in current folder
$overallMessages = $imap->countMessages();

$imap->selectFolder('INBOX.Trash');
$trashcount = $imap->countMessages();
$emails = $imap->getMessages();

$imap->selectFolder('INBOX.Drafts');
$draftscount = $imap->countMessages();

$stream=@imap_open("{galaxy.apogeehost.com/novalidate-cert}INBOX.Trash", $username, $password);

global $AI;
$AI->skin->css('includes/plugins/imap/style.css');
?>

<script>

    $(function () {

        if($('#delform').find('.mailids').length > 0){
            $('#deleteBtn').show();
        }else{
            $('#deleteBtn').hide();
        }


        $('.mailchk').click(function(){
            if($(this).is(':checked')){
                $('#delform').append('<input type="hidden" name="mailids[]" class="mailids" value="'+$(this).val()+'" />');
            }else{
                $('#delform').find('.mailids[value="'+$(this).val()+'"]').remove();
            }

            if($('#delform').find('.mailids').length > 0){
                $('#deleteBtn').show();
            }else{
                $('#deleteBtn').hide();
            }


        });


    });

    function godetails(id){
        window.location.href = 'trashdetails?id='+id;
    }

</script>

<div class="mailinbox">
    <div class="mailinboxblock">
        <div class="mailinboxheader">


            <div class="maillogodiv"></div>
            <div class="mailinboxheader_form">
            <form id="searchform" method="post" action="<?php echo $cururl;?>?mode=search">
                <input id="skey" type="text" name="keyword" class="form-control2 input-sm" placeholder="Search Mail" value="<?php echo $keyword;?>">
                <span class="glyphicon glyphicon-search form-control-feedback2"></span>
                <div class="clearfix"></div>
            </form>
                <div class="clearfix"></div>
                </div>
            <div class="clearfix"></div>
        </div>
        <div class="mailinboxwrapper">
            <!-- Main content -->
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
                            <div class="box-body no-padding collapse navbar-collapse" id="navbar-collapse-1">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="/~nexmed/imapinbox"><span class="glyphicon glyphicon-inbox"></span> Inbox <span class="label label-green pull-right"><?php echo $inboxno; ?></span></a></li>
                                    <li><a href="/~nexmed/imapdrafts"><span class="glyphicon glyphicon-pencil"></span> Drafts<span class="label label-red pull-right"><?php echo $draftscount; ?></span></a></li>
                                    <li><a href="/~nexmed/imapsentbox"><span class="glyphicon glyphicon-envelope"></span> Sent Mail <span class="label label-red pull-right"><?php echo $overallMessages; ?></span></a></li>
                                    <li class="activemail"><a href="/~nexmed/imaptrash"><span class="glyphicon glyphicon-trash"></span> Trash<span class="label label-red pull-right"><?php echo $trashcount; ?></span></a></li>
                                    <!--<li><a href="#"><span class="glyphicon glyphicon-pencil"></span> Drafts</a></li>
                                    <li><a href="#">More <span class="glyphicon glyphicon-chevron-down"></span> </a></li>-->
                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                    <!-- /mailleft.col -->
                    <!-- /mailright.col -->
                    <div class="col-md-10 col-sm-9 col-xs-12 mailinboxright">
                        <div class="new_form_header">
                        <h2><span>TRASH</span></h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="box box-primary">
                          <!--  <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <div class="has-feedback">

                                    </div>
                                </div>

                            </div>-->
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <div class="mailbox-controls">
                                    <!-- Check all button -->
                                    <button type="button" class="btn btn-default btn-sm btninputtype" style="display: none;"><input type="checkbox"><span class="glyphicon glyphicon-vector-path-square"></span>
                                    </button>
                                    <a type="button" class="btn btn-default btn-sm btnwritemail" href="imapcreate"><span class="glyphicon glyphicon-plus"></span> Compose</a>
                                    <div class="btn-group" id="deleteBtn">
                                        <form id="delform" method="post" action="<?php echo $cururl;?>?mode=delete">
                                        <button type="submit" class="btn btn-default btn-sm btndelete"><span class="glyphicon glyphicon-trash"></span> Delete</button>
                                        </form>
                                        <!---<button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                        <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>--->
                                    </div>
                                    <!-- /.btn-group -->

                                    <div class="pull-right" style="display: none">
                                        <button type="button" class="btn btn-default btn-sm btnrefresh"><span class="glyphicon glyphicon-refresh"></span></button>
                                        <button type="button" class="btn btn-default btn-sm btnall">All <span class="glyphicon glyphicon-triangle-bottom"></span></button>
                                        <!--1-50/200
                                        <div class="btn-group">
                                          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                          <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                        </div>-->
                                    </div>

                                    <!-- /.btn-group -->
                                    <!-- /.pull-right -->
                                </div>
                                <div class="table-responsive mailbox-messages">
                                    <table class="table table-hover table-striped">
                                        <tbody>
                                        <?php
                                        foreach ($emails as $key=>$email) {
                                        if(@$_GET['mode'] != 'search' || in_array($email['id'],$searchmail)){                                                                                               $isAttach = 0;

                                            $structure = imap_fetchstructure($stream, $email['id']);

                                            if(isset($structure->parts) && count($structure->parts)) {
                                                for ($i = 0; $i < count($structure->parts); $i++) {
                                                    if (isset($structure->parts[$i]->disposition) && strtoupper($structure->parts[$i]->disposition) == 'ATTACHMENT') {
                                                        $isAttach = 1;
                                                        break;
                                                    }
                                                }
                                            }

                                            $emailbody = strip_tags($email['body']);

                                            $cdate = time();
                                            $udate = $email['udate'];
                                            $differ = $cdate-$udate;

                                            if(date('Y',$cdate) > date('Y',$udate)){
                                                $datestring = date('m/d/Y',$udate);
                                            }elseif (floor($differ/(60*60*24))){
                                                $datestring = date('M d',$udate);
                                            }else{
                                                $datestring = date('h:i a',$udate);
                                            }

                                            ?>

                                            <tr class='clickable-row' style="cursor: pointer;">
                                                <td><input type="checkbox" class="mailchk" value="<?php echo $email['id'] ; ?>"></td>
<!--                                                <td class="mailbox-star"><a href="#"><span-->
<!--                                                            class="glyphicon glyphicon-star text-yellow"></span></a>-->
                                                </td>
                                                <td class="mailbox-name" onclick="godetails('<?php echo $email['id'] ; ?>')"><b><?php echo $email['from'] ; ?></b>
                                                </td>
                                                <td class="mailbox-subject" onclick="godetails('<?php echo $email['id'] ; ?>')" style="text-align: left;">
                                                    <div style="height: 25px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 580px;"><strong><?php echo $email['subject'] ; ?></strong>  <?php echo $emailbody; ?></div>
                                                </td>
                                                <td class="mailbox-attachment" onclick="godetails('<?php echo $email['id'] ; ?>')"><?php echo ($isAttach)?'<span class="glyphicon glyphicon-paperclip"></span>':''; ?></td>
                                                <td class="mailbox-date" onclick="godetails('<?php echo $email['id'] ; ?>')"><?php echo $datestring; ?></td>
                                            </tr>
                                            <?php
                                        }}

                                        ?>


                                        </tbody>
                                    </table>
                                    <!-- /.table -->
                                </div>
                                <!-- /.mail-box-messages -->
                            </div>
                            <!-- /.box-body -->
                            <!--<div class="box-footer no-padding">
                             <div class="mailbox-controls">
                               <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                               </button>
                               <div class="btn-group">
                                 <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                 <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                 <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                               </div>
                               <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                               <div class="pull-right">
                                 1-50/200
                                 <div class="btn-group">
                                   <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                   <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                 </div>
                               </div>
                             </div>
                           </div>-->
                        </div>
                        <!-- /. box -->
                    </div>
                    <!-- /mailright.col -->
                </div>
            </section>
        </div>
    </div>
</div>
