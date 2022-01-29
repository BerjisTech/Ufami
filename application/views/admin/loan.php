<div class="profile-env">
	<header class="row">
		<div class="col-sm-2" style="height: 100px !important;"></div>
		<div class="col-sm-10">
			<ul class="profile-info-sections">
				<li>
					<div class="profile-name"> <strong> <a href="#"><?php echo $loan->name; ?></a></strong> <span><a
								href="#">Member number <?php echo $loan->member_id; ?></a></span>
                                <?php if(time() > $loan->date_to_pay && $loan->date_paid < $loan->date_to_pay){ echo '<td><span style="color: #ac1818; font-size: 13px; font-weight: bold;" ><i class="fa fa-money"></i> Defaulted</span></td>'; } ?>
                                <?php if(time() > $loan->date_to_pay && $loan->date_paid == '0'){ echo '<td><span style="color: #ac1818; font-size: 13px; font-weight: bold;" ><i class="fa fa-money"></i> Defaulted</span></td>'; } ?> </div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php 
                                if($loan->status == '0'){
                                    echo 'Pending';
                                }
                                if($loan->status == '1'){
                                    echo 'Approved';
                                }
                                if($loan->status == '2'){
                                    echo 'Rejected';
                                }
                                if($loan->status == '3'){
                                    echo 'Recieved';
                                }
                                if($loan->status == '4'){
                                    echo 'Paid';
                                }
                            ?></h3> <span><a href="#">Status</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($loan->lamount); ?></h3> <span><a href="#">Amount Taken</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($loanpaid); ?></h3> <span><a href="#">Amount Paid</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($loan->amountdue); ?></h3> <span><a href="#">Amount Due</a></span>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<section class="profile-info-tabs">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-10">
				<ul class="user-details">
					<li> <a href="#"> <i class="entypo-suitcase"></i>
                            <?php echo $loan->phone; ?> </a> </li>
					<li> <a href="#"> <i class="entypo-calendar"></i>
							<?php echo date('F, Y', $loan->date_joined)?>
						</a> </li>
				</ul> <!-- tabs for the profile links -->
				<ul class="nav nav-tabs right-aligned">
                    <!-- available classes "bordered", "right-aligned" -->
                    <li class="active"><a href="#home-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-home"></i></span> <span class="hidden-xs">Loan Details</span> </a> </li>
                    <li> <a href="#profile-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-user"></i></span> <span class="hidden-xs">Guarantors</span> </a>
                    </li>
                    <li> <a href="#messages-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-mail"></i></span> <span class="hidden-xs">Payment</span> </a>
                    </li>
                </ul>
			</div>
		</div>
	</section>
	<section class="profile-feed">
        <div class="tab-content">
            <div class="tab-pane active" id="home-2">
                <div class="row">
                    <h3><?php echo $loan->category_name; ?></h3>
                    <hr />
                    <div class="col-sm-8">
                        To be fully paid by <?php echo $loan->period; ?> months<br />
                        Interest: <?php echo $loan->interest; ?><br />
                        Guarantorship: <?php if($loan->guarantorship == '1'): echo 'A must'; elseif($loan->guarantorship == '2'): echo 'Depending on Amount'; else: echo 'N/A'; endif; ?><br />
                        Requirements: <?php echo $loan->requirements; ?><br />
                        Amount viable: <?php echo $loan->camount; ?> (<?php echo number_format($this->db->select('sum(amount) as max')->where('member', $loan->member)->where('type', '1')->get('contributions')->row()->max * 3); ?>)
                    </div>
                    <div class="col-sm-4">
                        <a href="<?php echo base_url(); ?>member_report/loans/<?php echo $loan->loan_id; ?>" target="_BLANK" class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-print"></i>Print Report</a><br /><br />
                        <div class="btn btn-primary">
                            <div>Loan Borrowed on: <?php echo date('d M, Y', $loan->date_taken); ?></div>
                        </div><br /><br />
                        <div class="btn btn-info">
                            <div>Loan To be fully paid on: <?php echo date('d M, Y', $loan->date_to_pay); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="profile-2">
                <div class="row">
                <?php
                    foreach($this->db->where('member_id', $loan->g1)->or_where('member_id', $loan->g2)->or_where('member_id', $loan->g3)->or_where('member_id', $loan->g4)->get('members')->result_array() as $fetch):
                        ?>
                            <div class="col-sm-3"> 
                                <div class="tile-progress tile-blue"> 
                                    <div class="tile-header"> 
                                        <h3><?php echo $fetch['name']; ?></h3> 
                                        <span>Member number <?php echo $fetch['member_id']; ?></span> 
                                    </div> 
                                    <div class="tile-progressbar"> 
                                        <span data-fill="<?php 
                                            $alloans = $this->db->get('loans')->num_rows();
                                            $myloans = $this->db->where('g1', $fetch['member_id'])->or_where('g2', $fetch['member_id'])->or_where('g3', $fetch['member_id'])->or_where('g4', $fetch['member_id'])->get('loans')->num_rows();
                                            $avgloans = ($myloans*100)/$alloans;
                                            echo $avgloans;
                                        ?>%"></span> 
                                    </div> 
                                    <div class="tile-footer"> 
                                        <span>Has Guarantored</span>
                                        <h4><span class="pct-counter">0</span>%</h4> 
                                        <span>of all Loans disbursed</span> 
                                    </div> 
                                </div> 
                            </div>
                        <?php 
                    endforeach;
                ?>
                </div>
            </div>
            <div class="tab-pane" id="messages-2">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var $table1 = jQuery('#table-3');
                        // Initialize DataTable
                        $table1.DataTable({
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'excelHtml5',
                                'csvHtml5',
                                'pdfHtml5',
                                'print'
                            ]
                        });
                        // Initalize select Dropdown after DataTables is created
                        $table1.closest('.dataTables_wrapper').find('select').select2({
                            minimumResultsForSearch: -1
                        });
                    });
                </script>
                <table class="table table-bordered datatable" id="table-3">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paymentdetails as $fetch): ?>
                        <tr>
                            <td><?php echo $fetch['amount']; ?></td>
                            <td><?php echo date('d M, Y', $fetch['date']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td><strong>Balance</strong>:<br /> <?php echo number_format($loan->amountdue); ?></td>
                            <td>To be fully paid on:<br /> <?php echo date('d M, Y', $loan->date_to_pay); ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table> <br />
            </div>
        </div> <br />
	</section>
</div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
<script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
<script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>
<script>
    $(document).ready(function(){
        document.title = '<?php echo $loan->name; ?>\'s Loan Payments for Loan Number <?php echo number_format($loan->loan_id); ?>';
        $('.recieptfilter').submit(function(e){
            e.preventDefault();
            window.location.href = base_url + 'reciepts/' + $('.month').val() + $('.year').val();
        });
    });
</script>