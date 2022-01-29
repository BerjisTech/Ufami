<table class="table table-bordered table-striped datatable" id="table-2">
    <thead>
        <tr>
            <th>
                <div>#</div>
            </th>
            <th>
                <div>ID</div>
            </th>
            <th>
                <div>Employee</div>
            </th>
            <th>
                <div>Account Type</div>
            </th>
            <th>
                <div>Summary</div>
            </th>
            <th>
                <div>Date</div>
            </th>
            <th>
                <div>Status</div>
            </th>
            <th>
                <div>Options</div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        $this->db->order_by('payroll_id', 'desc');
        $payroll = $this->db->get('payroll')->result_array();
        foreach ($payroll as $row) : ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $row['payroll_code']; ?></td>
                <td>
                    <?php
                    $user = $this->db->get_where('members', array('member_id' => $row['user_id']))->row();
                    echo $user->name; ?>
                </td>
                <td><?php echo ($row['user_type']); ?></td>
                <td>
                    <?php
                    $total_allowance    = 0;
                    $total_deduction    = 0;
                    $allowances         = json_decode($row['allowances']);
                    $deductions         = json_decode($row['deductions']);

                    foreach ($allowances as $allowance)
                        $total_allowance += $allowance->amount;
                    foreach ($deductions as $deduction)
                        $total_deduction += $deduction->amount;

                    $net_salary = $row['joining_salary'] + $total_allowance - $total_deduction;
                    ?>
                    <div>
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: right;">Basic Salary</td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $row['joining_salary']; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Total Allowances</td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $total_allowance; ?></td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Total Deductions</td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $total_deduction; ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <hr style="margin: 5px 0px;">
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right;">Net Salary</td>
                                <td style="width: 15%; text-align: right;"> : </td>
                                <td style="text-align: right;"><?php echo $net_salary; ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td>
                    <?php
                    $date = explode(',', $row['date']);
                    $month_list = array(
                        'January', 'February', 'March', 'April', 'May', 'June', 'July',
                        'August', 'September', 'October', 'November', 'December'
                    );
                    for ($i = 1; $i <= 12; $i++)
                        if ($i == $date[0])
                            $month = ($month_list[$i - 1]);
                    echo $month . ', ' . $date[1];
                    ?>
                </td>
                <td>
                    <?php
                    if ($row['status'] == 1)
                        echo '<div class="label label-success">Paid</div>';
                    else
                        echo '<div class="label label-danger">Unpaid</div>';
                    ?>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                            Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-default pull-right" role="menu">

                            <li>
                                <a href="#" onclick="showAjaxModal('<?php echo site_url('popup/payroll_details/' . $row['payroll_id']); ?>');">
                                    <i class="fa fa-eye"></i>&nbsp;
                                    View Payroll Details
                                </a>
                            </li>

                            <?php if ($row['status'] == 0) { ?>
                                <li>
                                    <a href="<?php echo site_url('admin/payroll_list/mark_paid/' . $row['payroll_id']); ?>">
                                        <i class="fa fa-check"></i>&nbsp;
                                        Mark As Paid
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    jQuery(window).load(function() {
        var $ = jQuery;

        $("#table-2").dataTable({
            "sPaginationType": "bootstrap"
        });

        $(".dataTables_wrapper select").select2({
            minimumResultsForSearch: -1
        });

        // Replace Checboxes
        $(".pagination a").click(function(ev) {
            replaceCheckboxes();
        });
    });
</script>