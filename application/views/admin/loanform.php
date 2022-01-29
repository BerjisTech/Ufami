<!DOCTYPE html>
<html lang="en">
    

<?php include 'header.php'; ?>

<body class="page-body skin-facebook <?php if($page_name == 'dashboard'){ echo 'gray'; } ?>" data-url="<?php echo base_url(); ?>">
	
    <script type="text/javascript">
        var base_url = '<?php echo base_url(); ?>';
    </script>
	<div class="page-container">
		
        <?php include 'sidebar.php'; ?>    
    
		<div class="main-content">
            <div class="row">
                <div id="printform" style="display: table; width: 100%; font-size: 13px; color: #000;">
                    <div style="display: table; width: 90%; margin: 10px auto;">
                        <img src="" style="display: table; width: 100%;"/>
                        <div style="display: table; width: 100%; height: auto; padding: 10px;">
                        <br /><br /><br /><br /><br/>
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: right;">
                                <strong>Serial Number: .............</strong>
                            </div>
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: center;">
                                <h2 style="font-weight: bold;">CONFIDENTIAL</h2>
                                <h4 style="font-weight: bold;"><u>UFAMI SACCO LOAN APPLICATION & LOAN AGREEMENT FORM</u></h4>
                            </div>
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: left;">
                                <p>Kindly ensure:-<br />
                                    <ul style="font-style: oblique;">
                                        <li style="list-style: lower-roman;">You have submitted your copies of KRA PIN, ID card and two <strong>recent</strong> passport sized photographs in the office</li>
                                        <li style="list-style: lower-roman;">You have completed the total amount of share capital <strong>i.e Kshs. 5000</strong></li>
                                        <li style="list-style: lower-roman;">You have cosntantly remitted at least <strong>Kshs. 500</strong>, the minimum monthly contributions for not less than 6 months</li>
                                        <li style="list-style: lower-roman;">You have paid Kshs. 200 for the passbook & Kshs 150 for the bylaws</li>
                                        <li style="list-style: lower-roman;">Loan processing fee of 1% of the approved or a minimum of <strong>Kshs 200</strong> will be recovered from the loan</li>
                                    </ul>
                                </p>
                                <h3><u>PERSONAL INFORMATION</u></h3>
                                <ol>
                                    <li>Memeber's Name: <b style="display: inline-table; width: 300px; text-align: center; border-bottom: 1px solid #000;"></u><?php echo $member; ?></u></b></li>
                                    <br />
                                    <li>Memeber's Permanent Home Address: <u style="display: inline-table; width: 200px; text-align: center; border-bottom: 1px solid #000;"></u></li>
                                    <br />
                                    <li>Memeber's No: <b style="display: inline-table; width: 300px; text-align: center; border-bottom: 1px solid #000;"><?php echo $mno; ?></u></b></li>
                                </ol>
                                <br />
                                <table border="1" style="display: table; width: 100%;">
                                    <tr>
                                        <th style="padding: 10px; width: 30%;">Applied for</th>
                                        <td style="padding: 10px;"><?php echo $amount; ?> (in words) <?php echo $wmount; ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 10px; width: 30%;">To be paid before</th>
                                        <td style="padding: 10px;"><?php echo date('d M, Y', $date_to_pay); ?></td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 10px; width: 30%;">Purpose of Loan</th>
                                        <td style="padding: 10px;"><?php echo $category; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: center;">
                                <h4 style="font-weight: bold;">( Note: Can only apply a maximum of three times of your qualified contributions )</h4>
                            </div>
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: left;">
                                <p>
                                    I hereby declare that the foregoing particulars are true to the best of my Knowledge and belief and agree to abide 
                                    to the by-laws of the society, the Loan policy and variations by the Credut Committee in respect of the said loan<br /><br />
                                    I declare that I'm not indebted to any other Credit Society, Bank or Loan agency except as listed herein, either as a borrow or 
                                    endorser. Ufami sacco reserves the right to review/alter/amend the interest rate, penalty Interest and all fees and Commissions
                                    charged subsequent to such change. The borrower expessly consents and allows the Sacco to forward personal data and full file 
                                    credit information to lincensed credit refernce bureaus in accordance with the Banking (<strong>Credit Refence Bureaus</strong>)
                                    Regulations, 2013
                                </p>
                                <br /><br /><br />
                                <strong style="float: left;">APPLICANT SIGNATURE: ............................................</strong>
                                <strong style="float: right;">DATE: ............................................</strong>
                            </div>
                            <br /><br />
                            <div style="display: table; width: 100%; height: auto; padding-top: 5px; padding-bottom: 5px; text-align: left;">
                                <h3 style="color: #000;"><u>REPAYMENT GUARANTEE</u></h3>
                                <p>
                                    We the undersigned hereby accept jointly and severally liability for the repayment of the loan in the event of the borrower's defaults.
                                    We understand that the amount in default may be rcovered by an offset against our shares and contributions in the Society, as hereby guaranteed 
                                    and we shall not be eligible for loans unless the amount in default has been cleared in full.
                                </p>
                                <table border="1" style="width: 100%;">
                                    <tr>
                                        <th style="padding: 7px;">Member No.</th>
                                        <th style="padding: 7px;">Phone No.</th>
                                        <th style="padding: 7px;">Full Names</th>
                                        <th style="padding: 7px;">Guaranteed Amount</th>
                                        <th style="padding: 7px;">Signature</th>
                                    </tr>
                                    <?php foreach($guarantor as $fetch): ?>
                                    <tr>
                                        <td style="padding: 7px; ">M/No <?php echo $fetch['member_id']; ?></td>
                                        <td style="padding: 7px; "><?php echo $fetch['phone']; ?></td>
                                        <td style="padding: 7px; "><?php echo $fetch['name']; ?></td>
                                        <td style="padding: 7px; "> </td>
                                        <td style="padding: 7px; width: 100px;"></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                                <hr />
                                <p style="display: table; width: 100%; ">
                                    <strong style="float: left;">WITNESS SIGNATURE: ............................................</strong>
                                    <strong style="float: right;">DATE: ............................................</strong>
                                </p><br />
                                <p style="display: table; width: 100%; ">
                                    <strong style="float: left;">WITNESS NAME: ............................................</strong>
                                    <strong style="float: right;">MEMBER NO: ............................................</strong>
                                </p>
                                
                                <h3 style="color: #000;"><u>FOR OFFICIAL USE ONLY</u></h3>
                                <p style="font-weight: bold;">
                                    Loan Registration Details:.....<br />
                                    (A brief summary of the Loan applied for by the office including the guarantors)
                                </p>
                                <br /><br /><br />
                                <p style="display: table; width: 100%; ">
                                    <strong style="float: left;">Registered by: ............................................</strong>
                                    <strong style="float: right;">Sign: ............................................</strong>
                                </p><br />
                                <p style="display: table; width: 100%; ">
                                    <strong style="float: left;">Date & Stamp: ............................................</strong>
                                    <strong style="float: right;">Reg No: ............................................</strong>
                                </p>
                                
                                <h3 style="color: #000;"><u>CREDIT COMMITTEE</u></h3>
                                <p>
                                    We have examined the above application in cconjunction with the loan appraisal and decided as follows:-
                                    <ul>
                                        <li style="list-style: lower-latin;">
                                            Loan approved Kshs <span style="border-bottom: 1px dotted #000;">
                                            <?php echo $amount; ?></span> Recoverable in <?php echo $period; ?> Monthly Installments of Kshs .............
                                            @ a flat rate / reducing balance rate of ..........
                                        </li>
                                        <br />
                                        <li style="list-style: lower-latin;">
                                            Deferred/Rejected for the following reasons ................................................................
                                            ..................................................................<br />
                                            In addition, the Treasurer/Accountant is hereby requested and authorized to do a cheque/fund transfer for the above
                                            amount
                                        </li>
                                    </ul>
                                </p>
                                <p style="display: table; width: 100%; ">
                                    <strong style="display: inline-table; width: 30%; text-align: center;">.......................<br />Chairperson</strong>
                                    <strong style="display: inline-table; width: 30%; text-align: center;">.......................<br />Secretary</strong>
                                    <strong style="display: inline-table; width: 30%; text-align: center;">.......................<br />Member</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
			<footer class="main">
				<div class="pull-right"> <strong>This form is automatically generated</strong></div>
				&copy; <?php echo date('Y'); ?> <strong>Ufami Sacco</strong> <small>Your financial base</small>
			</footer>
		</div>
        
        <?php include 'chat.php'; ?>

	</div>
	
    <?php include 'modal.php'; ?>
    
    <?php include 'footer.php'; ?>
</body>

</html>
<script>
    $(document).ready(function(){
        print('#printform');
    });
</script>