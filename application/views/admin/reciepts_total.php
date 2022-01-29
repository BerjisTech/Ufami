            <center><h2>Total Reciepts</h2></center>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    var $table4 = jQuery("#table-5");
                    $table4.DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5',
                            'print'
                        ]
                    });
                });
            </script>
            <div style="display: table; width: 100%; height: 30px;"></div>
            <table class="table table-bordered datatable" style="background: #fff;" id="table-5">
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
                        <!--th>Loan App</th>
                        <th>L. Repayment</th-->
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
                            $regs = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '2')->get('payments')->row()->totals); 
                            if($regs != '0'){ echo $regs; }
                        ?></td>
                        <td><?php
                            $scap = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', '2')->get('contributions')->row()->totals); 
                            if($scap != '0'){ echo $scap; }
                        ?></td>
                        <td><?php
                            $depo = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', '1')->get('contributions')->row()->totals); 
                            if($depo != '0'){ echo $depo; }
                        ?></td>
                        <td><?php
                            $blaw = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '3')->get('payments')->row()->totals); 
                            if($blaw != '0'){ echo $blaw; }
                        ?></td>
                        <td><?php
                            $book = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '1')->get('payments')->row()->totals); 
                            if($book != '0'){ echo $book; }
                        ?></td>
                        <td><?php
                            $cmag = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '9')->get('payments')->row()->totals); 
                            if($cmag != '0'){ echo $cmag; }
                        ?></td>
                        <!--td><?php
                            $lapp = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '11')->get('payments')->row()->totals); 
                            if($lapp != '0'){ echo $lapp; }
                        ?></td>
                        <td><?php
                            $lpay = number_format($this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '12')->get('payments')->row()->totals); 
                            if($lpay != '0'){ echo $lpay; }
                        ?></td-->
                        <td>
                            <?php 
                                $reciepttotal = number_format(
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '2')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', '2')->get('contributions')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', '1')->get('contributions')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '3')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '1')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '9')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '11')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('member', $fetch['member_id'])->where('type', 'income')->where('category', '12')->get('payments')->row()->totals
                                );
                                if($reciepttotal != '0'){ echo $reciepttotal; }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">TOTALS</td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">--</td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                        <?php 
                            $regs = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '2')->get('payments')->row()->totals); 
                            if($regs != '0'){ echo $regs; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $scap = number_format($this->db->select('sum(amount) as totals')->where('type', '2')->get('contributions')->row()->totals); 
                            if($scap != '0'){ echo $scap; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $depo = number_format($this->db->select('sum(amount) as totals')->where('type', '1')->get('contributions')->row()->totals); 
                            if($depo != '0'){ echo $depo; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $blaw = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '3')->get('payments')->row()->totals); 
                            if($blaw != '0'){ echo $blaw; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $book = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '1')->get('payments')->row()->totals); 
                            if($book != '0'){ echo $book; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $cmag = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '9')->get('payments')->row()->totals); 
                            if($cmag != '0'){ echo $cmag; }
                        ?></td>
                        <!--td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $lapp = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '11')->get('payments')->row()->totals); 
                            if($lapp != '0'){ echo $lapp; }
                        ?></td>
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;"><?php
                            $lpay = number_format($this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '12')->get('payments')->row()->totals); 
                            if($lpay != '0'){ echo $lpay; }
                        ?></td-->
                        <td  style="font-weight: bold; background: #ffffff; color: #000000; text-align: center;">
                            <?php 
                                $reciepttotal = number_format(
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '2')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', '2')->get('contributions')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', '1')->get('contributions')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '3')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '1')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '9')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '11')->get('payments')->row()->totals +
                                    $this->db->select('sum(amount) as totals')->where('type', 'income')->where('category', '12')->get('payments')->row()->totals
                                );
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
                        <!--th>Loan App</th>
                        <th>L. Repayment</th-->
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
                    document.title = 'Total Ufami Sacco Reciepts';
                });
            </script>