            <h3>Ufami Members</h3> <br />
            <button onclick="$('.custompane').toggle(700); $('.customwrapper').toggle(500);" class="btn btn-primary pull-right">Add Member</button>
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
                        <th>Phone</th>
                        <th>ID Number</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="memberslistbody">
                    <?php foreach($member as $key => $fetch): ?>
                    <tr id="member<?php echo $fetch['member_id']; ?>">
                        <td><?php echo $fetch['member_id']; ?></td>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo $fetch['phone']; ?></td>
                        <td><?php echo $fetch['id_no']; ?></td>
                        <td><?php echo date('d M, Y', $fetch['date_joined']); ?></td>
                        <td>
                            <?php if($fetch['status'] == '3'): ?>
                            <span class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-minus-circled"></i>Deregistered</span>
                            <?php else: ?>   

                                <?php if($fetch['status'] == '0'): ?>
                                    <span onclick="approve(<?php echo $fetch['member_id']; ?>);" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-check"></i>Approve</span>
                                <?php else: ?>                            
                                    <a href="<?php echo base_url(); ?>member_report/payments/<?php echo $fetch['member_id']; ?>" target="_BLANK" class="btn btn-success btn-sm btn-icon icon-left"> <i class="entypo-print"></i>Print Report</a>
                                    <span onclick="window.location.href= base_url + 'member/<?php echo $fetch['member_id']; ?>';" class="btn btn-info btn-sm btn-icon icon-left"> <i class="entypo-eye"></i>View</span>
                                    <span onclick="if(confirm('Do you want to edit <?php echo $fetch['name']; ?>')){toastr.info('Editing <?php echo $fetch['name']; ?>\'s details ', 'Edit Initiated');$('.membid').val('<?php echo $fetch['member_id']; ?>');$('.membered').toggle(700); $('.customwrapper').toggle(500);}else{ return false; }" class="btn btn-primary btn-sm btn-icon icon-left"> <i class="entypo-pencil"></i>Edit</span>
                                <?php endif; ?>
                                <span onclick="deregister(<?php echo $fetch['member_id']; ?>);" class="btn btn-danger btn-sm btn-icon icon-left"> <i class="entypo-cancel"></i>Deregister</span>                        
                                
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>M/No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>ID Number</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table> <br />
            
            <div class="customwrapper" onclick="$('.membered').toggle(500); $('.customwrapper').toggle(700);" style="display: none; width: 100vw; height: 100vh; background: rgba(2, 2, 2, 0.4); position: fixed; top: 0px; left: 0px;"></div>
            <div class="membered" style="display: none; width: 70%; height: 100vh; background: #fff; position: fixed; right: 0px; top: 0px;">
                <span class="btn btn-danger btn-sm btn-icon icon-left pull-right fa-2x" style="margin: 20px;" onclick="$('.membered').toggle(500); $('.customwrapper').toggle(700);"><i class="fa fa-times"></i> Close</span>
                <h1 style="padding-left: 20px;">Edit Member</h1>
                <img src="<?php echo base_url(); ?>assets/images/preloader.gif" style="display: none; margin: 10px auto;" class="formcontentimage" />
                <form class="edform" name="edform" method="POST">
                    <input type="hidden" name="membid" class="membid" />

                    <div class="form-group col-xs-12">
                        <span class="btn btn-info btn-sm btn-icon icon-left"> <i class="entypo-info"></i> Only fill in new details. Leave a field blank if it has no change.</span><br /><br />
                        <label>Member Name</label>
                        <input autocomplete="off" class="form-control membername" type="text" name="edname" placeholder="New Name" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>ID Number</label>
                        <input autocomplete="off" class="form-control idnumber" type="number" name="edid" placeholder="New ID Number" />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Phone Number</label>
                        <input autocomplete="off" class="form-control phonenumber" type="text" name="edphone" placeholder="New Phone Number" />
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <input autocomplete="off" class="btn btn-primary pull-right" type="submit" name="submit" value="Edit Member" />
                    </div>
                </form><br />
            </div>
            <div class="custompane" style="display: none; width: 70%; height: 100vh; background: #fff; position: fixed; right: 0px; top: 0px;">
                <span class="btn btn-danger fa fa-times pull-right fa-2x" style="margin: 20px;" onclick="$('.custompane').toggle(500); $('.customwrapper').toggle(700);"></span>
                <h1 style="padding-left: 20px;">Add Member</h1>
                <img src="<?php echo base_url(); ?>assets/images/preloader.gif" style="display: none; margin: 10px auto;" class="formcontentimage" />
                <form class="memmbersform" name="membersform" method="POST">
                    <div class="form-group col-xs-12">
                        <label>Member Name</label>
                        <input autocomplete="off" class="form-control membername" type="text" name="membername" placeholder="Member name" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>ID Number</label>
                        <input autocomplete="off" class="form-control idnumber" type="number" name="idnumber" placeholder="ID number" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Phone Number</label>
                        <input autocomplete="off" class="form-control phonenumber" type="text" name="phonenumber" placeholder="Phone Number" required />
                    </div>
                    <div class="form-group col-xs-12">
                        <label>Date Joined</label>
                        <input autocomplete="off" type="text" name="date" class="date datepicker form-control" data-format="dd MM yyyy" placeholder="<?php echo date('d F Y'); ?>">
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <input autocomplete="off" class="btn btn-primary pull-right" type="submit" name="submit" value="Add Member" required />
                    </div>
                </form><br />
            </div>

            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterangepicker/daterangepicker-bs3.css" id="style-resource-4">
            <script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
            <script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>

            <script>
                $(document).ready(function(){
                    $('.memmbersform').submit(function(e){
                        e.preventDefault();
                        $('.formcontentimage').show(600);
                        
                        $.ajax({
                            url: base_url + 'newmember',
                            data: $('.memmbersform').serialize(),
                            method: 'POST',
                            dataType: 'text',
                            success: function(response){
                                $('.memberslistbody').prepend(response);
                                setTimeout(function(){
                                    $('.memmbersform')[0].reset();
                                    $('.formcontentimage').hide(600);
                                    $('.custompane').toggle(500); 
                                    $('.customwrapper').toggle(700);
                                }, 2000);
                            },
                            error: function(){
                                toastr.warning( $('.membername').val() + " could not be added", "Error");
                                $('.memmbersform')[0].reset();
                                $('.formcontentimage').hide(600);
                            }
                        });
                    });
                    $('.edform').submit(function(e){
                        e.preventDefault();
                        $('.formcontentimage').show(600);
                        
                        $.ajax({
                            url: base_url + 'edit_member',
                            data: $('.edform').serialize(),
                            method: 'POST',
                            dataType: 'text',
                            success: function(response){
                                $('.memberslistbody').prepend(response);
                                setTimeout(function(){
                                    $('.edform')[0].reset();
                                    $('.formcontentimage').hide(600);
                                    $('.membered').toggle(500); 
                                    $('.customwrapper').toggle(700);
                                    document.cookie = 'editid=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                                    document.location.href = base_url + "members";
                                }, 2000);
                            },
                            error: function(){
                                toastr.warning( $('.edname').val() + " could not be added", "Error");
                                $('.edform')[0].reset();
                                $('.formcontentimage').hide(600);
                            }
                        });
                    });
                });

                function approve(id){
                    if (confirm("Are you sure?")) {
                        $('#member' + id).css('background', '#00acd6');
                        $.ajax({
                            url: base_url + 'approve_member/' + id,
                            success: function(response){
                                $('#member' + id).css('background', '#fff');
                                $('#member' + id).append(response);
                                setTimeout(function(){ location.reload() }, 2000);
                            }
                        });
                    }
                    return false;
                }
                function deregister(id){
                    if (confirm("Are you sure?")) {
                        $('#member' + id).css('background', '#ec3b83');
                        $.ajax({
                            url: base_url + 'deregister_member/' + id,
                            success: function(response){
                                $('#member' + id).append(response);
                                $('#member' + id).hide();
                                setTimeout(function(){ location.reload() }, 2000);
                            }
                        });
                    }
                    return false;
                    
                }
            </script>