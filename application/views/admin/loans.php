            <h3>Ufami Loans</h3> <br />
            <button onclick="$('.custompane').toggle(700); $('.customwrapper').toggle(500);" class="btn btn-primary pull-right">Request Loan</button>
            <a href="<?php echo base_url(); ?>loan_report/<?php echo sha1(md5(time())); ?>" target="_BLANK" class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-print"></i>Print Loans Report</a>
            <div class="row">
                <div class="col-sm-12">
                    <br />
                    <div class="panel panel-primary" data-collapsed="1" style="box-shadow: 0px 0px 10px rgba(2, 2, 2, 0.1);">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <strong>Ufami Loans</strong>
                            </div>
                            <div class="panel-options"> <a href="#"
                                data-rel="collapse"><i class="entypo-down-open"></i></a> 
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <?php foreach($this->db->get('loan_category')->result_array() as $fetch): ?>
                                <div class="col-sm-4">
                                    <div class="tile-progress tile-<?php 
                                            
                                            $thiscolor = 'c'.$fetch['category_id'].mt_rand(1, 10);

                                            if($thiscolor == 'c'.$fetch['category_id'].'1'){ echo 'blue'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'2'){ echo 'purple'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'3'){ echo 'pink'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'4'){ echo 'cyan'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'5'){ echo 'plum'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'6'){ echo 'red'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'7'){ echo 'brown'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'8'){ echo 'aqua'; }
                                            if($thiscolor == 'c'.$fetch['category_id'].'9'){ echo 'orange'; }

                                        ?>">
                                        <div class="tile-header">
                                            <h3><?php echo $fetch['category_name']; ?></h3>
                                        </div>
                                        <div class="tile-progressbar tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php 
                                        $totalloans = $this->db->get('loans')->num_rows();
                                        $theseloans = $this->db->where('type', $fetch['category_id'])->get('loans')->num_rows();

                                        $percentage = (($theseloans*100)/$totalloans);

                                        echo number_format($percentage);

                                    ?>%"> <span data-fill="<?php 
                                            echo number_format($percentage);
                                        ?>%"></span> </div>
                                        <div class="tile-footer"> 
                                            <ul style="text-align: left;">
                                                <li>Period: <?php echo $fetch['period']; ?> months</li>
                                                <li>Amount: <?php echo $fetch['amount']; ?></li>
                                                <li>Interest: <?php echo $fetch['interest']; ?></li>
                                                <li>Guarantorship: <?php if($fetch['guarantorship'] == '1'): echo 'A must'; elseif($fetch['guarantorship'] == '2'): echo 'Depending on Amount'; else: echo 'N/A'; endif; ?></li>
                                                <li>Requirements: <?php echo $fetch['requirements']; ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br />
                    <div class="panel panel-primary" data-collapsed="1" style="box-shadow: 0px 0px 10px rgba(2, 2, 2, 0.1);">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <strong>General Loan Form</strong>
                            </div>
                            <div class="panel-options"> <a href="#"
                                data-rel="collapse"><i class="entypo-down-open"></i></a> 
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function ($) {
                                        var $table4 = jQuery("#table-1");
                                        $table4.DataTable({
                                            dom: 'Bfrtip',
                                            buttons: [
                                                'copyHtml5',
                                                'excelHtml5',
                                                'csvHtml5',
                                                'pdfHtml5'
                                            ]
                                        });
                                    });
                                </script>
                                <table class="table table-bordered datatable" style="background: #fff;" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>S/No</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>M/No</th>
                                            <th>Repay</th>
                                            <th>Principal</th>
                                            <th>Interest</th>
                                            <th>Totals</th>
                                            <th>Last Date<br /> Due</th>
                                            <th>Amount<br /> Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($loans as $key => $load): ?>
                                            <tr>
                                                <td><?php echo $load['loan_id']; ?></td>
                                                <td><?php echo date('d M, Y', $load['date_taken']); ?></td>
                                                <td><?php echo ucwords($this->db->where('member_id', $load['member'])->get('members')->row()->name); ?></td>
                                                <td><?php echo $load['member']; ?></td>
                                                <td><?php echo number_format($this->db->select('sum(amount) as total')->where('loan_id', $load['loan_id'])->get('loan_payments')->row()->total); ?></td>
                                                <td><?php echo number_format($load['amount']); ?></td>
                                                <td>
                                                    <?php
                                                        
                                                            if($load['type'] == 1 || $load['type'] == 4 || $load['type'] == 5){
                                                                foreach($this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->result_array() as $key => $fetch): 
                                                                    if($key == 0){
                                                                        $interest[$key] = $load['amount']*0.01;
                                                                        $amdue = $load['amount'] + $interest[$key];
                                                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                                                        echo $interest[$key];
                                                                        echo ' month ';
                                                                        echo $key + 1;
                                                                        echo '('. date('M', $fetch['date']) .')';
                                                                        echo '<br />';
                                                                    }else{
                                                                        $interest[$key] = $amtdue[$key - 1]*0.01;
                                                                        $amdue = $amtdue[$key - 1] + $interest[$key];
                                                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                                                        echo $interest[$key];
                                                                        echo ' month ';
                                                                        echo $key + 1;
                                                                        echo '('. date('M', $fetch['date']) .')';
                                                                        echo '<br />';
                                                                    }

                                                                    if($key == $this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1){
                                                                        /*echo number_format(array_sum($interest)).'(Total interests paid)<br />';
                                                                        echo number_format($interest[$this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1]).'(Previous interest)<br />';
                                                                        echo $amtdue[$this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1]*0.01.'(New Interest)';*/
                                                                    }
                                                                endforeach;
                                                            }
                                                            if($load['type'] == 2){
                                                                echo number_format($load['amount']*0.12);
                                                            }
                                                            if($load['type'] == 3 || $load['type'] == 7){
                                                                echo number_format($load['amount']*0.1);
                                                            }
                                                            if($load['type'] == 6){
                                                                echo number_format($load['amount']*0.15);
                                                            }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        
                                                            if($load['type'] == 1 || $load['type'] == 4 || $load['type'] == 5){
                                                                foreach($this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->result_array() as $key => $fetch): 
                                                                    if($key == 0){
                                                                        $interest[$key] = $load['amount']*0.01;
                                                                        $amdue = $load['amount'] + $interest[$key];
                                                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                                                    }else{
                                                                        $interest[$key] = $amtdue[$key - 1]*0.01;
                                                                        $amdue = $amtdue[$key - 1] + $interest[$key];
                                                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                                                    }

                                                                    if($key == $this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1){
                                                                        echo number_format($load['amount'] + array_sum($interest)).'<br />Increases on<br /> on 1% of reducing balances';
                                                                    }
                                                                endforeach;
                                                            }
                                                            if($load['type'] == 2){
                                                                echo number_format($load['amount'] + ($load['amount']*0.12));
                                                            }
                                                            if($load['type'] == 3 || $load['type'] == 7){
                                                                echo number_format($load['amount'] + ($load['amount']*0.1));
                                                            }
                                                            if($load['type'] == 6){
                                                                echo number_format($load['amount'] + ($load['amount']*0.15));
                                                            }
                                                    ?>
                                                </td>
                                                <td><?php echo date('d M, Y', $load['date_to_pay']); ?></td>
                                                <td><?php echo number_format($load['amountdue']); ?></td>
                                            </tr>                         
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <br />
                    <div class="panel panel-primary" data-collapsed="0" style="box-shadow: 0px 0px 10px rgba(2, 2, 2, 0.1);">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <strong>General Loan Details</strong>
                            </div>
                            <div class="panel-options"> <a href="#"
                                data-rel="collapse"><i class="entypo-down-open"></i></a> 
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function ($) {
                                        var $table4 = jQuery("#table-4");
                                        $table4.DataTable({
                                            dom: 'Bfrtip',
                                            buttons: [
                                                'copyHtml5',
                                                'excelHtml5',
                                                'csvHtml5',
                                                'pdfHtml5',
                                                'print'
                                            ]
                                        });
                                    });
                                </script>
                                <div style="display: table; width: 100%; height: 10px;"></div>
                                <table class="table table-bordered datatable" style="background: #fff;" id="table-4">
                                    <thead>
                                        <tr>
                                            <th>M/No</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Guarantors</th>
                                            <th>Date Taken</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="loanrequestlistbody">
                                        <?php foreach($loans as $key => $fetch): ?>
                                        <tr 
                                            <?php
                                                if(time() > $fetch['date_to_pay'] && $fetch['date_paid'] < $fetch['date_to_pay']){ 
                                                    echo 'class="danger bg-danger tooltip-danger" style="color: #000; font-weight: bold;" data-toggle="tooltip" data-title="Defaulted.  '.$this->db->where('member_id', $fetch['member'])->get('members')->row()->name.' was suppossed to have paid fully by '.date('d M, Y', $fetch['date_to_pay']).'"'; 
                                                }
                                                if(time() > $fetch['date_to_pay'] && $fetch['date_paid'] == '0'){ 
                                                    echo 'class="danger bg-danger tooltip-danger" style="color: #000; font-weight: bold;" data-toggle="tooltip" data-title="Defaulted.  '.$this->db->where('member_id', $fetch['member'])->get('members')->row()->name.' was suppossed to have paid fully by '.date('d M, Y', $fetch['date_to_pay']).'"'; 
                                                } ?> id="loan<?php echo $fetch['loan_id']; ?>">
                                            <td><?php echo $fetch['member']; ?></td>
                                            <td><?php echo $this->db->where('member_id', $fetch['member'])->get('members')->row()->name; ?></td>
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
                                                    echo '<span class="btn btn-danger btn-sm btn-icon icon-left"> <i class="fa fa-times"></i>Pending</span>';
                                                }
                                                if($fetch['status'] == '1'){
                                                    echo '<span class="btn btn-info btn-sm btn-icon icon-left"> <i class="fa fa-check"></i>Approved</span>';
                                                }
                                                if($fetch['status'] == '2'){
                                                    echo '<span class="btn btn-warning btn-sm btn-icon icon-left"> <i class="fa fa-times"></i>Rejected</span>';
                                                }
                                                if($fetch['status'] == '3'){
                                                    echo '<span class="btn btn-primary btn-sm btn-icon icon-left"> <i class="fa fa-check"></i>Recieved</span>';
                                                }
                                                if($fetch['status'] == '4'){
                                                    echo '<span  class="btn btn-success btn-sm btn-icon icon-left"> <i class="fa fa-check"></i>Paid</span>';
                                                }
                                            ?></td>
                                            <td><?php echo $this->db->where('category_id', $fetch['type'])->get('loan_category')->row()->category_name; ?></td>
                                            <td>
                                                <?php if($fetch['status'] != '4'): ?>
                                                    <span onclick="showAjaxPayModal('<?php echo $fetch['loan_id']; ?>');" class="btn btn-info btn-sm btn-icon icon-left"> <i class="fa fa-money"></i>Pay</span>
                                                <?php endif; ?>
                                                <?php if($fetch['status'] != '0'): ?>
                                                    <a href="<?php echo base_url(); ?>member_report/loans/<?php echo $fetch['loan_id']; ?>" target="_BLANK" class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-print"></i>Print Report</a>
                                                <?php endif; ?>
                                                <span onclick="window.location.href=base_url + 'loan/<?php echo $fetch['loan_id']; ?>'" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
                                                <?php if($fetch['status'] == '0'): ?>
                                                    <span style="cursor: pointer;" onclick="approve_loan(<?php echo $fetch['loan_id']; ?>);"class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-check"></i>Approve</span>
                                                    <span class="entypo-trash btn btn-danger" style="cursor: pointer;" onclick="delete_loan(<?php echo $fetch['loan_id']; ?>);"></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>M/No</th>
                                            <th>Name</th>
                                            <th>Amount</th>
                                            <th>Guarantors</th>
                                            <th>Date Taken</th>
                                            <th>Status</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <br />
            <div class="customwrapper" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);" style="display: none; width: 100vw; height: 100vh; background: rgba(2, 2, 2, 0.4); position: fixed; top: 0px; left: 0px;"></div>
            <div class="custompane" style="display: none; width: 70%; height: 100vh; background: #fff; position: fixed; right: 0px; top: 0px; overflow: auto;">
                <span class="btn btn-danger fa fa-times pull-right fa-2x" style="margin: 20px;" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);$('.categoryform').hide();$('.requestform').hide();$('.choiceform').show();"></span>
                <div class="choiceform" style="text-align: center; padding-top: 45vh;">
                    <span class="btn btn-primary" onclick="$('.requestform').toggle(600);$('.choiceform').toggle(500);" style="font-size: 25px;">Add Loan Request</span>
                    <span class="btn btn-info" onclick="$('.categoryform').toggle(600);$('.choiceform').toggle(500);" style="font-size: 25px;">Add Loan category</span>
                </div>
                <div class="categoryform" style="display: none;">
                    <span class="btn btn-primary pull-left fa-2x" style="margin: 20px;" onclick="$('.categoryform').hide();$('.requestform').show();$('.choiceform').hide();">Add Loan Request</span>
                    <div style="display: table; width: 100%; height: 10px;"></div>
                    <h1 style="padding-left: 20px;">Loan Category Form</h1>
                    <form class="loancategoryform" method="POST">
                        <div class="form-group col-md-6">
                            <label>Category Name</label>
                            <input autocomplete="off" name="name" type="text" class="form-control" placeholder="Loan Category Name" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category Amount</label>
                            <input autocomplete="off" name="amount" type="text" class="form-control" placeholder="Loan Amount" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Loan Duration in Months</label>
                            <input autocomplete="off" name="duration" type="number" class="form-control" placeholder="Loan Duration" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Loan Interest</label>
                            <input autocomplete="off" name="interest" type="text" class="form-control" placeholder="Loan Interest" />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Loan Guarantorship</label>
                            <select autocomplete="off" name="guarantorship" type="text" class="form-control">
                                <optgroup label="Loan Guarantorship">
                                    <option value="1">A Must</option>
                                    <option value="2">Depending on the amount</option>
                                    <option value="3">N/A</option>
                                </optgroup>
                            </select autocomplete="off">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Loan Requirements</label>
                            <input autocomplete="off" name="requirements" type="text" class="form-control" placeholder="Loan Requirements" />
                        </div>
                        <div class="form-group col-md-6">
                            <span style="display: table; width: width: 100%; height: 23px;"></span>
                            <input autocomplete="off" name="submit" type="submit" class="btn btn-primary" placeholder="Create New Category" />
                        </div>
                    </form>
                </div>
                <div class="requestform" style="display: none;">
                    <span class="btn btn-primary pull-left fa-2x" style="margin: 20px;" onclick="$('.categoryform').show();$('.requestform').hide();$('.choiceform').hide();">Add Loan Category</span>
                    <div style="display: table; width: 100%; height: 10px;"></div>
                    <h1 style="padding-left: 20px;">Loan Request Form</h1>
                    <form class="loanrequestform" name="contributionform" method="POST">
                        <div class="form-group col-xs-12">
                            <label>Loan Type</label>
                            <select autocomplete="off" name="type" class="form-control type" data-allow-clear="true"
                                data-placeholder="Loan Type...">
                                <option></option>
                                <optgroup label="Ufami Loans">
                                    <?php foreach($this->db->get('loan_category')->result_array() as $fetch): ?>
                                    <option value="<?php echo $fetch['category_id']; ?>"><?php echo $fetch['category_name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select autocomplete="off">
                        </div>
                        <div class="form-group col-xs-12">
                            <label>Member</label>
                            <select autocomplete="off" name="member" class="select2 memberselector" data-allow-clear="true"
                                data-placeholder="Select member...">
                                <option></option>
                                <optgroup label="Ufami Members">
                                    <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                    <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select autocomplete="off">
                        </div>
                        <div class="form-group col-xs-12 guarantorls" style="display: none;">
                            <label class="col-xs12">Guarantors</label>
                            <div>
                                <select autocomplete="off" name="g1" class="select2 col-sm-3" data-allow-clear="true"
                                    data-placeholder="First Guarantor...">
                                    <option></option>
                                    <optgroup label="Select Guarantor">
                                        <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                        <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select autocomplete="off">
                                <select autocomplete="off" name="g2" class="select2 col-sm-3" data-allow-clear="true"
                                    data-placeholder="Second Guarantor...">
                                    <option></option>
                                    <optgroup label="Select Guarantor">
                                        <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                        <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select autocomplete="off">
                                <select autocomplete="off" name="g3" class="select2 col-sm-3" data-allow-clear="true"
                                    data-placeholder="Third Guarantor...">
                                    <option></option>
                                    <optgroup label="Select Guarantor">
                                        <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                        <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select autocomplete="off">
                                <select autocomplete="off" name="g4" class="select2 col-sm-3" data-allow-clear="true"
                                    data-placeholder="Fourth Guarantor...">
                                    <option></option>
                                    <optgroup label="Fourth Guarantor">
                                        <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                        <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Amount Requested</label>
                            <input autocomplete="off" class="form-control amount" type="number" name="amount" placeholder="Amount" required />
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Application Fee</label>
                            <input autocomplete="off" class="form-control amount" type="number" name="loanapplication" placeholder="Application Fee" required />
                        </div>
                        <div class="form-group col-xs-12 requirementtext">
                            <label>Requirement</label>
                            <input autocomplete="off" name="requirement" type="file" class="reqirement form-control" placeholder="Requirement" />
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Date Requested</label>
                            <input autocomplete="off" type="text" name="date" class="date datepicker form-control" data-format="dd MM yyyy" data-start-date="-2y" data-end-date="+0d" placeholder="<?php echo date('d F Y'); ?>">
                        </div>
                        <div class="form-group col-xs-6">
                            <label>Date To Pay</label>
                            <input autocomplete="off" type="text" name="repay" class="date datepicker form-control" data-format="dd MM yyyy" placeholder="<?php echo date('d F Y'); ?>">
                        </div>
                        
                        <div class="form-group col-sm-12">
                            <input autocomplete="off" class="btn btn-primary pull-right" type="submit" name="submit" value="Request Loan" required />
                        </div>
                    </form>
                </div>
                <br />
            </div>
            
            <div class="modal fade" id="large-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header" style="padding: 25px;">
                        <h4 class="modal-title" id="large-modal-label">Large modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form class="loanpaymentform">
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <input type="number" style="padding: 10px; border-radius: 7px 0px 0px 7px;" name="loan_id" class="loan_id col-xs-1" value="" />
                                    <input type="number" style="padding: 10px; border-radius: 0px;" name="loanamount" class="loanamount col-xs-5" placeholder="Amount" />
                                    <input type="date" style="padding: 10px; border-radius: 0px;" name="loanpayday" class="loanpayday col-xs-5" placeholder="Date" />
                                    <input type="submit" style="padding: 12px; border-radius: 0px 7px 7px 0px; border: none;" name="submit" class="primary btn-primary col-xs-1" value="Pay" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterangepicker/daterangepicker-bs3.css" id="style-resource-4">
            <script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
            <script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>

            <script>
                $(document).ready(function(){
                    $('.loancategoryform').submit(function(e){
                        e.preventDefault();
                        
                        $.ajax({
                            url: base_url + 'newloancategory',
                            data: $('.loancategoryform').serialize(),
                            method: 'POST',
                            dataType: 'text',
                            success: function(response){
                                setTimeout(function(){
                                    $('.loancategoryform')[0].reset();
                                    $('.custompane').toggle(500);
                                    $('.customwrapper').toggle(700);
                                    toastr.success('New category succesfully added', 'success');
                                }, 2000);
                            },
                            error: function(){
                                toastr.warning("Could not make contribution", "Error");
                                $('.loancategoryform')[0].reset();
                            }
                        });
                    });

                    $('.type').change(function(){
                        if($('.type').val() == '7'){
                            $('.requirementtext').hide();
                            $(".reqirement").prop('required',false);
                            $('.guarantorls').hide();
                        }
                        if($('.type').val() == '1'){
                            $('.requirementtext').hide();
                            $(".reqirement").prop('required',false);
                            $('.guarantorls').show();
                        }
                        if($('.type').val() == '2'){
                            $(".reqirement").prop('required',true);
                            $('.requirementtext').show();
                            $('.guarantorls').show();
                        }
                        if($('.type').val() == '3'){
                            $(".reqirement").prop('required',true);
                            $('.requirementtext').show();
                            $('.guarantorls').hide();
                        }
                        if($('.type').val() == '4'){
                            $(".reqirement").prop('required',true);
                            $('.requirementtext').show();
                            $('.guarantorls').show();
                        }
                        if($('.type').val() == '5'){
                            $(".reqirement").prop('required',true);
                            $('.requirementtext').show();
                            $('.guarantorls').show();
                        }
                        if($('.type').val() == '6'){
                            $(".reqirement").prop('required',true);
                            $('.requirementtext').show();
                            $('.guarantorls').hide();
                        }
                        if($('.type').val() == '1' || $('.type').val() == '2' || $('.type').val() == '4' || $('.type').val() == '5'){
                            $('.guarantorls').show();
                        }
                    });

                    $('.loanrequestform').submit(function(e){
                        e.preventDefault();
                        $('.formcontentimage').show(600);
                        
                        $.ajax({
                            url: base_url + 'newloanrequest',
                            dataType: 'text',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: new FormData(this), 
                            method  : 'POST',
                            success: function(response){
                                $('.loanrequestlistbody').prepend(response);
                                setTimeout(function(){
                                    $('.formcontentimage').hide(600);
                                }, 2000);
                            },
                            error: function(){
                                toastr.warning("Could not request loan. Please try again", "Error");
                                $('.formcontentimage').hide(600);
                            }
                        });
                    });

                    $('.loanpaymentform').submit(function(e){
                        e.preventDefault();
                        $.ajax({
                            url: base_url + 'loanpayment/' + $('.loan_id').val() + '/' + $('.loanamount').val() + '/' + $('.loanpayday').val(),
                            success: function(response){
                                toastr.success(response, 'Success');
                                setTimeout(function(){
                                    window.location.href = base_url + 'loan/' + $('.loan_id').val();
                                }, 1500);
                            }
                        });
                    });
                });

                function delete_loan(id){
                    if (confirm("Are you sure?")) {
                        toastr.warning('Deleting loan number ' + id , '<span class="fa fa-warning"></span> Danger');
                        $('#loan'+id).css('background', '#ac1818');
                        $('#loan'+id).css('color', '#ffff');
                        $.ajax({
                            url: base_url + 'delete_loan/' + id,
                            success: function(response){
                                toastr.success('Succesfully deleted loan number ' + id, 'Success');
                                $('#loan'+id).hide(500);
                            },
                            error: function(response){
                                setTimeout(function(){
                                    toastr.warning('Could not delete loan number ' + id , '<span class="fa fa-warning"></span> Danger');
                                    $('#loan'+id).css('background', '#fff');
                                    $('#loan'+id).css('color', '#666');
                                }, 2000);
                            }
                        });
                    }
                    return false;
                    
                }

                function approve_loan(id){
                    if (confirm("Are you sure?")) {
                        toastr.info('Approving loan number ' + id , '<span class="fa fa-warning"></span> Danger');
                        $.ajax({
                            url: base_url + 'approve_loan/' + id,
                            success: function(response){
                                toastr.success('Succesfully approved loan number ' + id, 'Success');
                                setTimeout(function(){
                                    window.location.href= base_url + "loans";
                                }, 1000);
                            },
                            error: function(response){
                                setTimeout(function(){
                                    toastr.warning('Could not delete loan number ' + id , '<span class="fa fa-warning"></span> Danger');
                                    $('#loan'+id).css('background', '#fff');
                                    $('#loan'+id).css('color', '#666');
                                }, 2000);
                            }
                        });
                    }
                    return false;
                    
                }

                function showAjaxPayModal(header) {
                    jQuery('#large-modal').modal('show', { backdrop: 'true' });
                    jQuery('#large-modal .modal-title').html('Payment for loan #' + header);

                    jQuery('.loan_id').val(header);
                }
            </script>