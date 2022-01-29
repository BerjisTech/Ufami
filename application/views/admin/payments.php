            <h3>Ufami Members</h3> <br />
            <button onclick="$('.custompane').toggle(700); $('.customwrapper').toggle(500);" class="btn btn-primary pull-right">Add Payment</button>
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
                            'print',
                            'colvis'
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
                        <th>Category</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="paymentlistbody">
                    <?php foreach($payment as $key => $fetch): ?>
                    <tr id="payment<?php echo $fetch['payment_id']; ?>">
                        <td><?php echo $fetch['member']; ?></td>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo $fetch['amount']; ?></td>
                        <td><?php echo ucwords($this->db->where('category_id', $fetch['category'])->get('payment_categories')->row()->category_name) ?></td>
                        <td><?php echo $fetch['type']; ?></td>
                        <td><?php echo $fetch['description']; ?></td>
                        <td><?php echo date('d M, Y', $fetch['date']); ?></td>
                        <td>
                            <span onclick="showAjaxModal('<?php echo base_url().'getpayment/'.$fetch['payment_id']; ?>', 'Payment #<?php echo $fetch['payment_id']; ?>');" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
                            <span onclick="delete_payment(<?php echo $fetch['payment_id']; ?>);" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-trash"></i>Delete</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>M/No</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table> <br />
            
            <div class="customwrapper" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);" style="display: none; width: 100vw; height: 100vh; background: rgba(2, 2, 2, 0.4); position: fixed; top: 0px; left: 0px;"></div>
            <div class="custompane" style="display: none; width: 70%; height: 100vh; background: #fff; position: fixed; right: 0px; top: 0px;">
                <span class="btn btn-danger fa fa-times pull-right fa-2x" style="margin: 20px;" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);"></span>
                <h1 style="padding-left: 20px;">Add Payment</h1>
                <img src="<?php echo base_url(); ?>assets/images/preloader.gif" style="display: none; margin: 10px auto;" class="formcontentimage" />
                
                <form class="paymentsform" name="paymentsform" method="POST">
                    
                    <div class="col-xs-12" style="text-align: center;">
                        <span onclick="$('.idpicker').show(); $('.namepicker').hide();" class="btn btn-info">For Member</span>
                        <span onclick="$('.idpicker').hide(); $('.namepicker').show();" class="btn btn-primary">For Non-Member</span>
                    </div>
                    <div class="col-xs-12"></div>
                    <div class="form-group col-xs-12 idpicker">
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
                    <div class="form-group col-xs-12 namepicker" style="display: none;">
                        <label>Name</label>
                        <input autocomplete="off" class="form-control name" type="text" name="name" placeholder="Name" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Amount</label>
                        <input autocomplete="off" class="form-control amount" type="number" name="amount" placeholder="Amount" required />
                    </div>
                    <div class="form-group col-xs-6">
                        <label>Type</label>
                        <select autocomplete="off" class="form-control type" type="text" name="type" data-allow-clear="true"
                            data-placeholder="Payment type...">
                            <option></option>
                            <optgroup label="Payment Type">
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </optgroup>
                        </select autocomplete="off">
                    </div>
                    <div class="form-group col-xs-6">
                        <label>Category</label>
                        <select autocomplete="off" class="select2 category" type="text" name="category" data-allow-clear="true"
                                data-placeholder="Payment category...">
                            <option></option>
                            <optgroup class="categorypicker" label="Payment Category">
                            </optgroup>
                        </select autocomplete="off">
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Description</label>
                        <textarea autocomplete="off" class="form-control" rows="5" name="description"></textarea autocomplete="off">
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Date</label>
                        <input autocomplete="off" type="text" name="date" class="date datepicker form-control" data-format="dd MM yyyy" placeholder="<?php echo date('d F Y'); ?>">
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <input autocomplete="off" class="btn btn-primary pull-right" type="submit" name="submit" value="Add Payment" required />
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
                    $('.type').change(function(){
                        $('.categorypicker').attr('label', $('.type').val() + ' category');
                        $.ajax({
                            url: base_url + 'getcategory/' + $('.type').val(),
                            success: function(response){
                                $('.categorypicker').html(response);
                            }
                        });
                    });
                    
                    $('.paymentsform').submit(function(e){
                        e.preventDefault();
                        toastr.info("Adding payment", "Success");
                        $('.formcontentimage').show(600);
                        
                        $.ajax({
                            url: base_url + 'makepayment',
                            data: $('.paymentsform').serialize(),
                            method: 'POST',
                            dataType: 'text',
                            success: function(response){
                                toastr.success("Payment successfully added", "Success");
                                $('.paymentlistbody').prepend(response);
                                setTimeout(function(){
                                    $('.paymentsform')[0].reset();
                                    $('.formcontentimage').hide(600);
                                }, 1000);
                            },
                            error: function(){
                                toastr.warning( $('.membername').val() + " could not be added", "Error");
                                $('.paymentsform')[0].reset();
                                $('.formcontentimage').hide(600);
                            }
                        });
                    });
                });

                function delete_payment(id){
                    if (confirm("Are you sure?")) {
                        toastr.warning('Deleting transaction number ' + id , '<span class="fa fa-warning"></span> Danger');
                        $('#payment'+id).css('background', '#ac1818');
                        $('#payment'+id).css('color', '#ffff');
                        $.ajax({
                            url: base_url + 'delete_payment/' + id,
                            success: function(response){
                                toastr.success('Succesfully deleted transaction number ' + id, 'Success');
                                $('#payment'+id).hide(500);
                            },
                            error: function(response){
                                setTimeout(function(){
                                    toastr.warning('Could not delete transaction number ' + id , '<span class="fa fa-warning"></span> Danger');
                                    $('#payment'+id).css('background', '#fff');
                                    $('#payment'+id).css('color', '#666');
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