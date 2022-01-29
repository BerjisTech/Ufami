            <center><h2>Reciepts from <?php echo date('F, Y', strtotime($date)); ?></h2></center>
            <div class="row">
                <form class="col-xs-12 recieptfilter">
                    <div class="form-group">
                        <select style="height: 30px; color: #000; border-right: none; border-radius: 7px 0px 0px 7px;" class="col-xs-3 year">
                            <?php for($i = 2018; $i <= date('Y'); $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <select style="height: 30px; color: #000; border-left: none; border-right: none;" class="col-xs-5 month">
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <input style="height: 30px; color: #fff; border: none; border-radius: 0px 7px 7px 0px;" type="submit" class="btn-primary col-xs-4" name="submit" value="Filter" />
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
                        <th>M/No</th>
                        <th>Name</th>
                        <th>REG DATE</th>
                        <th>CONTACT</th>
                        <th>REGS</th>
                        <th>S.CAP</th>
                        <th>DEPOSITS</th>
                        <th>BY LAW</th>
                        <th>P/B</th>
                        <th>CO.MGZ</th>
                        <th>Loan App</th>
                        <th>L. Repayment</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody class="memberslistbody">
                <?php foreach($member as $key => $fetch): ?>
                    <tr>
                        <td><?php echo $fetch['member_id']; ?></td>
                        <td><?php echo $fetch['name']; ?></td>
                        <td><?php echo date('d M, Y', $fetch['date_joined']); ?></td>
                        <td><?php echo $fetch['phone']; ?></td>
                        <td>
                        <?php 
                            $regs = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($regs != '0'){ echo $regs; }
                        ?></td>
                        <td><?php
                            $scap = number_format($this->db->select('sum(amount) as shares')->where('member', $fetch['member_id'])->where('type', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('contributions')->row()->shares); 
                            if($scap != '0'){ echo $scap; }
                        ?></td>
                        <td><?php
                            $depo = number_format($this->db->select('sum(amount) as deposits')->where('member', $fetch['member_id'])->where('type', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('contributions')->row()->deposits); 
                            if($depo != '0'){ echo $depo; }
                        ?></td>
                        <td><?php
                            $blaw = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '3')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($blaw != '0'){ echo $blaw; }
                        ?></td>
                        <td><?php
                            $book = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($book != '0'){ echo $book; }
                        ?></td>
                        <td><?php
                            $cmag = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '9')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($cmag != '0'){ echo $cmag; }
                        ?></td>
                        <td>
                        <?php
                            $lapp = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '11')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($lapp != '0'){ echo $lapp; }
                        ?></td>
                        <td>
                        <?php
                            $lpay = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '12')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount); 
                            if($lpay != '0'){ echo $lpay; }
                        ?></td>
                        <td>
                            <?php 
                                $reciepttotal = number_format($this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount +
                                $this->db->select('sum(amount) as shares')->where('member', $fetch['member_id'])->where('type', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('contributions')->row()->shares +
                                $this->db->select('sum(amount) as deposits')->where('member', $fetch['member_id'])->where('type', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('contributions')->row()->deposits +
                                $this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '3')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount +
                                $this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount +
                                $this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '9')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount +
                                $this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '11')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount +
                                $this->db->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '12')->where('date_format(from_unixtime(date), "%m%Y") =', $month)->get('payments')->row()->amount);
                                if($reciepttotal != '0'){ echo $reciepttotal; }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><strong>TOTALS</strong></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <?php 
                            $regs = number_format($this->db->where('type', 'income')->where('category', '2')->get('payments')->row()->amount); 
                            if($regs != '0'){ echo $regs; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $scap = number_format($this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares); 
                            if($scap != '0'){ echo $scap; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $depo = number_format($this->db->select('sum(amount) as deposits')->where('type', '1')->get('contributions')->row()->deposits); 
                            if($depo != '0'){ echo $depo; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $blaw = number_format($this->db->where('type', 'income')->where('category', '3')->get('payments')->row()->amount); 
                            if($blaw != '0'){ echo $blaw; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $book = number_format($this->db->where('type', 'income')->where('category', '1')->get('payments')->row()->amount); 
                            if($book != '0'){ echo $book; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $cmag = number_format($this->db->where('type', 'income')->where('category', '9')->get('payments')->row()->amount); 
                            if($cmag != '0'){ echo $cmag; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <?php
                            $lapp = number_format($this->db->where('type', 'income')->where('category', '11')->get('payments')->row()->amount); 
                            if($lapp != '0'){ echo $lapp; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <?php
                            $lpay = number_format($this->db->where('type', 'income')->where('category', '12')->get('payments')->row()->amount); 
                            if($lpay != '0'){ echo $lpay; }
                        ?></td>
                        <td style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                            <?php 
                                $reciepttotal = number_format($this->db->where('type', 'income')->where('category', '2')->get('payments')->row()->amount +
                                $this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares +
                                $this->db->select('sum(amount) as deposits')->where('type', '1')->get('contributions')->row()->deposits +
                                $this->db->where('type', 'income')->where('category', '3')->get('payments')->row()->amount +
                                $this->db->where('type', 'income')->where('category', '1')->get('payments')->row()->amount +
                                $this->db->where('type', 'income')->where('category', '9')->get('payments')->row()->amount +
                                $this->db->where('type', 'income')->where('category', '11')->get('payments')->row()->amount +
                                $this->db->where('type', 'income')->where('category', '12')->get('payments')->row()->amount);
                                if($reciepttotal != '0'){ echo $reciepttotal; }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>M/No</th>
                        <th>Name</th>
                        <th>REG DATE</th>
                        <th>CONTACT</th>
                        <th>REGS</th>
                        <th>S.CAP</th>
                        <th>DEPOSITS</th>
                        <th>BY LAW</th>
                        <th>P/B</th>
                        <th>CO.MGZ</th>
                        <th>Loan App</th>
                        <th>L. Repayment</th>
                        <th>TOTAL</th>
                    </tr>
                </tfoot>
            </table>
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/datatables/datatables.css" id="style-resource-1">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" id="style-resource-2">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/select2/select2.css" id="style-resource-3">
            <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterangepicker/daterangepicker-bs3.css" id="style-resource-4">
            <script src="<?php echo base_url(); ?>assets/js/datatables/datatables.js" id="script-resource-8"></script>
            <script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js" id="script-resource-9"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js" id="script-resource-12"></script>
            <script>
                $(document).ready(function(){
                    document.title = 'Reciepts from <?php echo date('F, Y', strtotime($date)); ?>';
                    $('.recieptfilter').submit(function(e){
                        e.preventDefault();
                        window.location.href = base_url + 'reciepts/monthly/' + $('.month').val() + $('.year').val();
                    });
                });
            </script>