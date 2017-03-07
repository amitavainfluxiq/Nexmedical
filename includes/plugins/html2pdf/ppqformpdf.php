<?php
//============================================================+
// File name   : example_003.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once( ai_cascadepath('includes/plugins/html2pdf/tcpdf/examples/tcpdf_include.php') );
//require_once('tcpdf_include.php');
class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(60);
        $this->SetX(28);
        // Set font
        $this->SetFont('helvetica', 8);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, $this->getAliasNumPage(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        //$this->Cell(0, 10, 'Confidentiality Agreement', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
/*$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 021');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

// set default header data
/*$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 021', PDF_HEADER_STRING);*/

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetLeftMargin(8);
$pdf->SetRightMargin(8);

//$pdf->SetY(50);


$pdf->setPrintHeader(false);
//$pdf->setPrintFooter(false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);






// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
//$pdf->SetFont('helvetica', '', 9);
$pdf->SetFont('helvetica');



// add a page
$pdf->AddPage();

// create some HTML content
/*$html = '<h1>Example of HTML text flow</h1>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. <em>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?</em> <em>Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</em><br /><br /><b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i> -&gt; &nbsp;&nbsp; <b>A</b> + <b>B</b> = <b>C</b> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>B</i> = <i>A</i> &nbsp;&nbsp; -&gt; &nbsp;&nbsp; <i>C</i> - <i>A</i> = <i>B</i><br /><br /><b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u> <b>Bold</b><i>Italic</i><u>Underlined</u>';*/


$html = '
<div style="width: 100%; margin: 0px auto;  padding: 0;   ">
<table width="100%" border="0" style="border-bottom: solid 1px #6ab4e5; padding-bottom: 1px;">
  <tr>
    <td align="left" valign="middle"><img src="system/themes/nexmedicalbackend/images/nex_logo.png" width="120"></td>
    <td align="right" valign="middle"><h2 style="font-size: 18px; color: #1a75bc; line-height: 24px; margin: 0; font-weight: normal; ">NMS-100 Series Analysis System<br />Qualification Questionnaire</h2>
</td>
  </tr>
</table>


<table width="100%" border="0" style="padding:12px 5px 6px 5px; font-size: 10px;">
  <tr>
    <td width="44%"> <label>NexMed Representative&nbsp;&nbsp;</label> <u>NexMed Representative  Name</u></td>
    <td width="28%"> <label>Phone&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
  <td width="28%"> <label>E-mail&nbsp;&nbsp;</label> <u>ab@abmial.com</u></td>
  </tr>
</table>

<table width="100%" border="0" style="padding:0 5px; font-size: 10px;">
   <tr>
    <td width="44%"> <label>NexMed Onboarder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label> <u>NexMed Onboarder  Name</u></td>
    <td width="28%"> <label>Phone&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
  <td width="28%"> <label>E-mail&nbsp;&nbsp;</label> <u>ab@abmial.com</u></td>
  </tr>
</table>

<table width="100%" border="0" style="padding:14px 10px 10px 10px; font-size: 10px;">
<tr>
<td><h1 style=" display: block;
font-size: 10px;
color: #1a75bc;
margin: 0px;
font-weight: bold;">PLEASE COMPLETE ALL SECTIONS</h1></td>
</tr>
</table>

<table width="100%" border="0" style="padding:6px 10px; font-size: 10px; border: solid 1px #6ab4e5; ">
<tr>
<td  width="16%"><h1 style=" display: block;
font-size: 10px;
color: #1a75bc;
margin: 0px;
font-weight: bold;">Doctor/Practiceis:</h1></td>

<td width="84%"><span><input type="checkbox" name="box" value="1" readonly="true" /> Family Medicine &nbsp;&nbsp;&nbsp;</span>

                 <span><input type="checkbox" name="box" value="1" readonly="true" />   General Practice &nbsp;&nbsp;&nbsp;</span>

                <span><input type="checkbox" name="box" value="1" readonly="true" />  Primary Care &nbsp;&nbsp;&nbsp;</span>

                 <span><input type="checkbox" name="box" value="1" readonly="true" /> Cardiology &nbsp;&nbsp;&nbsp;</span>

                 <span><input type="checkbox" name="box" value="1" readonly="true" />  Neurology &nbsp;&nbsp;&nbsp;</span>

                <span><input type="checkbox" name="box" value="1" readonly="true" />   Internal Medicine </span><br/><br/>

                <span><input type="checkbox" name="box" value="1" readonly="true" />   Endocrinology &nbsp;&nbsp;&nbsp;</span>

             <span><input type="checkbox" name="box" value="1" readonly="true" />  D.O. Doctor of Osteopathy &nbsp;&nbsp;&nbsp;</span>


              <span><input type="checkbox" name="box" value="1" readonly="true" />  Pain Mgmt (Integrated Practice) &nbsp;&nbsp;&nbsp;</span>

                  <span><input type="checkbox" name="box" value="1" readonly="true" />  Integrated Specialty Groups</span></td>

</tr>
</table>


<table width="100%" border="0" style="padding:14px 10px; padding-bottom: 4px;  ">
<tr>
<td >
<em style="font-style: italic;
font-size: 8px;
color: #000;
display: block;">Note: The listed taxonomies are NPI driven (based on NPI Registration)</em>
</td>

</tr>
</table>


<table width="100%" border="0" style="padding:4px 10px;background-color: #d8d8d8; text-align: center; font-size: 10px; line-height: 18px; color: #111; margin: 0px;  ">
  <tr>
   <td >
     <span style="color: #1a75c3;">**NOTE:</span> If Primary Practitioner is an APN,NP,FNP(taxonomy driven) and has a certificate to prescribe,there must be a Supervising MD (with one of the above taxonomies)for medical records review (percentage of records required to be reviewed depends on the state).
   </td>

</tr>
</table>


<div style="width: 100%; height: 5px; background: #fff;"></div>
<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;   border-top: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="60%"> <label>Name of Practice:&nbsp;&nbsp;</label> <u>Name of Practice</u></td>
    <td width="40%"> <label>Primary Practitioner:&nbsp;&nbsp;</label> <u>Primary Practitioner</u></td>

  </tr>
</table>

<table width="100%" border="0" style="padding:0 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
    <td width="35%"> <label>Address:&nbsp;&nbsp;</label> <u>NexMed Representative Address</u></td>
    <td width="27%"> <label>City:&nbsp;&nbsp;</label> <u>NexMed Representative City</u></td>
     <td width="25%"> <label>ST:&nbsp;&nbsp;</label> <u>NexMed Representative</u></td>
     <td width="13%"> <label>Zip:&nbsp;&nbsp;</label> <u>324569</u></td>

  </tr>
</table>

<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
    <td width="30%"> <label>Office Phone:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
    <td width="35%"> <label>Direct Line/Extension:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
     <td width="35%"> <label>Office Fax:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>


  </tr>
</table>


<table width="100%" border="0" style="padding:0 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
   <td width="52%"> <label>Office Contact Name/Title:&nbsp;&nbsp;</label> <u>Office Contact Name/Title</u></td>
    <td width="48%"> <label>Direct Line/Extension:&nbsp;&nbsp;</label> <u>Direct Line/Extension:</u></td>

  </tr>
</table>
<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
   <td width="50%"> <label>Cell Phone:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
    <td width="50%"> <label>Email:&nbsp;&nbsp;</label> <u>ab@abmial.com</u></td>

  </tr>
</table>



<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;   border-top: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="30%"> <label>Date Established:&nbsp;&nbsp;</label> <u>3.7.2017</u></td>
    <td width="42%"> <label>Individual/Organizational NPI#:&nbsp;&nbsp;</label> <u>Organizational</u></td>
     <td width="28%"> <label>Federal Tax ID#&nbsp;&nbsp;</label> <u>0000000</u></td>

  </tr>
</table>

<table width="100%" border="0" style="padding:0 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
    <td width="38%"> <label>Principal Owner’s Name:&nbsp;&nbsp;</label> <u>Owner’s Name</u></td>
    <td width="32%"> <label>Social Security No:&nbsp;&nbsp;</label> <u>00.00</u></td>
     <td width="30%"> <label>Date of Birth:&nbsp;&nbsp;</label> <u>15.11.1989</u></td>

  </tr>
</table>


<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
    <td width="38%"> <label>Home Address:&nbsp;&nbsp;</label> <u>NexMed Representative Address</u></td>
    <td width="27%"> <label>City:&nbsp;&nbsp;</label> <u>NexMed Representative City</u></td>
     <td width="23%"> <label>ST:&nbsp;&nbsp;</label> <u>NexMed Representative</u></td>
     <td width="12%"> <label>Zip:&nbsp;&nbsp;</label> <u>324569</u></td>

  </tr>
</table>

<table width="100%" border="0" style="padding:0 10px 13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
   <td width="50%"> <label>Principal Owner’s Home Phone:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
    <td width="50%"> <label>Personal Cell Phone:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>

  </tr>
</table>



<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;   border-top: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="100%"> <label>**If Supervising MD Requirement Exists – Supervising MD Name / Specialty:</label> </td>

  </tr>
</table>


<table width="100%" border="0" style="padding:0 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
   <td width="35%"> <label>Address:&nbsp;&nbsp;</label> <u>NexMed Representative Address</u></td>
    <td width="27%"> <label>City:&nbsp;&nbsp;</label> <u>NexMed Representative City</u></td>
     <td width="25%"> <label>ST:&nbsp;&nbsp;</label> <u>NexMed Representative</u></td>
     <td width="13%"> <label>Zip:&nbsp;&nbsp;</label> <u>324569</u></td>

  </tr>
</table>


<table width="100%" border="0" style="padding:13px 10px; border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5;  font-size: 10px;">
   <tr>
   <td width="100%"> <label>Contact Phone:&nbsp;&nbsp;</label> <u>00+ 000000000</u></td>
 </tr>
</table>


<table width="100%" border="0" style="padding:13px 10px;    border: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="33%"> <label>How many doctors in this practice?:&nbsp;&nbsp;</label> <u>000</u></td>
    <td width="33%"> <label>Average number of patients per day?:&nbsp;&nbsp;</label> <u>000</u></td>
    <td width="34%"> <label>Average Gross Monthly Revenue:&nbsp;&nbsp;</label> <u>000</u></td>

  </tr>
</table>



<table width="100%" border="0" style="padding:13px 0px 0 0;">
  <tr style="padding: 0px;">
    <td width="18%">
<div style=" border: solid 1px #6ab4e5; font-size: 9px;">

<table width="100%" border="0">
  <tr>
    <td style="text-align: left; " valign="middle"><br/><br/><label style="text-align: center;">% of Private<br/>
Insurance<br/>
Patients</label></td>
    <td style="text-align: right;" valign="bottom" ><br/><br/><br/><br/><u>000</u></td>

  </tr>
</table>


</div>


    </td>

 <td width="2%" style="background: #fff;">&nbsp;</td>
     <td width="18%" style="background: #fff; padding: 0 5px;">
<div style=" border: solid 1px #6ab4e5; font-size: 9px;">

<table width="100%" border="0">
  <tr>
    <td style="text-align: left; " valign="middle"><br/><br/><label style="text-align: center;">% of<br/>
Medicare<br/>
Patients:</label></td>
    <td style="text-align: right;" valign="bottom" ><br/><br/><br/><br/><u>000</u></td>

  </tr>
</table>


</div>


    </td>
    <td width="2%" style="background: #fff;">&nbsp;</td>


    <td width="35%"  >


<table width="100%" border="0" style=" border: solid 1px #6ab4e5; font-size: 9px;">
  <tr>
  <td width="45%" style="background: #fff; padding: 0 5px;">


<table width="100%" border="0">
  <tr>
    <td style="text-align: left; " valign="middle"><br/><br/><label style="text-align: center;">% of<br/>
Medicaid<br/>
Patients:</label></td>
    <td style="text-align: right; padding: 0px;" valign="bottom" ><u style="font-size: 6.5px;"><br/>Breakdown</u>

    <div style="border-right: solid 1px #000;"><br/><u>000</u><br/></div>

    </td>

  </tr>
</table>





    </td>

  <td width="55%" style="padding-left: 10px; line-height: 12px;">
<br/><br/>
 <span>&nbsp;&nbsp;<label>1&nbsp;</label> <u>000</u></span><br/>
 <span>&nbsp;&nbsp;<label>2&nbsp;</label> <u>000</u></span><br/>
 <span>&nbsp;&nbsp;<label>3&nbsp;</label> <u>000</u></span><br/>
 <span>&nbsp;&nbsp;<label>4&nbsp;</label> <u>000</u></span>

  </td>
  </tr>

  </table>


    </td>


     <td width="25%" >

     <div style=" background-color: #fff; font-size: 8.5px; padding: 0px 10px;"><span>&nbsp;&nbsp;&nbsp;&nbsp;<strong style="color: #1a75bc; font-weight: bold;">**NOTE:</strong>
ANS & Sudomotor Testing<br/>&nbsp;&nbsp;&nbsp;&nbsp;are exclusions with <u>Amerigroup</u><br/>&nbsp;&nbsp;&nbsp;&nbsp;Medicaid Groups

and do not reimburse.</span></div>

     </td>
  </tr>
</table>









<table width="100%" border="0" style="padding:5px 10px 5px 10px;    border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5; border-top: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="100%"> <label style="color: #1a75bc; font-weight: bold;">Is Obesity Counseling Offered?&nbsp;&nbsp;</label><span><input type="checkbox" name="box" value="1" readonly="true" />   Yes&nbsp;&nbsp;&nbsp;</span> <span><input type="checkbox" name="box" value="1" readonly="true" />   No&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label style="color: #1a75bc;  font-weight: bold;">Do you treat Neuropathy Patients in-house?&nbsp;&nbsp;</label><span><input type="checkbox" name="box" value="1" readonly="true" />   Yes&nbsp;&nbsp;&nbsp;</span> <span><input type="checkbox" name="box" value="1" readonly="true" />   No&nbsp;&nbsp;&nbsp;</span></td>
  </tr>
</table>


<table width="100%" border="0" style="padding:0 10px 5px 10px;    border-left: solid 1px #6ab4e5; border-right: solid 1px #6ab4e5; border-bottom: solid 1px #6ab4e5; font-size: 10px;">
   <tr>
    <td width="100%"> <label style="color: #1a75bc;  font-weight: bold;">Is any part of your practice Holistic?&nbsp;&nbsp;</label><span><input type="checkbox" name="box" value="1" readonly="true" />   Yes&nbsp;&nbsp;&nbsp;</span> <span><input type="checkbox" name="box" value="1" readonly="true" />   No&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <label style="color: #1a75bc;  font-weight: bold;">Do you have a Med Tech?&nbsp;&nbsp;</label><span><input type="checkbox" name="box" value="1" readonly="true" />   Yes&nbsp;&nbsp;&nbsp;</span> <span><input type="checkbox" name="box" value="1" readonly="true" />   No&nbsp;&nbsp;&nbsp;</span></td>
  </tr>
</table>

<table width="100%" border="0" style="padding:15px 10px;    font-size: 10px;">
   <tr>
    <td width="100%"> <label style="color: #1a75bc;  font-weight: bold;">Does site require a Med Tech to be hired?&nbsp;&nbsp;</label><span><input type="checkbox" name="box" value="1" readonly="true" />   Yes&nbsp;&nbsp;&nbsp;</span> <span><input type="checkbox" name="box" value="1" readonly="true" />   No&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <label style="color: #1a75bc;  font-weight: bold;">If Med Tech is known please provide information below:</label></td>
  </tr>
</table>



<table width="100%" border="0" style="padding:0 10px;  font-size: 10px;">
   <tr>
    <td width="40%"> <label>Med Tech Name:&nbsp;&nbsp;</label> <u>Med Tech Name</u></td>
    <td width="30%"> <label>Phone:&nbsp;&nbsp;</label> <u>00+0000000</u></td>
     <td width="30%"> <label>Email:&nbsp;&nbsp;</label> <u>ab@mail.com</u></td>
     

  </tr>
</table>

<table width="100%" border="0" style="padding:13px 10px;  font-size: 8px; line-height:10px ">
   <tr>
    <td width="100%"> <label>By
signing
below
applicant
represents
and
warrants
that
all
credit
and
financial
information
submitted
to
is
true
and
correct
and
that
Nex
Medical
may
use
any
information
necessary
pertaining
to
this
application
including,
but
not
limited
to,
owners,
officers,
or
guarantors.
The
undersigned
individual,
recognizing
that
his
or
her
individual
credit
history
may
be
a
factor
in
the
evaluation
of
the
applicant,
as
may
be
needed
in
the
evaluation
and
review
process
and
waives
any
right
or
claim
they
would
otherwise
have
under
the
fair
credit
reporting
act
in
the
absence
of
this
continuing
consent.</label> </td>




  </tr>
</table>




<table width="100%" border="0" style="padding:0 10px;  font-size: 10px;">
   <tr>
    <td width="60%"> <label>Applicant Signature:&nbsp;&nbsp;</label> <u>Applicant Signature:</u></td>
    <td width="40%"> <label>Date:&nbsp;&nbsp;</label> <u>3/7/2017</u></td>



  </tr>
</table>

</div>




';

// output the HTML content
$pdf->SetY(1);
$pdf->SetX(0);
$pdf->writeHTML($html, true, 0, true, true);
//$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('ppqformpdf.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
