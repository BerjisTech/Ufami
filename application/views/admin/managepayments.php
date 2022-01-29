            <div class="row">
                <form class="col-xs-12 paycat" type="POST">
                    <div class="form-group">
                        <select name="cat_type" style="height: 30px; color: #000; border-right: none; border-radius: 7px 0px 0px 7px;" class="col-xs-3 cat_type">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                        <input autocomplete="off" name="cat_name" placeholder="Category name" type="text" style="height: 30px; color: #000; border-left: none; border-right: none;" class="col-xs-6 cat_name" />
                        <input style="height: 30px; color: #fff; border: none; border-radius: 0px 7px 7px 0px;" type="submit" class="btn-primary col-xs-3" name="submit" value="Add" />
                    </div>
                </form>
            </div>
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
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="memberslistbody">
                <?php foreach($category as $key => $fetch): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $fetch['type']; ?></td>
                        <td><?php echo $fetch['category_name']; ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <link rel="stylesheet" href="http://localhost/ufami/assets/js/datatables/datatables.css" id="style-resource-1">
            <link rel="stylesheet" href="http://localhost/ufami/assets/js/select2/select2-bootstrap.css" id="style-resource-2">
            <link rel="stylesheet" href="http://localhost/ufami/assets/js/select2/select2.css" id="style-resource-3">
            <link rel="stylesheet" href="http://localhost/ufami/assets/js/daterangepicker/daterangepicker-bs3.css" id="style-resource-4">
            <script src="http://localhost/ufami/assets/js/datatables/datatables.js" id="script-resource-8"></script>
            <script src="http://localhost/ufami/assets/js/select2/select2.min.js" id="script-resource-9"></script>
            <script src="http://localhost/ufami/assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>
            <script>
                $(document).ready(function(){
                    $('.paycat').submit(function(e){
                        e.preventDefault();
                        $.ajax({
                            url: base_url + 'paycat',
                            dataType: 'text',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: new FormData(this), 
                            method  : 'POST',
                            success: function(response){
                                $('.paycat').append(response);
                            }
                        });
                    });
                });
            </script>