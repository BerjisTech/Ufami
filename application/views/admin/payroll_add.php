<hr />

<?php echo form_open(site_url('payroll_selector')); ?>

<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 11px;">Employee</label>
            <select name="employee_id" class="form-control select2" required>

                <option value="">Select Employee</option>
                <?php
                $user_types = array('member');
                foreach ($user_types as $user_type) { ?>
                    <optgroup label="<?php echo ($user_type); ?>">
                        <?php
                        $user_info = $this->db->order_by('name','ASC')->get('members')->result_array();

                        foreach ($user_info as $row) { ?>

                            <option value="<?php echo $user_type . '-' . $row['member_id']; ?>">
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
                    <option value="<?php echo $i; ?>">
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
                for ($i = date('Y'); $i <= 2026; $i++) : ?>
                    <option value="<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
    </div>

    <div class="col-md-3" style="margin-top: 30px;">
        <button type="submit" class="btn btn-info">
            Generate Payslip</button>
    </div>

</div>

<?php echo form_close(); ?>

<script type="text/javascript">
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
</script>