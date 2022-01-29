<h3>Ufami Members</h3> <br />
            <button onclick="$('.custompane').toggle(700); $('.customwrapper').toggle(500);" class="btn btn-primary pull-right">Add Contribution</button>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    var $table4 = jQuery("#table-4");
                    $table4.DataTable({
                        //'aLengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        dom: 'Bfrtip',
                        buttons: [
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5',
                            'print',
                            'colvis'
                        ]
                    });
                    $table4.closest( '.dataTables_wrapper' ).find( 'select' ).select2( {
                        minimumResultsForSearch: -1
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
                        <th>Type</th>
                        <th>Date Paid</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="contributionlistbody">
                    <?php foreach($contribution as $key => $fetch): ?>
                    <tr id="contribution<?php echo $fetch['contribution_id']; ?>">
                        <td><?php echo $fetch['member']; ?></td>
                        <td><?php echo $this->db->where('member_id', $fetch['member'])->get('members')->row()->name; ?></td>
                        <td><?php echo $fetch['amount']; ?></td>
                        <td><?php if($fetch['type'] == '1'): echo 'Deposits'; else: echo 'Share Capital'; endif; ?></td>
                        <td><?php echo date('d M, Y', $fetch['date']); ?></td>
                        <td>
                            <span onclick="showAjaxModal('<?php echo base_url().'getcontribution/'.$fetch['contribution_id']; ?>', 'Transaction #<?php echo $fetch['contribution_id']; ?>');" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
                            <span onclick="delete_contribution(<?php echo $fetch['contribution_id']; ?>);" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-trash"></i>Delete</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>M/No</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date Paid</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table> <br />
            <div class="customwrapper" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);" style="display: none; width: 100vw; height: 100vh; background: rgba(2, 2, 2, 0.4); position: fixed; top: 0px; left: 0px;"></div>
            <div class="custompane" style="display: none; width: 70%; height: 100vh; background: #fff; position: fixed; right: 0px; top: 0px;">
                <span class="btn btn-danger fa fa-times pull-right fa-2x" style="margin: 20px;" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);"></span>
                <h1 style="padding-left: 20px;">Make Contribution</h1>
                <form class="contributionform" name="contributionform" method="POST">
                    <div class="form-group col-xs-12">
                        <label>Member</label>
                        <select autocomplete="off" name="member" class="select2" data-allow-clear="true"
                            data-placeholder="Select member...">
                            <option></option>
                            <optgroup label="Ufami Members">
                                <?php foreach($this->db->where('status', '1')->get('members')->result_array() as $fetch): ?>
                                <option value="<?php echo $fetch['member_id']; ?>"><?php echo $fetch['name']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select autocomplete="off">
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Amount deposited</label>
                        <input autocomplete="off" class="form-control amount" type="number" name="amount" placeholder="Amount" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Payment Method</label>
                        <select autocomplete="off" name="method" class="method form-control" data-allow-clear="true"
                            data-placeholder="Select payment method...">
                            <option></option>
                            <optgroup label="Payment methods">
                                <option value="1">Cash</option>
                                <option value="2">MPesa</option>
                                <option value="3">Bank Transfer</option>
                                <option value="4">Cheque</option>
                            </optgroup>
                        </select autocomplete="off">
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Payment Type</label>
                        <select autocomplete="off" name="type" class="type form-control" data-allow-clear="true"
                            data-placeholder="Select payment type...">
                            <option></option>
                            <optgroup label="Payment type">
                                <option value="1">Deposit</option>
                                <option value="2">Share Capital</option>
                            </optgroup>
                        </select autocomplete="off">
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Date Paid</label>
                        <input autocomplete="off" type="text" name="date" class="date datepicker form-control" data-format="dd MM yyyy" data-start-date="-2y" data-end-date="+0d" placeholder="<?php echo date('d F Y'); ?>">
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <input autocomplete="off" class="btn btn-primary pull-right" type="submit" name="submit" value="Make Contribution" required />
                    </div>
                </form><br />
            </div>

            
            <div class="modal fade" id="large-modal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header" style="padding: 25px;">
                        <h4 class="modal-title" id="large-modal-label">Large modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">

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
                    $('.contributionform').submit(function(e){
                        e.preventDefault();
                        $('.formcontentdisplay').hide(500);
                        $('.formcontentimage').show(600);
                        
                        $.ajax({
                            url: base_url + 'newcontribution ',
                            data: $('.contributionform').serialize(),
                            method: 'POST',
                            dataType: 'text',
                            success: function(response){
                                $('.contributionlistbody').prepend(response);
                                setTimeout(function(){
                                    $('.contributionform')[0].reset();
                                    $('.formcontentimage').hide(600);
                                    //$('.custompane').toggle(500);
                                    //$('.customwrapper').toggle(700);
                                }, 2000);
                            },
                            error: function(){
                                toastr.warning("Could not make contribution", "Error");
                                $('.contributionform')[0].reset();
                                $('.formcontentimage').hide(600);
                            }
                        });
                    });
                });
                function delete_contribution(id){
                    if (confirm("Are you sure?")) {
                        toastr.warning('Deleting transaction number ' + id , '<span class="fa fa-warning"></span> Danger');
                        $('#contribution'+id).css('background', '#ac1818');
                        $('#contribution'+id).css('color', '#ffff');
                        $.ajax({
                            url: base_url + 'delete_contribution/' + id,
                            success: function(response){
                                toastr.success('Succesfully deleted transaction number ' + id, 'Success');
                                $('#contribution'+id).hide(500);
                            },
                            error: function(response){
                                setTimeout(function(){
                                    toastr.warning('Could not delete transaction number ' + id , '<span class="fa fa-warning"></span> Danger');
                                    $('#contribution'+id).css('background', '#fff');
                                    $('#contribution'+id).css('color', '#666');
                                }, 2000);
                            }
                        });
                    }
                    return false;
                }

                
                function showAjaxModal(url, header) {
                    jQuery('#large-modal .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="' + base_url + 'assets/images/preloader.gif" style="height:25px;" /></div>');
                    jQuery('#large-modal .modal-title').html('...');
                    jQuery('#large-modal').modal('show', { backdrop: 'true' });

                    $.ajax({
                        url: url,
                        success: function (response) {
                            jQuery('#large-modal .modal-body').html(response);
                            jQuery('#large-modal .modal-title').html(header);
                        }
                    });
                }
            </script>