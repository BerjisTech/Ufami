<div id="invoice_print" style="display: block; font-family: Segoe UI; margin-bottom: 50px;">
<style>@page { size: auto; margin: 4em 4em 6em 4em; }</style>
<br /><br /><br /><br /><br/><br />
	<h2 style="text-align: center;">Ufami Sacco <?php echo date('Y'); ?> General Loan Report</h2>
	
	<p style="font-size: 20px; text-align: center;">
		<strong><?php echo number_format($this->db->group_by('member')->get('loans')->num_rows());?></strong> Members have borrowed <strong><?php echo number_format($this->db->get('loans')->num_rows());?></strong> loans summing up to <strong>Kshs <?php echo number_format($this->db->select('sum(amount) as total')->get('loans')->row()->total); ?></strong> since <strong><?php echo date('d M, Y', $this->db->order_by('loan_id', 'ASC')->limit('1')->get('loans')->row()->date_taken)?></strong>.<br />
	</p>
	<hr />
    <table style="width: 100%; height: auto; border-collapse: collapse; border: none;">
        <tr>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">S/No</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Date</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Name</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">M/No</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Repay</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Principal</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Interest</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Totals</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Last Date<br /> Due</th>
            <th style="padding: 6px; font-weight: bold; text-align: center; border: 1px solid black; width: auto;">Amount<br /> Due</th>
        </tr>
		<?php foreach($loan as $key => $load): ?>
    		<tr>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo $key + 1; ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo date('d/m/Y', $load['date_taken']); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo ucwords($this->db->where('member_id', $load['member'])->get('members')->row()->name); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo $load['member']; ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo number_format($this->db->select('sum(amount) as total')->where('loan_id', $load['loan_id'])->get('loan_payments')->row()->total); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo number_format($load['amount']); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">
    		        <?php
 	   	            	if($load['type'] == 1 || $load['type'] == 4 || $load['type'] == 5){
 	                    	foreach($this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->result_array() as $key => $fetch): 
                                if($key == 0){
                                    $interest[$key] = $load['amount']*0.01;
                                    $amdue = $load['amount'] + $interest[$key];
                                    $amtdue[$key] = $amdue - $fetch['amount'];
									#echo '<pre> with interest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
									/*echo $interest[$key];
                                    echo ' month ';
                                    echo $key + 1;
                                    echo ' ('. date('M', $fetch['date']) .')';
                                    echo '<br />';*/
                                }else{
                                    $interest[$key] = $amtdue[$key - 1]*0.01;
                                    $amdue = $amtdue[$key - 1] + $interest[$key];
                                    $amtdue[$key] = $amdue - $fetch['amount'];
                                    #echo '<pre> with interest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                    /*echo $interest[$key];
                                    echo ' month ';
                                    echo $key + 1;
                                    echo ' ('. date('M', $fetch['date']) .')';
                                    echo '<br />';*/
                                }
                                if($key == $this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1){
                                    echo number_format(array_sum($interest));
                                    #echo $amtdue[$this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1]*0.01.' (New Interest)';
                                }
                            endforeach;
                        }
                        if($load['type'] == 2){
                            echo number_format($load['amount']*0.12);
                        }
                        if($load['type'] == 3 || $load['type'] == 7){
                            echo number_format($load['amount']*0.1);
                        }
                        if($load['type'] == 6){
                            echo number_format($load['amount']*0.15);
                        }
                    ?>
                </td>
                <td style="padding: 6px; border: 1px solid black; width: auto;">
                    <?php
                        
                            if($load['type'] == 1 || $load['type'] == 4 || $load['type'] == 5){
                                foreach($this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->result_array() as $key => $fetch): 
                                    if($key == 0){
                                        $interest[$key] = $load['amount']*0.01;
                                        $amdue = $load['amount'] + $interest[$key];
                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                    }else{
                                        $interest[$key] = $amtdue[$key - 1]*0.01;
                                        $amdue = $amtdue[$key - 1] + $interest[$key];
                                        $amtdue[$key] = $amdue - $fetch['amount'];
                                        #echo '<pre> with ineterest('.$interest[$key].') :    '.$amdue.'-'. $fetch['amount'].'='.$amtdue[$key].'</pre>';
                                    }
                                    if($key == $this->db->order_by('loan_id', 'DESC')->where('loan_id', $load['loan_id'])->get('loan_payments')->num_rows() - 1){
                                        echo number_format($load['amount'] + array_sum($interest));
                                    }
                                endforeach;
                            }
                            if($load['type'] == 2){
                                echo number_format($load['amount'] + ($load['amount']*0.12));
                            }
                            if($load['type'] == 3 || $load['type'] == 7){
                                echo number_format($load['amount'] + ($load['amount']*0.1));
                            }
                            if($load['type'] == 6){
                                echo number_format($load['amount'] + ($load['amount']*0.15));
                            }
                    ?>
                </td>
                <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo date('d/m/Y', $load['date_to_pay']); ?></td>
                <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo number_format($load['amountdue']); ?></td>
            </tr>                         
        <?php endforeach; ?>
        <tr style="font-weight: bold;">
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">TOTALS</td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">--</td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">--</td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">--</td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo number_format($this->db->select('sum(amount) as total')->get('loan_payments')->row()->total); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;"><?php echo number_format($this->db->select('sum(amount) as total')->get('loans')->row()->total); ?></td>
    		    <td style="padding: 6px; border: 1px solid black; width: auto;">--- </td>
                <td style="padding: 6px; border: 1px solid black; width: auto;">---</td>
                <td style="padding: 6px; border: 1px solid black; width: auto;">---</td>
                <td style="padding: 6px; border: 1px solid black; width: auto;">
                <?php echo number_format($this->db->select('sum(amount) as total')->get('loans')->row()->total - $this->db->select('sum(amount) as total')->get('loan_payments')->row()->total); ?>
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
