<?php

global $AI;


$cdate = date('d');
$cmonth = date('M');

$salesrepname = '';
$salesrepaddress = '';
$signature = '';

if(util_is_POST()) {
    $valid = array();

    $salesrepname = $_POST['salesrepname'];
    $salesrepaddress = $_POST['salesrepaddress'];
    $signature = $_POST['signature'];


    if(empty($_POST['salesrepname'])){
        $valid[] = 'jonbox_alert("Please enter Sales\'s rep name")';
    }else if(empty($_POST['salesrepaddress'])){
        $valid[] = 'jonbox_alert("Please enter Sales\'s rep address")';
    }else if(empty($_POST['signature'])){
        $valid[] = 'jonbox_alert("Please enter Sales\'s rep digital signature")';
    }

    if(count($valid)){
        $AI->skin->js_onload("//DRAW LP ERRORS:\n\n" . implode("\n\n", $valid));
    }else{

        $leadid = db_lookup_scalar("SELECT lead_id FROM users WHERE userID = ".db_in($AI->user->userID));

        db_query("INSERT INTO `rep_contract` (`userID`,`lead_id`, `cdate`, `cmonth`, `salesrepname`, `salesrepaddress`, `termsdate`, `termsmonth`, `termedate`, `termemonth`, `signature`) VALUES (".$AI->user->userID.", ".$leadid.", '".$_POST['cdate']."', '".$_POST['cmonth']."', '".$_POST['salesrepname']."', '".$_POST['salesrepaddress']."', '".$_POST['termsdate']."', '".$_POST['termsmonth']."', '".$_POST['termedate']."', '".$_POST['termemonth']."', '".$_POST['signature']."');");

        require_once( ai_cascadepath('includes/plugins/tags/class.tags.php') );
        $new_tag_list=['EC - Pending Admin Compensation Input'];
        $tags = new C_tags('lead_management',db_lookup_scalar("select lead_id from users where userid = ". $AI->user->userID));
        //$old_tag_list = $tags->get_current_tags();
        //$tags->remove(['New Pre-Qualified Rep']);
        $tags->remove(['Temp Pre-Qualified Rep']);
        $tags->add($new_tag_list);

        util_redirect( 'contract-waiting' );

    }

}

?>

<script>

    $(function(){
        $('#salesrepname').blur(function(){
            var salesrepname = $(this).val();
            $('#repname').text(salesrepname);
        });

        $('#signherebtn').click(function(){
            $('#digSigModal').find('.modal-body').find('#fullname').val($('#salesrepname').val());
            $('#digSigModal').find('.modal-body').find('#fullnamesignature').text($('#salesrepname').val());
            $('#digSigModal').modal('show');
        });

        $('#digSigModal').find('.modal-body').find('#fullname').keyup(function(){
            $('#digSigModal').find('.modal-body').find('#fullnamesignature').text($(this).val());
        });

        $('#agreebtn').click(function(){
            $('#signature').val($('#digSigModal').find('.modal-body').find('#fullname').val());
            $('#signaturearea').text($('#digSigModal').find('.modal-body').find('#fullname').val());
        });


    });

</script>

<form action="" method="post">

    <input type="hidden" name="signature" id="signature" value="<?php echo $signature;?>" />

<div class="pdf_wrapper page1pdf" style="padding-bottom: 40px;">

    <h2 style="padding-bottom: 28px; text-decoration: underline;">PART TIME EMPLOYMENT AGREEMENT</h2>

    <div class="pdf_page1_block1" style="text-align: left;">
        This Agreement, (the "Agreement"), is made on the <input type="text" name="cdate"  class="p1_b1_input2n" style="text-align: center;" value="<?php echo $cdate;?>" readonly="readonly" /> day of <input type="text" name="cmonth" style="text-align: center;" class="p1_b1_input2" value="<?php echo $cmonth;?>" readonly="readonly" />, 2017, by and between Nex Medical Solutions, LLC, a Michigan limited liability company, with an address of 610 West
        Congress, Detroit, MI 48226 ("<strong>Employer</strong>"), and  <input type="text" name="salesrepname" id="salesrepname" value="<?php echo $salesrepname;?>" class="p1_b1_input2 inputbgcon" placeholder="Full Legal Name"/>, with an address of <input type="text" class="p1_b1_input3 inputbgcon" placeholder="Address" name="salesrepaddress" value="<?php echo $salesrepaddress;?>"> ("<strong>Employee</strong>"). (The Employer and
        Employee collectively shall be referred to as “Parties” and individually as "Party"). The Parties have
        negotiated certain terms of the Employee’s part-time employment with the Employer and have come to
        certain understandings about the terms and conditions of employment and wish to evidence this in
        writing.  </div>


        <h3> RECITALS </h3>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, Employer is engaged in the business of providing, directly or through
        affiliated entities, certain medical devices and medical device services to health care
        providers and facilities for the purpose of clinical testing of ANS/autonomic nervous system,
        and;</div>



    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, Employer desires to expand its business by informing and educating
        members of the medical community, and other interested parties about, among other things, the
        benefits of the clinical ANS services which the Employer can provide to individuals in need of
        such services, and Employer desires to hire Employee, on a part-time basis, to assist Employer in
        this endeavor, and;</div>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, Employee desires to accept such employment with Employer, and;</div>



    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREAS, the Parties to this Agreement desire to meet the requirements of all
        applicable laws, including 42 USC §1395nn, ("Stark Law"), and 42 USC §1320a-7b, ("Anti-kickback Law");</div>



    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOW, THEREFORE, in consideration of the premises and of the benefits to be derived
        from the mutual observance of the covenants in this agreement, the Parties agree as follows:</div>



    <h3> I. PART-TIME EMPLOYMENT </h3>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Employer agrees to employ the Employee as a Sales Representative on a part-time
        basis to perform the duties described in Section III of this Agreement, and the Employee accepts
        such part-time employment upon all of the terms and conditions set forth in this Agreement.</div>


    <h3> II. TERM </h3>
    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The Initial Term of part-time employment under this Agreement (the "<strong>Initial Term</strong>"),
        shall commence on the <input type="text" style="text-align: center;" name="termsdate" class="p1_b1_input2n" value="<?php echo $cdate;?>" readonly="readonly" />  day of <input type="text" style="text-align: center;" name="termsmonth" class="p1_b1_input2" value="<?php echo $cmonth;?>" readonly="readonly" />, 2017, (the “<strong>Effective Date</strong>”), and continue
        until the  <input type="text" name="termedate" style="text-align: center;" class="p1_b1_input2n" value="<?php echo $cdate;?>" readonly="readonly" /> day of <input type="text"  style="text-align: center;" class="p1_b1_input2" name="termemonth" value="<?php echo $cmonth;?>" readonly="readonly" />, 2019, unless terminated earlier as provided herein.</div>



    <div class="pdf_page1_block1" style="text-align: left; padding-top: 30px;">
        Following the expiration of the Initial Term, and subject to the provisions of Section VI herein,
        (“<strong>Termination</strong>”), this Agreement shall be automatically renewed for additional successive
        twelve (12) month part-time employment terms, (“<strong>Successor Terms</strong>”), unless terminated by
        Employer or Employee by delivery of 30 days written notice at any time. In the event that either
        Party delivers such a notice, the period of Employee's part-time will expire on the thirtieth day
        following delivery of such notice, unless terminated earlier as provided herein. Employee’s
        employment under this Agreement, during the Initial Term or any Successor Terms, regardless
        of the number thereof, shall be strictly as a part-time Employee. The entire period of
        Employee’s employment under this Agreement is referred to as the “<strong>Part-Time Employment
        Term</strong>”.


        </div>


    <h3> III. DUTIES</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
    <ol >

        <li style="list-style-type: upper-alpha">During the Part-Time Employment Term, the Employee, as a Sales Representative for the
            Employer, shall devote substantial business efforts and time (on a part-time basis) to the
            effort to expand Employer's business by informing and educating members of the
            medical community, and other interested parties about, among other things, the benefits
            of the clinical ANS services which the Employer can provide to individuals in need of
            such services, and Employee agrees and promises to perform and discharge, well and
            faithfully, those duties and such other duties as may be assigned to him or her from time
            to time by the Employer for the conduct of the Employer’s business. The Employee
            agrees to perform, on a part-time basis, those duties necessary to meet the expectations
            and goals of the Employer as established from time to time by the Employer in
            consultation with the Employee.</li>



        <li style="padding: 20px 0; list-style-type: upper-alpha">Except as otherwise provided in this Agreement or the Employer’s policies as adopted,
            even though Employee may be engaged in other business activity or employment during
            the Part-Time Employment Term, (subject to the restrictions described in Section VII
            herein), the Employee shall not during the Part-Time Employment Term of this
            Agreement be engaged in any other business activity or accept any other employment in
            competition with the existing or proposed business of the Employer, whether or not such
            business activity is pursued for gain, profit, or other pecuniary advantage, without prior
            approval of the Employer.</li>


        <li style="list-style-type: upper-alpha">Employee shall adhere to all applicable federal, state and local governmental laws, rules,
            and regulations including, but not limited to, 42 USC §1395nn, ("Stark Law"), and its
            implementing regulations, and 42 USC §1320a-7b, ("Anti-kickback Law"), and its
            implementing regulations. Employee shall indemnify Employer, and hold Employer
            harmless from, any liability or damage, including but not limited to actual attorney fees
            and costs, incurred by Employer arising from Employee’s violation of any state or
            Federal law or regulation.</li>



    </ol>

    </div>
    <h3>IV. COMPENSATION</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Beginning with the Effective Date of this Agreement, the Employee shall receive compensation as described in <strong>Exhibit "A"</strong> attached hereto which shall be paid by Employer in
        accordance with the Employer’s regular payroll practices and procedures and Employee shall
        receive an IRS Form W-2 from Employer to reflect compensation paid under this Agreement.

        </div>


    <h3>V. BENEFITS</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Employee acknowledges that his or her employment with Employer is on a part time
        basis and Employee hereby waives the right to participate in any employee benefit plans of
        Employer.

    </div>

    <h3>VI. TERMINATION</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A. This Agreement may be terminated by the Employee at any time, upon written notice.  When the Employer receives notice of Employee’s voluntary termination, the Employer may, at its sole discretion, immediately effect the voluntary termination of the Employee’s employment. Any voluntary termination of this Agreement by the Employee or Employer as described in this provision and Agreement herein shall terminate the rights and obligations of each of the Parties except as to those which survive the termination of this Agreement as described in Section VII (A) through (E), in Exhibit A, in Section IX (G) and (H), and in Section III (C) herein.

    </div>



    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B. Employee’s employment with the Employer shall be “at will,” meaning that
        Employer shall be entitled to terminate Employee at any time and for any reason, or for no
        reason, with or without Cause. Any contrary representations that may have been made to the
        Employee shall be superseded by this Agreement. This Agreement shall constitute the full and
        complete agreement between the Employee and the Employer on the “at will” nature of the
        Employee’s employment, which may only be changed in an express written agreement signed by
        an authorized Member of the Employer.

    </div>

    <h3 style="line-height: 24px;">VII. CONFIDENTIALITY, NONSOLICITATION, NONCOMPETITION,<br/>
        INJUNCTIVE RELIEF</h3>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A.  <u style="text-decoration: underline;">Unauthorized Disclosure of Confidential Information</u>. During Employee's Part-Time
        Employment Term, and continuing thereafter following any termination of such part-time
        employment, without the prior written consent of the Employer, except to the extent required by
        an order of a court having jurisdiction or under subpoena from an appropriate government
        agency (in which event, the Employee shall use his or her reasonable efforts to consult with the
        Employer prior to responding to any such order or subpoena), and except as required in the
        performance of his or her duties hereunder, the Employee shall not disclose or use for his or her
        benefit or gain any confidential or proprietary trade secrets, customer lists, vendors or
        manufactures, information regarding business development, marketing plans, sales plans and
        presentations, management organization information, operating policies or manuals, business
        plans, financial records, or other financial, commercial, business or technical information (a)
        relating to the Employer or any of its affiliates or (b) that the Employer or any of its affiliates may receive belonging to suppliers, customers or others who do business with the Employer or
        any of its affiliates (collectively, “Confidential Information”) to any third person unless such
        Confidential Information has been previously disclosed to the public or is in the public domain
        (other than by reason of the Employee’s breach of this Section VII).

    </div>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B.  <u style="text-decoration: underline;">Non-Competition</u>. During the period of the Employee's part-time employment with
        the Employer, and for two (2) years following termination thereof, irrespective of the reason for
        such termination, the Employee shall not, directly or indirectly, become employed or contracted
        in any capacity by, engage in business with, serve as an agent or consultant or a director, or
        become a partner, member, principal or stockholder of, any person or entity that competes or has
        a reasonable potential for competing, with any part of the current or prospective business of the
        Employer or any of its affiliates (the “Business”), nor shall Employee, directly or indirectly,
        provide, accept or offer to sell any clinical ANS services to any customer of Employer (or accept
        said services) which was Employer’s customer during the period of Employee’s employment
        with Employer, or before Employee’s employment with Employer, or upon whom Employee
        called as a prospective customer during Employee’s employment with Employer.

    </div>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C.  <u style="text-decoration: underline;">Non-Solicitation of Employees and/or Employer’s Vendors, Distributors or
        Manufactures</u>. During Employee’s employment and for two (2) years following termination thereof, irrespective of the reason for such termination, the Employee shall not, directly or indirectly, for his or her own account or for the account of any other person or entity, (i) solicit for employment, employ or otherwise interfere with any relationship of the Employer or any of its affiliates with any individual who is or was employed by, or with any vendor, distributor or manufacture who provided services or technology to, or was otherwise engaged to provide services or technology for the Employer or any of its affiliates in connection with the Business at any time during which the Employee was employed by the Employer, or (ii) induce any employee of the Employer or any of its affiliates, or any vendor, distributor or manufacture to Employer, to terminate his or her employment with, or terminate the services provided to, the Employer.

    </div>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D.  <u style="text-decoration: underline;">Return of Documents</u>. Upon termination of the Employee’s Employment for any
        reason, the Employee shall deliver to the Employer all of (i) the property of the Employer and
        (ii) the documents and data of any nature and in whatever medium of the Employer, and he or
        she shall not take with him or her any such property, documents or data or any reproduction
        thereof, or any documents containing or pertaining to any Confidential Information.

    </div>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E.  Employee acknowledges and agrees that the covenants, obligations and agreements of
        the Employee contained in Section VII relate to special, unique and extraordinary matters and
        that a violation of any of the terms of such covenants, obligations or agreements will cause the
        Employer irreparable injury for which adequate remedies are not available at law. Therefore, the
        Employee agrees that the Employer shall be entitled to an injunction, restraining order or such
        other equitable relief (without the requirement to post bond) as a court of competent jurisdiction
        may deem necessary or appropriate to restrain the Employee from committing any violation of
        such covenants, obligations or agreements. These injunctive remedies are cumulative and in
        addition to any other rights and remedies the Company may have and the provisions of this
        Section VII shall survive the termination of this Agreement, irrespective of the reason for
        termination.

    </div>




<h3>VIII. ASSIGNMENT PROHIBITED</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This Agreement and its rights and interests hereunder may be assignable by Employer
        without the Employee’s consent, but Employee shall not assign this Agreement or its rights and
        interests hereunder, without the prior written consent of the Employer.


    </div>


    <h3>IX. MISCELLANEOUS</h3>


    <div class="pdf_page1_block1" style="text-align: left;">
<ol>


    <li style="list-style-type: upper-alpha; padding: 10px 0;">This Agreement contains all of the terms and conditions of the contractual relationship
        between the Parties, and no amendments or additions to this Agreement shall be binding
        unless they are in writing and signed by both Parties.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;">This Agreement shall be binding upon the Parties, their legal representatives, successors, and assigns, and inures to their benefits. </li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> This Agreement abrogates and takes the place of all prior employment contracts and/or
        understandings that may have been made by the Employer.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> The captions or headings of this Agreement are for convenience only and in no way
        define, limit, or describe the scope or intent of this Agreement or any of its sections, nor
        do they in any way affect this Agreement.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> The Employee shall comply with all reporting and recording requirements regarding
        compensation expenditures and benefits provided by the Employer under the U.S.
        Internal Revenue Code, as amended, and any of its rules and regulations.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> The Parties agree this Agreement is based on the intention and assumption its terms and
        conditions are fully compliant with state and federal regulations, and will therefore
        immediately adopt any revisions necessary to remain compliant, and amend this
        Agreement, accordingly.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> Employee shall not cast any disparaging statement(s) against the Employer, during or
        after the Part-Time Employment Term.</li>

    <li style="list-style-type: upper-alpha; padding: 10px 0;"> Employee shall not make any misrepresentations connected to the Employer, medical
        device or medical device services hereunder.</li>
    </li>


</ol>
</div>
    <h3>X. NOTICES</h3>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Any notice required or permitted to be given under this Agreement shall be sufficient if it
        is in writing and if it is sent by registered mail or certified mail, return receipt requested, to the
        Employee at his or her residence affixed above, or to the Employer’s principal place of business
        as affixed above.

    </div>


    <h3>XI. COUNTERPART SIGNATURES</h3>


    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This Agreement may be executed in one or more counterparts, each of which shall be
        considered an original instrument, but all of which taken together shall be considered one and the
        same agreement and which shall become effective when one or more counterparts have been
        signed by each of the Parties hereto and delivered to the other. Original signatures transmitted
        by facsimile or .pdf shall be sufficient and binding upon the Parties hereto.

    </div>


    <h3>XII. GOVERNING LAW</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;This Agreement shall be governed by, construed, and enforced in accordance with the
        laws of the State of Michigan, and venue in the courts of Wayne County, Michigan.

    </div>

    <h3>XIII. SEVERABILITY</h3>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The invalidity of all or any part of any sections, subsections, or paragraphs of this
        Agreement shall not invalidate the remainder of this Agreement or the remainder of any
        paragraph or section not invalidated unless the elimination of such subsections, sections, or
        paragraphs shall substantially defeat the intents and purposes of the parties.

    </div>

    <div class="pdf_page1_block1" style="text-align: left;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WHEREFORE, the Parties have executed this Agreement on the date listed on the first
        page of this Agreement.

    </div>



   <div class="pdf_page1_signblock">

       <h2>EMPLOYER</h2>
       <h3>Nex Medical Solutions, LLC</h3>

       <span>/s/</span><input type="text" class="page1_signinput">

       <h4>By:</h4>
       <h4>Its:</h4>

   </div>

<div class="clearfix"></div>

    <div class="pdf_page1_signblock">

        <h2>EMPLOYEE</h2>
        <h3>&nbsp;</h3>

<!--        <span>/s/</span><input type="text" class="page1_signinput inputbgcon" name="signature" placeholder="Sign Here"  value="<?php /*echo $signature;*/?>">
-->
        <div class="new_signup_condiv">
            <span>/s/</span>


            <div class="new_signup_inpitdiv">

               <div class="new_signupdiv"> <input type="button" value="Sign Here" id="signherebtn"></div>
                <label id="signaturearea"><?php echo $signature;?></label>
            </div>

            <div class="clearfix"></div>


        </div>


        <h4>By: <span id="repname"><?php echo $salesrepname;?></span></h4>


    </div>

    <div class="clearfix"></div>

</div>

<input type="submit" value="Submit " class="ep_contractbtn">
</form>



<!-- Modal -->
<div id="digSigModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">

                <img src="system/themes/nexmedicalbackend/images/nex_logo.png" class="popup_logo">

                <h4>Digital Signature</h4>



                    <label>Full name</label> <input  type="text" id="fullname">


                <div class="popsigndiv">

                    <h2>Digitally Signed By:</h2>
                    <h3 id="fullnamesignature"> Sign Text Input</h3>
                    <h4><?php echo date('M d, Y h:ia')?></h4>

                </div>

                <h5>By selecting “agree”, the parties agree that this agreement may be electronically signed. The parties agree that the electronic signatures appearing on this agreement are the same as handwritten signatures for the purposes of validity, enforceability, and admissibility.
                </h5>

                <div class="pop_btn_drapper">

                    <button type="button" class="btn btn-default popbtn1" data-dismiss="modal" id="agreebtn">Agree</button>
                    <button type="button" class="btn btn-default popbtn2" data-dismiss="modal">Cancel</button>
                    <div class="clearfix"></div>
                </div>

            </div>




        </div>

    </div>
</div>