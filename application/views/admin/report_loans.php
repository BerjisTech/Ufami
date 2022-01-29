<div id="invoice_print">
    <div style="display: inline-table; width: 49%; height: auto; text-align: left;">
        <h3><?php echo ucwords($this->db->where('member_id', $loans_report->member)->get('members')->row()->name); ?></h3>
        <strong>
            M/No: <?php echo $loans_report->member; ?><br />
            Loan Amount: <?php echo number_format($loans_report->amount); ?><br /><br />
        </strong>
    </div>
    <div style="display: inline-table; width: 49%; height: auto; text-align: left;">
        <br /><br /><strong>
            Repayment Period: <?php echo (int)abs(($loans_report->date_taken - $loans_report->date_to_pay)/(60*60*24*30)); ?> months<br />
            Type Of Loan: <?php echo $this->db->where('category_id', $loans_report->type)->get('loan_category')->row()->category_name; ?><br />
            Interest: <?php 
                if($loans_report->type == 1){ echo '1% on a reducing balances'; }
                if($loans_report->type == 2){ echo '12% p.a'; }
                if($loans_report->type == 3){ echo '10% p.a'; }
                if($loans_report->type == 4){ echo '1% on a reducing balances'; }
                if($loans_report->type == 5){ echo '1% on a reducing balances'; }
                if($loans_report->type == 6){ echo '15% flat rate'; }
                if($loans_report->type == 7){ echo '10% flat rate'; }
            ?>
            <br />
            Loan Balance: <?php echo number_format($loans_report->amountdue); ?>
      
        </strong>
    </div>

    <div>
        <em>Report generated on: <?php echo date('d M, Y', time()); ?></em><br /><br />
        <h2 style="text-align: center;">Narrations</h2>
        <hr />
    </div>

    <table style="width: 100%; height: auto; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">S/No</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">Date</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">Paid</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">Amount</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black;">Balance</th>
        </tr>
        <?php 
            foreach($this->db->order_by('date', 'ASC')->where('loan_id', $loans_report->loan_id)->get('loan_payments')->result_array() as $key => $fetch):
                if($loans_report->type == 1 || $loans_report->type == 4 || $loans_report->type == 5){

                    if($key == 0){
                        $interest = $loans_report->amount*0.01;
                        $amdue = $loans_report->amount + $interest;
                        $amtdue[$key] = $amdue - $fetch['amount'];
                        #echo '<pre> with ineterest('.$interest.') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }else{
                        $interest = $amtdue[$key - 1]*0.01;
                        $amdue = $amtdue[$key - 1] + $interest;
                        $amtdue[$key] = $amdue - $fetch['amount'];
                        #echo '<pre> with ineterest('.$interest.') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }
                }
                if($loans_report->type == 2){
                    $amtdue[$key] = $loans_report->amount+($loans_report->amount*0.12);
                    $amtpaid[$key] = $fetch['amount'];

                    if($key == 0){
                        $amtdue[$key] = ($loans_report->amount+($loans_report->amount*0.12)) - $fetch['amount'];
                        #echo '<pre>'.($loans_report->amount+($loans_report->amount*0.12)).'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }else{
                        $amtdue[$key] = $amtdue[$key - 1] - $fetch['amount'];
                        #echo '<pre>'.$amtdue[$key - 1].'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }
                }
                if($loans_report->type == 3 || $loans_report->type == 7){
                    $amtdue[$key] = $loans_report->amount+($loans_report->amount*0.1);
                    $amtpaid[$key] = $fetch['amount'];

                    if($key == 0){
                        $amtdue[$key] = ($loans_report->amount+($loans_report->amount*0.1)) - $fetch['amount'];
                        #echo '<pre>'.($loans_report->amount+($loans_report->amount*0.1)).'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }else{
                        $amtdue[$key] = $amtdue[$key - 1] - $fetch['amount'];
                        #echo '<pre>'.$amtdue[$key - 1].'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }
                }
                if($loans_report->type == 6){
                    $amtdue[$key] = $loans_report->amount+($loans_report->amount*0.15);
                    $amtpaid[$key] = $fetch['amount'];

                    if($key == 0){
                        $amtdue[$key] = ($loans_report->amount+($loans_report->amount*0.15)) - $fetch['amount'];
                        #echo '<pre>'.($loans_report->amount+($loans_report->amount*0.15)).'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }else{
                        $amtdue[$key] = $amtdue[$key - 1] - $fetch['amount'];
                        #echo '<pre>'.$amtdue[$key - 1].'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                    }
                }
            #print('<pre style="width: 48%; display: inline-table;">'.print_r($amtdue, true).'</pre><pre style="width: 48%; display: inline-table;">'.print_r($amtpaid, true).'</pre>');
        ?>
        <tr>
            <td style="padding: 6px; border: 1px solid black;"><?php echo $key+1; ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php echo date('d M, Y', $fetch['date']); ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php echo number_format($fetch['amount']); ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php 
                if($loans_report->type == 1 || $loans_report->type == 4){
                    echo $amdue;
                }
                else{
                    if($key == 0){echo number_format($loans_report->amount+($loans_report->amount*0.1));}else{echo number_format($amtdue[$key-1]);}
                } ?></td>
            <td style="padding: 6px; border: 1px solid black;"><?php echo number_format($amtdue[$key]); ?></td>
        </tr>
        <?php endforeach;?>
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
		mywindow.document.write('<html><head><title></title>');
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
