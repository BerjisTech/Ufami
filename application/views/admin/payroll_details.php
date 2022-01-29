<?php
$edit_data = $this->db->get_where('payroll', array('payroll_id' => $param2))->result_array();
foreach ($edit_data as $row):
    $user = $this->db->get_where('members', array('member_id' => $row['user_id']))->row();
    $date = explode(',', $row['date']);
    $month_list = array('january', 'february', 'march', 'april', 'may', 'june', 'july',
        'august', 'september', 'october', 'november', 'december');
    for ($i = 0; $i < 12; $i++)
        if ($i == $date[0])
            $month = ($month_list[$i-1]);
    ?>
    <div id="payroll_print">
        <table width="100%" border="0">
            <tr>
                <td width="50%"><img src="assets/images/favicon.ico" style="max-height:80px;"></td>
                <td align="right">
                    <h4>Payroll Code : <?php echo $row['payroll_code']; ?></h4>
                    <h5>Employee : <?php echo $user->name; ?></h5>
                    <h5>Account Type : <?php echo ($row['user_type']); ?></h5>
                    <h5>Date : <?php echo $month . ', ' . $date[1]; ?></h5>
                    <h5>
                        Status :
                        <?php
                        if($row['status'] == 0)
                            echo ('unpaid');
                        else
                            echo ('paid'); ?>
                    </h5>
                </td>
            </tr>
        </table>
        
        <hr><br>
        <h4 style="text-align: center;">Allowance Summary</h4>
        <?php if($row['allowances'] == '') { ?>
            <div class="alert alert-info">No Allowances</div>
        <?php } else { ?>
            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="60%">Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                    <div>
                        <?php
                        $total_allowance    = 0;
                        $allowances         = json_decode($row['allowances']);
                        $i = 1;
                        foreach ($allowances as $allowance)
                        {
                            $total_allowance += $allowance->amount; ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td>
                                    <?php echo $allowance->type; ?>
                                </td>
                                <td class="text-right">
                                    <?php echo $allowance->amount; ?>
                                </td>
                            </tr>
                        <?php }  ?>
                    </div>
                </tbody>
            </table>
        <?php } ?>
        
        <br>
        <h4 style="text-align: center;">Deduction Summary</h4>
        <?php if ($row['deductions'] == '') { ?>
            <div class="alert alert-info">No Deductions</div>
        <?php } else { ?>
            <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th width="60%">Type</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                <div>
                    <?php
                    $total_deduction = 0;
                    $deductions = json_decode($row['deductions']);
                    $i = 1;
                    foreach ($deductions as $deduction) {
                        $total_deduction += $deduction->amount;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td>
                                <?php echo $deduction->type; ?>
                            </td>
                            <td class="text-right">
                                <?php echo $deduction->amount; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </div>
                </tbody>
            </table>
        <?php } ?>
        
        <br>
        <h3 style="text-align: center; margin-bottom: 0px;">Payroll Summary</h3>
        <center><hr style="margin: 5px 0px 5px 0px; width: 50%;"></center>
        <center>
            <table>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        Basic Salary</td>
                    <td style="font-weight: 600; font-size: 15px; color: #000; width: 15%;
                        text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $row['joining_salary']; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        Total Allowance</td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $total_allowance; ?></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        Total Deduction</td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;"><?php echo $total_deduction; ?></td>
                </tr>
                <tr>
                    <td colspan="3"><hr style="margin: 5px 0px;"></td>
                </tr>
                <tr>
                    <td style="font-weight: 600; font-size: 15px; color: #000;">
                        Net Salary</td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        width: 15%; text-align: center;"> : </td>
                    <td style="font-weight: 600; font-size: 15px; color: #000;
                        text-align: right;">
                        <?php
                        $net_salary = $row['joining_salary'] + $total_allowance - $total_deduction;
                        echo $net_salary; ?>
                    </td>
                </tr>
            </table>
        </center>
        <br>
    </div>

    <a onClick="print('#payroll_print');PrintElem('#payroll_print')" class="btn btn-primary hidden-print">
        <i class="fa fa-print"></i>&nbsp;
        Print Payroll Details
    </a>


<?php endforeach; ?>




<script type="text/javascript">

    function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data)
    {
        var mywindow = window.open('', 'payroll', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Payroll Details</title>');
        mywindow.document.write('<link rel="stylesheet" href="assets/css/neon-theme.css" type="text/css" />');
        mywindow.document.write('<link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.print();
        mywindow.close();

        return true;
    }

</script>