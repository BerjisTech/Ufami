<div class="profile-env">
	<header class="row">
		<div class="col-sm-2" style="height: 100px !important;"></div>
		<div class="col-sm-10">
			<ul class="profile-info-sections">
				<li>
					<div class="profile-name"> <strong> <a href="#"><?php echo $details->name; ?></a> <a href="#"
								class="user-status is-online tooltip-primary" data-toggle="tooltip"
								data-placement="top" data-original-title="Online"></a> </strong> <span><a
								href="#">Member number <?php echo $details->member_id; ?></a></span> </div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($this->db->select('sum(amount) as amount')->where('member', $details->member_id)->where('type', '1')->get('contributions')->row()->amount); ?></h3> <span><a href="#">Savings</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($this->db->select('sum(amount) as amount')->where('member', $details->member_id)->where('type', '2')->get('contributions')->row()->amount); ?></h3> <span><a href="#">Shares</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($this->db->select('sum(amount) as amount')->where('member', $details->member_id)->where('status', '0')->get('loans')->row()->amount); ?></h3> <span><a href="#">Pending Loans</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($this->db->select('sum(amount) as amount')->where('member', $details->member_id)->where('status', '1')->get('loans')->row()->amount); ?></h3> <span><a href="#">UnPaid Loans</a></span>
					</div>
				</li>
				<li>
					<div class="profile-stat">
						<h3><?php echo number_format($this->db->select('sum(amount) as amount')->where('member', $details->member_id)->where('status', '4')->get('loans')->row()->amount); ?></h3> <span><a href="#">Paid Loans</a></span>
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
                            <?php echo $details->phone; ?> </a> </li>
					<li> <a href="#"> <i class="entypo-calendar"></i>
							<?php echo date('F, Y', $details->date_joined)?>
						</a> </li>
                    <li>
                        <a style="color: #fff;" href="<?php echo base_url(); ?>member_report/payments/<?php echo $details->member_id; ?>" target="_BLANK" class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-print"></i>Print Report</a></li>
				</ul> <!-- tabs for the profile links -->
				<ul class="nav nav-tabs right-aligned">
                    <!-- available classes "bordered", "right-aligned" -->
                    <li class="active"><a href="#home-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-home"></i></span> <span class="hidden-xs">Savings</span> </a> </li>
                    <li> <a href="#profile-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-user"></i></span> <span class="hidden-xs">Shares</span> </a>
                    </li>
                    <li> <a href="#messages-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-mail"></i></span> <span class="hidden-xs">Loans</span> </a>
                    </li>
                    <li style="display: none;"> <a href="#settings-2" data-toggle="tab"> <span class="visible-xs"><i
                                    class="entypo-cog"></i></span> <span class="hidden-xs">Settings</span> </a>
                    </li>
                </ul>
			</div>
		</div>
	</section>
	<section class="profile-feed">
        <div class="tab-content">
            <div class="tab-pane active" id="home-2">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var $table1 = jQuery('#table-1');
                        // Initialize DataTable
                        $table1.DataTable({
                            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            "bStateSave": true
                        });
                        // Initalize select Dropdown after DataTables is created
                        $table1.closest('.dataTables_wrapper').find('select').select2({
                            minimumResultsForSearch: -1
                        });
                    });
                </script>
                <table class="table table-bordered datatable" id="table-1">
                    <thead>
                        <tr>
                            <th data-hide="phone">Transaction Number</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($savings as $saving): ?>
                        <tr>
                            <td><?php echo $saving['contribution_id']; ?></td>
                            <td><?php echo $saving['amount']; ?></td>
                            <td>
                                <?php if($saving['method'] == '1'){ echo 'Cash'; }; ?>
                                <?php if($saving['method'] == '2'){ echo 'Mpesa'; }; ?>
                                <?php if($saving['method'] == '3'){ echo 'Bank Transfer'; }; ?>
                                <?php if($saving['method'] == '4'){ echo 'Cheque'; }; ?>
                            </td>
                            <td><?php echo date('d M, Y', $saving['date']); ?></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th data-hide="phone">Transaction Number</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table> <br />
            </div>
            <div class="tab-pane" id="profile-2">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var $table1 = jQuery('#table-2');
                        // Initialize DataTable
                        $table1.DataTable({
                            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            "bStateSave": true
                        });
                        // Initalize select Dropdown after DataTables is created
                        $table1.closest('.dataTables_wrapper').find('select').select2({
                            minimumResultsForSearch: -1
                        });
                    });
                </script>
                <table class="table table-bordered datatable" id="table-2">
                    <thead>
                        <tr>
                            <th data-hide="phone">Transaction Number</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($shares as $saving): ?>
                        <tr>
                            <td><?php echo $saving['contribution_id']; ?></td>
                            <td><?php echo $saving['amount']; ?></td>
                            <td>
                                <?php if($saving['method'] == '1'){ echo 'Cash'; }; ?>
                                <?php if($saving['method'] == '2'){ echo 'Mpesa'; }; ?>
                                <?php if($saving['method'] == '3'){ echo 'Bank Transfer'; }; ?>
                                <?php if($saving['method'] == '4'){ echo 'Cheque'; }; ?>
                            </td>
                            <td><?php echo date('d M, Y', $saving['date']); ?></td>
                            <td></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th data-hide="phone">Transaction Number</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table> <br />
            </div>
            <div class="tab-pane" id="messages-2">
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var $table1 = jQuery('#table-3');
                        // Initialize DataTable
                        $table1.DataTable({
                            "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                            "bStateSave": true
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
                            <th>M/No</th>
                            <th>Amount</th>
                            <th>Guarantors</th>
                            <th>Date Taken</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($loans as $fetch): ?>
                        <tr id="loan<?php echo $fetch['loan_id']; ?>">
                            <td><?php echo $fetch['member']; ?></td>
                            <td><?php echo $fetch['amount']; ?></td>
                            <td>
                                <?php echo $this->db->where('member_id', $fetch['g1'])->get('members')->row()->name; ?><br />
                                <?php echo $this->db->where('member_id', $fetch['g2'])->get('members')->row()->name; ?><br />
                                <?php echo $this->db->where('member_id', $fetch['g3'])->get('members')->row()->name; ?><br />
                                <?php echo $this->db->where('member_id', $fetch['g4'])->get('members')->row()->name; ?><br />
                            </td>
                            <td><?php echo date('d M, Y', $fetch['date_taken']); ?></td>
                            <td><?php 
                                if($fetch['status'] == '0'){
                                    echo '<span class="btn btn-danger">Pending</span>';
                                }
                                if($fetch['status'] == '1'){
                                    echo '<span class="btn btn-info">Approved</span>';
                                }
                                if($fetch['status'] == '2'){
                                    echo '<span class="btn btn-warning">Rejected</span>';
                                }
                                if($fetch['status'] == '3'){
                                    echo '<span class="btn btn-primary">Recieved</span>';
                                }
                                if($fetch['status'] == '4'){
                                    echo '<span class="btn btn-success">Paid</span>';
                                }
                            ?></td>
                            <td><?php echo $this->db->where('category_id', $fetch['type'])->get('loan_category')->row()->category_name; ?></td>
                            <td>
                                <?php if($fetch['status'] == '0'): ?>
                                    <span class="entypo-trash btn btn-danger" style="cursor: pointer;" onclick="delete_loan(<?php echo $fetch['loan_id']; ?>);"></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>M/No</th>
                            <th>Amount</th>
                            <th>Guarantors</th>
                            <th>Date Taken</th>
                            <th>Status</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table> <br />
            </div>
            <div class="tab-pane" id="settings-2">
                Settings Tab
            </div>
        </div> <br />
	</section>
</div>
<div></div>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
<script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
<script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>