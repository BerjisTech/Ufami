<div id="invoice_print">
	<table width="100%" border="0">
		<tr>
			<td width="50%"><img src="<?php echo base_url(); ?>assets/images/favicon.ico" style="max-height:80px;"></td>
			<td align="right">
				<h4>Invoice Number : <?php echo $payment->invoice; ?></h4>
				<h5>Issue Date : <?php echo date('d M, Y', $payment->date); ?></h5>
				<h5>Due Date : <?php echo date('d M, Y', $payment->date); ?></h5>
				<h5>Status : paid</h5>
			</td>
		</tr>
	</table>
	<hr>
	<table width="100%" border="0">
		<tr>
			<td align="left">
				<h4>Payment To </h4>
			</td>
			<td align="right">
				<h4>Bill To </h4>
			</td>
		</tr>

		<tr>
			<td align="left" valign="top">
				<?php if($payment->type == 'income'): echo 'Ufami Sacco'; else: echo $payment->name; endif;?><br />
                <?php 
                    if($payment->type == 'income'): 
                        echo '0700 264901'; 
                    else: 
                        if($this->db->where('member_id', $payment->member)->get('members')->num_rows != '0')
                        echo $this->db->where('member_id', $payment->member)->get('members')->row()->phone; 
                    endif;?><br>
			</td>
			<td align="right" valign="top">
                <?php if($payment->type == 'expense'): echo 'Ufami Sacco'; else: echo $payment->name; endif;?><br>
                <?php 
                    if($payment->type == 'expense'): 
                        echo '0700 264901'; 
                    else: 
                        if($this->db->where('member_id', $payment->member)->get('members')->num_rows != '0')
                        echo $this->db->where('member_id', $payment->member)->get('members')->row()->phone; 
                    endif;?><br>
			</td>
		</tr>
	</table>
	<hr>
	<h4>Invoice Entries</h4>
	<table width="100%" border="1">
		<thead>
			<tr>
				<th style="padding: 9px;" class="text-center">#</th>
				<th style="padding: 9px;" width="60%">Entry</th>
				<th style="padding: 9px;">Price</th>
			</tr>
		</thead>

		<tbody>
			<!-- INVOICE ENTRY STARTS HERE-->
			<div id="invoice_entry">
				<tr>
					<td style="padding: 9px;" class="text-center">1</td>
					<td style="padding: 9px;">
						<?php echo $this->db->where('category_id', $payment->category)->get('payment_categories')->row()->category_name;?> </td>
					<td style="padding: 9px;" class="text-right">
						KES <?php echo number_format($payment->amount); ?> </td>
				</tr>
			</div>
			<!-- INVOICE ENTRY ENDS HERE-->
		</tbody>
	</table><br />
	<table width="100%" border="0">
		<tr>
			<td align="right" width="80%">Sub Total :</td>
			<td align="right">KES <?php echo number_format($payment->amount); ?></td>
		</tr>
		<tr>
			<td align="right" width="80%">Discount :</td>
			<td align="right">KES <?php echo number_format($payment->amount); ?> </td>
		</tr>
		<tr>
			<td colspan="2">
				<hr style="margin:0px;">
			</td>
        </tr>
		<tr style="margin-top: 10px;">
			<td align="right" width="80%">
				<h4>Grand Total :</h4>
			</td>
			<td align="right">
				<h4>KES <?php echo number_format($payment->amount); ?> </h4>
			</td>
		</tr>
	</table>
</div>
<br>

<a onClick="PrintElem('#invoice_print')" class="btn btn-primary btn-icon icon-left hidden-print">
	Print Invoice
	<i class="entypo-doc-text"></i>
</a>
<br><br>

 




<script type="text/javascript">

	function PrintElem(elem) {
		Popup($(elem).html());
	}

	function Popup(data) {
		var mywindow = window.open('', 'invoice', 'height=800,width=1400');
		mywindow.document.write('<html><head><title>Invoice</title>');
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