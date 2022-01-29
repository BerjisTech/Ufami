<div id="invoice_print">
    <h3><?php echo ucwords($member_details->name); ?></h3>
    <strong>
        M/No: <?php echo $member_details->member_id; ?><br />
        Registered On: <?php echo date('d M, Y', $member_details->date_joined); ?><br /><br />
        <em>Reports generated on: <?php echo date('d M, Y', time()); ?></em>
    </strong><hr />

    <p></p>
    <table style="width: 100%; height: auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: 200px;">Date</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">REGS</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">S.CAP</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">DEPOSITS</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">BY LAW</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">P/B</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">CO.MGZ</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">Loan App</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">L. Repayment</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">TOTAL</th>
        </tr>
        <?php 
            for($year = 2018; $year <= date('Y'); $year++):
                if($year == 2018){
                    $startmonth = 6;
                }else{
                    $startmonth = 1;
                }
                for($month = $startmonth; $month <= 12; $month++):
                   $currmonth = '0'.$month.$year; 
                   $currdate = '01-'.$month.'-'.$year;
                    
        ?>
        <tr>
            <td style="padding: 6px; border: 1px solid black; width: 200px;"><?php echo date('M, Y', strtotime($currdate)); ?></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php 
                $regs = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($regs != '0'){ echo $regs; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $scap = number_format($this->db->select('sum(amount) as shares')->where('member', $member_details->member_id)->where('type', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('contributions')->row()->shares); 
                if($scap != '0'){ echo $scap; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $depo = number_format($this->db->select('sum(amount) as deposits')->where('member', $member_details->member_id)->where('type', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('contributions')->row()->deposits); 
                if($depo != '0'){ echo $depo; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $blaw = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '3')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($blaw != '0'){ echo $blaw; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $book = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($book != '0'){ echo $book; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $cmag = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '9')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($cmag != '0'){ echo $cmag; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php
                $lapp = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '11')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($lapp != '0'){ echo $lapp; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php
                $lpay = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '12')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount); 
                if($lpay != '0'){ echo $lpay; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
                <?php 
                    $reciepttotal = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount +
                    $this->db->select('sum(amount) as shares')->where('member', $member_details->member_id)->where('type', '2')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('contributions')->row()->shares +
                    $this->db->select('sum(amount) as deposits')->where('member', $member_details->member_id)->where('type', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('contributions')->row()->deposits +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '3')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '1')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '9')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '11')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '12')->where('date_format(from_unixtime(date), "%m%Y") =', $currmonth)->get('payments')->row()->amount);
                    if($reciepttotal != '0'){ echo $reciepttotal; }
                ?>
            </td>
        </tr>
        <?php endfor; endfor;?>
        <tr>
            <td style="padding: 6px; border: 1px solid black; width: 200px;"><strong>TOTALS</strong></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php 
                $regs = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '2')->get('payments')->row()->amount); 
                if($regs != '0'){ echo $regs; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $scap = number_format($this->db->select('sum(amount) as shares')->where('member', $member_details->member_id)->where('type', '2')->get('contributions')->row()->shares); 
                if($scap != '0'){ echo $scap; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $depo = number_format($this->db->select('sum(amount) as deposits')->where('member', $member_details->member_id)->where('type', '1')->get('contributions')->row()->deposits); 
                if($depo != '0'){ echo $depo; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $blaw = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '3')->get('payments')->row()->amount); 
                if($blaw != '0'){ echo $blaw; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $book = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '1')->get('payments')->row()->amount); 
                if($book != '0'){ echo $book; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php
                $cmag = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '9')->get('payments')->row()->amount); 
                if($cmag != '0'){ echo $cmag; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php
                $lapp = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '11')->get('payments')->row()->amount); 
                if($lapp != '0'){ echo $lapp; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
            <?php
                $lpay = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '12')->get('payments')->row()->amount); 
                if($lpay != '0'){ echo $lpay; }
            ?></td>
            <td style="padding: 6px; border: 1px solid black;">
                <?php 
                    $reciepttotal = number_format($this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '2')->get('payments')->row()->amount +
                    $this->db->select('sum(amount) as shares')->where('member', $member_details->member_id)->where('type', '2')->get('contributions')->row()->shares +
                    $this->db->select('sum(amount) as deposits')->where('member', $member_details->member_id)->where('type', '1')->get('contributions')->row()->deposits +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '3')->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '1')->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '9')->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '11')->get('payments')->row()->amount +
                    $this->db->where('member', $member_details->member_id)->where('type', 'income')->where('category', '12')->get('payments')->row()->amount);
                    if($reciepttotal != '0'){ echo $reciepttotal; }
                ?>
            </td>
        </tr>
    </table>
    
</div>

<script type="text/javascript">
    $(document).ready(function(){
        PrintElem($('#invoice_print'))
    });
	function PrintElem(elem) {
		Popup($(elem).html());
	}

	function Popup(data) {
		var mywindow = window.open('', 'invoice', 'height=800,width=1400');
		mywindow.document.write('<html><head><title><?php echo $member_details->name; ?>\'s Payments Report</title>');
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