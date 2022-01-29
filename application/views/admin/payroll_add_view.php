<hr />

<?php echo form_open(site_url('payroll_selector')); ?>

<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Employee</label>
            <select name="employee_id" class="form-control select2" required>

                <option value="">Select An Employee</option>
                <?php
                $account_types = array('member');
                foreach ($account_types as $account_type) { ?>
                    <optgroup label="<?php echo ($account_type); ?>">
                        <?php
                        $user_info = $this->db->order_by('name','ASC')->get('members')->result_array();

                        foreach ($user_info as $row) { ?>

                            <option value="<?php echo $account_type . '-' . $row['member_id']; ?>" <?php if ($account_type == $user_type && $row['member_id'] == $employee_id) echo 'selected'; ?>>
                                - <?php echo $row['name']; ?></option>

                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Month</label>
            <select name="month" class="form-control select2" required>
                <option value="">Select A Month</option>
                <?php
                for ($i = 1; $i <= 12; $i++) :
                    if ($i == 1)
                        $m = ('January');
                    else if ($i == 2)
                        $m = ('February');
                    else if ($i == 3)
                        $m = ('March');
                    else if ($i == 4)
                        $m = ('April');
                    else if ($i == 5)
                        $m = ('May');
                    else if ($i == 6)
                        $m = ('June');
                    else if ($i == 7)
                        $m = ('July');
                    else if ($i == 8)
                        $m = ('August');
                    else if ($i == 9)
                        $m = ('September');
                    else if ($i == 10)
                        $m = ('October');
                    else if ($i == 11)
                        $m = ('November');
                    else if ($i == 12)
                        $m = ('December'); ?>
                    <option value="<?php echo $i; ?>" <?php if ($i == $month) echo 'selected'; ?>>
                        <?php echo $m; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Year</label>
            <select name="year" class="form-control select2" required>
                <option value="">Select A Year</option>
                <?php
                for ($i = 2017; $i <= 2026; $i++) : ?>
                    <option value="<?php echo $i; ?>" <?php if ($i == $year) echo 'selected'; ?>>
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3" style="margin-top: 27px;">
        <button type="submit" class="btn btn-info" style="width: 100%;">
            Generate Payslip</button>
    </div>

</div>

<?php echo form_close(); ?>

<hr />

<?php echo form_open(
    site_url('create_payroll'),
    array('class' => 'form-horizontal form-groups-bordered', 'enctype' => 'multipart/form-data')
); ?>

<div class="row">

    <div class="col-md-6">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Allowances</h4>
                </div>
            </div>
            <div class="panel-body ">
                <span id="allowance">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="allowance_type[]" placeholder="Type" />
                        </div>

                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="allowance_amount[]" placeholder="Amount" id="allowance_amount_1" />
                        </div>
                    </div>
                </span>

                <span id="allowance_input">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="allowance_type[]" placeholder="Type" />
                        </div>

                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="allowance_amount[]" placeholder="Amount" id="allowance_amount" />
                        </div>

                        <div class="col-sm-2">
                            <button type="button" class="btn btn-danger" id="allowance_amount_delete" onclick="deleteAllowanceParentElement(this)">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                </span>

                <div class="form-group">
                    <div class="col-sm-5" style="text-align: right;">
                        <button type="button" class="btn btn-default btn-sm" onClick="add_allowance()">
                            <i class="fa fa-plus"></i>&nbsp;
                            Add Alowance
                        </button>
                    </div>

                    <div class="col-sm-5">
                        <button type="button" class="btn btn-info btn-sm" onClick="calculate_total_allowance()">
                            Calculate Allowance
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Deductions</h4>
                </div>
            </div>
            <div class="panel-body ">
                <span id="deduction">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="deduction_type[]" placeholder="Type" />
                        </div>

                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="deduction_amount[]" placeholder="Amount" id="deduction_amount_1" />
                        </div>
                    </div>
                </span>

                <span id="deduction_input">
                    <div class="form-group">
                        <div class="col-sm-5">
                            <input type="text" class="form-control" name="deduction_type[]" placeholder="Type" />
                        </div>

                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="deduction_amount[]" placeholder="Amount" id="deduction_amount" />
                        </div>

                        <div class="col-sm-2">
                            <button type="button" class="btn btn-danger" id="deduction_amount_delete" onclick="deleteDeductionParentElement(this)">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </div>
                </span>

                <div class="form-group">
                    <div class="col-sm-5" style="text-align: right;">
                        <button type="button" class="btn btn-default btn-sm" onClick="add_deduction()">
                            <i class="fa fa-plus"></i>&nbsp;
                            Add Deduction
                        </button>
                    </div>

                    <div class="col-sm-5">
                        <button type="button" class="btn btn-info btn-sm" onClick="calculate_total_deduction()">
                            Calculate Deduction
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="panel panel-primary" data-collapsed="0">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Payroll Sumary</h4>
                </div>
            </div>

            <div class="panel-body ">

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">Basic</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="joining_salary" id="basic" value="0" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">Total Allowance</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="total_allowance" id="total_allowance" value="0" readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">Total Deduction</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="total_deduction" id="total_deduction" value="0" readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-1" class="col-sm-3 control-label">Net Salary</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="net_salary" id="net_salary" value="0" readonly />
                    </div>
                </div>

                <div class="form-group">
                    <label for="field-2" class="col-sm-3 control-label">Status</label>

                    <div class="col-sm-7">
                        <select name="status" class="form-control selectboxit">
                            <option value="1">Paid</option>
                            <option value="0">Unpaid</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i>Create Payslip
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<input type="hidden" name="user_id" value="<?php echo $employee_id; ?>" />
<input type="hidden" name="user_type" value="<?php echo $user_type; ?>" />
<input type="hidden" name="month" value="<?php echo $month; ?>" />
<input type="hidden" name="year" value="<?php echo $year; ?>" />

<?php echo form_close(); ?>

<script type="text/javascript">
    var allowance_count = 1;
    var deduction_count = 1;
    var total_allowance = 0;
    var total_deduction = 0;
    var deleted_allowances = [];
    var deleted_deductions = [];

    $(document).ready(function() {
        // SelectBoxIt Dropdown replacement
        if ($.isFunction($.fn.selectBoxIt)) {
            $("select.selectboxit").each(function(i, el) {
                var $this = $(el),
                    opts = {
                        showFirstOption: attrDefault($this, 'first-option', true),
                        'native': attrDefault($this, 'native', false),
                        defaultText: attrDefault($this, 'text', ''),
                    };

                $this.addClass('visible');
                $this.selectBoxIt(opts);
            });
        }

    });

    function get_employees(department_id) {
        if (department_id != '')
            $.ajax({
                url: '<?php echo site_url('get_employees/'); ?>' + department_id,
                success: function(response) {
                    jQuery('#employee_holder').html(response);
                }
            });
        else
            jQuery('#employee_holder').html('<option value=""><?php echo ("select_a_department_first"); ?></option>');
    }

    $('#allowance_input').hide();

    // CREATING BLANK ALLOWANCE INPUT
    var blank_allowance = '';
    $(document).ready(function() {
        blank_allowance = $('#allowance_input').html();
    });

    function add_allowance() {
        allowance_count++;
        $("#allowance").append(blank_allowance);
        $('#allowance_amount').attr('id', 'allowance_amount_' + allowance_count);
        $('#allowance_amount_delete').attr('id', 'allowance_amount_delete_' + allowance_count);
        $('#allowance_amount_delete_' + allowance_count).attr('onclick', 'deleteAllowanceParentElement(this, ' + allowance_count + ')');
    }

    // REMOVING ALLOWANCE INPUT
    function deleteAllowanceParentElement(n, allowance_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_allowances.push(allowance_count);
    }

    function calculate_total_allowance() {
        var amount;
        for (i = 1; i <= allowance_count; i++) {
            if (jQuery.inArray(i, deleted_allowances) == -1) {
                amount = $('#allowance_amount_' + i).val();

                if (amount != '') {
                    amount = parseInt(amount);
                    total_allowance = amount + total_allowance;
                    $('#total_allowance').attr('value', total_allowance);
                }
            }
        }
        net_salary = parseInt($('#basic').val()) + parseInt($('#total_allowance').val()) - parseInt($('#total_deduction').val());
        $('#net_salary').attr('value', net_salary);
        total_allowance = 0;
    }

    $('#deduction_input').hide();

    // CREATING BLANK DEDUCTION INPUT
    var blank_deduction = '';
    $(document).ready(function() {
        blank_deduction = $('#deduction_input').html();
    });

    function add_deduction() {
        deduction_count++;
        $("#deduction").append(blank_deduction);
        $('#deduction_amount').attr('id', 'deduction_amount_' + deduction_count);
        $('#deduction_amount_delete').attr('id', 'deduction_amount_delete_' + deduction_count);
        $('#deduction_amount_delete_' + deduction_count).attr('onclick', 'deleteDeductionParentElement(this, ' + deduction_count + ')');
    }

    // REMOVING DEDUCTION INPUT
    function deleteDeductionParentElement(n, deduction_count) {
        n.parentNode.parentNode.parentNode.removeChild(n.parentNode.parentNode);
        deleted_deductions.push(deduction_count);
    }

    function calculate_total_deduction() {
        var amount;
        for (i = 1; i <= deduction_count; i++) {
            if (jQuery.inArray(i, deleted_deductions) == -1) {
                amount = $('#deduction_amount_' + i).val();

                if (amount != '') {
                    amount = parseInt(amount);
                    total_deduction = amount + total_deduction;
                    $('#total_deduction').attr('value', total_deduction);
                }
            }
        }
        net_salary = parseInt($('#basic').val()) + parseInt($('#total_allowance').val()) - parseInt($('#total_deduction').val());
        $('#net_salary').attr('value', net_salary);
        total_deduction = 0;
    }

    jQuery('#basic').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');

        net_salary = parseInt($('#basic').val()) + parseInt($('#total_allowance').val()) - parseInt($('#total_deduction').val());
        $('#net_salary').attr('value', net_salary);
    });
</script>