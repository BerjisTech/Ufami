<?php #echo $this->db->select('date_format(from_unixtime(date_joined), "%Y") as dateformat')->get('members')->row()->dateformat; 
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		// Sample Toastr Notification
		setTimeout(function() {
			var opts = {
				"closeButton": true,
				"debug": false,
				"positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
				"toastClass": "success",
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};
			toastr.success("Date: <?php echo date('d M, Y'); ?><br />Time: <?php echo date('H:i'); ?>", "Morning", opts);
		}, 3000);

		// Sparkline Charts
		$(".top-apps").sparkline('html', {
			type: 'line',
			width: '50px',
			height: '15px',
			lineColor: '#00acd6',
			fillColor: '',
			lineWidth: 2,
			spotColor: '#344e86',
			minSpotColor: '#344e86',
			maxSpotColor: '#344e86',
			highlightSpotColor: '#344e86',
			highlightLineColor: '#30487b',
			spotRadius: 2,
			drawNormalOnTop: true
		});
		$(".registrations").sparkline([<?php
										foreach ($this->db->select('*, count(member_id) as registrations, date_format(from_unixtime(date_joined), "%Y %m %d") as year, date_format(from_unixtime(date_joined), "%m") as month')->where('date_joined >=', strtotime('01-01-2018'))->group_by('month')->order_by('year', 'asc')->get('members')->result_array() as $fetch) {
											echo $fetch['registrations'] . ',';
										}
										?>], {
			type: 'line',
			width: '100%',
			height: '55',
			lineColor: '#e8b51b',
			fillColor: '',
			lineWidth: 2,
			spotColor: '#344e86',
			minSpotColor: '#344e86',
			maxSpotColor: '#344e86',
			highlightSpotColor: '#344e86',
			highlightLineColor: '#30487b',
			spotRadius: 2,
			drawNormalOnTop: true
		});
		$(".pie-chart").sparkline([<?php echo $this->db->select('sum(amount) as loan')->get('loans')->row()->loan; ?>,
			<?php echo $this->db->select('sum(amount) as deposit')->where('type', '1')->get('contributions')->row()->deposit; ?>,
			<?php echo $this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares; ?>
		], {
			type: 'pie',
			width: '95',
			height: '95',
			sliceColors: ['#ec3b83', '#00acd6', '#e8b51b']
		});


		$(".contributions").sparkline([<?php
										foreach ($this->db->select('sum(amount) as contributions,date_format(from_unixtime(date), "%Y %m %d") as year, date_format(from_unixtime(date), "%m %Y") as month')->where('type', '1')->where('date >=', strtotime('01-01-2018'))->group_by('month')->order_by('year', 'asc')->get('contributions')->result_array() as $fetch) {
											echo $fetch['contributions'] . ',';
										}
										?>], {
			type: 'line',
			width: '100%',
			height: '55',
			lineColor: '#ec3b83',
			fillColor: '',
			lineWidth: 2,
			spotColor: '#344e86',
			minSpotColor: '#344e86',
			maxSpotColor: '#344e86',
			highlightSpotColor: '#344e86',
			highlightLineColor: '#30487b',
			spotRadius: 2,
			drawNormalOnTop: true
		});

		$(".share-capital").sparkline([<?php
										foreach ($this->db->select('sum(amount) as contributions, date_format(from_unixtime(date), "%m %Y") as month, date_format(from_unixtime(date), "%Y %m %d") as year')->where('type', '2')->where('date >=', strtotime('01-01-2018'))->group_by('month')->order_by('year', 'asc')->get('contributions')->result_array() as $fetch) {
											echo $fetch['contributions'] . ',';
										}
										?>], {
			type: 'line',
			width: '100%',
			height: '55',
			lineColor: '#00acd6',
			fillColor: '',
			lineWidth: 2,
			spotColor: '#344e86',
			minSpotColor: '#344e86',
			maxSpotColor: '#344e86',
			highlightSpotColor: '#344e86',
			highlightLineColor: '#30487b',
			spotRadius: 2,
			drawNormalOnTop: true
		});
		// Sparkline Charts
		$('.inlinebar').sparkline('html', {
			type: 'bar',
			barColor: '#ff6264'
		});
		$('.inlinebar-2').sparkline('html', {
			type: 'bar',
			barColor: '#445982'
		});
		$('.inlinebar-3').sparkline('html', {
			type: 'bar',
			barColor: '#00b19d'
		});
		$('.bar').sparkline([
			[1, 4],
			[2, 3],
			[3, 2],
			[4, 1]
		], {
			type: 'bar'
		});
		$('.pie').sparkline('html', {
			type: 'pie',
			borderWidth: 0,
			sliceColors: ['#3d4554', '#ee4749', '#00b19d']
		});
		$('.linechart').sparkline();
		$('.loanrequest').sparkline('html', {
			type: 'bar',
			height: '30px',
			barColor: '#ff6264'
		});
		$('.approvedloans').sparkline('html', {
			type: 'bar',
			height: '30px',
			barColor: '#00b19d'
		});

		$(".monthly-sales").sparkline([<?php
										foreach ($this->db->select('count(member_id) as members, date_format(from_unixtime(date_joined), "%m") as month, date_format(from_unixtime(date_joined), "%Y %m %d") as year')->where('status', '1')->group_by('month')->order_by('year', 'asc')->get('members')->result_array() as $fetch) {
											echo $fetch['members'] . ',';
										}
										?>], {
			type: 'bar',
			barColor: '#485671',
			height: '80px',
			barWidth: 10,
			barSpacing: 2
		});

		// JVector Maps
		var map = $("#map");
		map.vectorMap({
			map: 'europe_merc_en',
			zoomMin: '3',
			backgroundColor: '#383f47',
			focusOn: {
				x: 0.5,
				y: 0.8,
				scale: 3
			}
		});


		// Line Chart
		var line_chart_demo = $("#line-chart-demo");
		var area_chart_demo = $("#area-chart-demo");
		line_chart_demo.parent().show();
		area_chart_demo.parent().show();
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

		last_30_days();
		$('.adjust-stats').change(function() {
			$("#line-chart-demo").empty();
			$("#area-chart-demo").empty();
			$("#donut-chart-demo").empty();
			if ($(this).val() == "0") {
				today();
			}
			if ($(this).val() == "1") {
				yesterday();
			}
			if ($(this).val() == "7") {
				last_7_days();
			}
			if ($(this).val() == "30") {
				last_30_days();
			}
			if ($(this).val() == "90") {
				last_90_days();
			}
			if ($(this).val() == "365") {
				last_365_days();
			}
			if ($(this).val() == "31") {
				last_month();
			}
			if ($(this).val() == "366") {
				last_year()
			}
			if ($(this).val() == "all") {
				all_time();
			}
			if ($(this).val() == "") {
				last_30_days();
			}
		});



		function yesterday() {
			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 48; $m > 23; $m--) {
						$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
						$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

							y: '<?php echo date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				resize: true,
				smooth: true,
				xLabelFormat: function(x) {
					let shit = new Date(x);
					let date = x.getDate();
					let monthy = months[x.getMonth()];
					let hours = x.getHours();
					let minutes = x.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					let date = shit.getDate();
					let monthy = months[shit.getMonth()];
					let hours = shit.getHours();
					let minutes = shit.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');

			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 48; $m > 23; $m--) {
						$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
						$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

							y: '<?php echo date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				resize: true,
				smooth: true,
				xLabelFormat: function(x) {
					let shit = new Date(x);
					let date = x.getDate();
					let monthy = months[x.getMonth()];
					let hours = x.getHours();
					let minutes = x.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					let date = shit.getDate();
					let monthy = months[shit.getMonth()];
					let hours = shit.getHours();
					let minutes = shit.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');

			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-23 hours')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-48 hours')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');


		}

		function today() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 24; $m > -1; $m--) {
						$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
						$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

							y: '<?php echo date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				resize: true,
				xLabelFormat: function(x) {
					let shit = new Date(x);
					let date = x.getDate();
					let monthy = months[x.getMonth()];
					let hours = x.getHours();
					let minutes = x.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					let date = shit.getDate();
					let monthy = months[shit.getMonth()];
					let hours = shit.getHours();
					let minutes = shit.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				smooth: true,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');

			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 24; $m > -1; $m--) {
						$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
						$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

							y: '<?php echo date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				resize: true,
				xLabelFormat: function(x) {
					let shit = new Date(x);
					let date = x.getDate();
					let monthy = months[x.getMonth()];
					let hours = x.getHours();
					let minutes = x.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					let date = shit.getDate();
					let monthy = months[shit.getMonth()];
					let hours = shit.getHours();
					let minutes = shit.getMinutes();
					var ampm = hours >= 12 ? 'pm' : 'am';
					hours = hours % 12;
					hours = hours ? hours : 12; // the hour '0' should be '12'
					minutes = minutes < 10 ? '0' + minutes : minutes;
					var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
					var douche = strTime;
					return douche;
				},
				smooth: true,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');


			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 hours')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-24 hours')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_30_days() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 30; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#E8B51B'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');


			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 30; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');

			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-30 days')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_7_days() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 7; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');


			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 7; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');


			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-7 days')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_90_days() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 90; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');


			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 90; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');


			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-90 days')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_365_days() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 12; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m', $nowmonth); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(x) {
					var month = months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');


			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 12; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m', $nowmonth); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(x) {
					var month = months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');


			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 months')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-12 months')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_month() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 60; $m > 29; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');


			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 60; $m > 29; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

							y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(d) {
					return d.getDate() + ' ' + months[d.getMonth()];
				},
				dateFormat: function(x) {
					let shit = new Date(x);
					var douche = shit.getDate() + ' ' + months[shit.getMonth()];
					return douche;
				},
				resize: true,
				smooth: true,
				pointSize: 0,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');


			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-29 days')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-60 days')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

		function last_year() {
			// Line Charts

			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = 24; $m > 11; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m', $nowmonth); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(x) {
					var month = months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');



			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = 24; $m > 11; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m', $nowmonth); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(x) {
					var month = months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');



			// Donut Chart
			<?php
			$lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-11 months')));
			$nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-24 months')));
			?>
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$loan = $this->db->select('sum(amount) as loan')->where($where)->get('loans')->row()->loan;
								if ($loan == '') {
									echo '0';
								} else {
									echo $loan;
								}
								?>
					},
					{
						label: "Share Capital",
						value: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								} ?>
					},
					{
						label: "Member Savings",
						value: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$deposists = $this->db->select('sum(amount) as deposit')->where($where)->get('contributions')->row()->deposit;
								if ($deposists == '') {
									echo '0';
								} else {
									echo $deposists;
								} ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
			<?php #echo $this->db->last_query();  
			?>
		}

		function all_time() {
			// Line Charts
			<?php
			$ts1 = strtotime('17 June 2018');
			$ts2 = time();

			$year1 = '2018';
			$year2 = date('Y', $ts2);

			$month1 = '06';
			$month2 = date('m', $ts2);

			$diff = ((($year2 - $year1) * 12) + ($month2 - $month1));
			?>
			var line_chart = Morris.Line({
				element: 'line-chart-demo',
				data: [
					<?php
					for ($m = $diff; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m-d', $nowmonth); ?>',
							a: <?php
								$where = "`type` = '1' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`type` = '2' AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('contributions')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b'],
				labels: ['Deposits', 'Shares'],
				lineColors: ['#ec3b83', '#00acd6'],
				xLabelFormat: function(x) {
					var month = x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			line_chart_demo.parent().attr('style', 'width: 100% !important;');

			var area_chart = Morris.Area({
				element: 'area-chart-demo',
				data: [
					<?php
					for ($m = $diff; $m > -1; $m--) {
						$nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
						$lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

							y: '<?php echo date('Y-m-d', $nowmonth); ?>',
							a: <?php
								$where = "`date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							b: <?php
								$where = "`status` = '1' AND `date_taken` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loans')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>,
							c: <?php
								$where = "`date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
								$shares = $this->db->select('sum(amount) as shares')->where($where)->get('loan_payments')->row()->shares;
								if ($shares == '') {
									echo '0';
								} else {
									echo $shares;
								}
								?>
						},

					<?php } #echo $this->db->last_query(); 
					?>
				],
				xkey: 'y',
				ykeys: ['a', 'b', 'c'],
				labels: ['Requested', 'Approved', 'Paid'],
				lineColors: ['#ec3b83', '#00acd6', '#e8b51b'],
				xLabelFormat: function(x) {
					var month = x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
					return month;
				},
				dateFormat: function(x) {
					let d = new Date(x)
					var month = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();;
					return month;
				},
				resize: true,
				smooth: true,
				redraw: true
			});
			area_chart_demo.parent().attr('style', 'width: 100% !important;');

			// Donut Chart
			var donut_chart_demo = $("#donut-chart-demo");
			donut_chart_demo.parent().show();
			var donut_chart = Morris.Donut({
				element: 'donut-chart-demo',
				data: [{
						label: "Loans",
						value: <?php echo $this->db->select('sum(amount) as loan')->get('loans')->row()->loan; ?>
					},
					{
						label: "Share Capital",
						value: <?php echo $this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares; ?>
					},
					{
						label: "Member Savings",
						value: <?php echo $this->db->select('sum(amount) as deposit')->where('type', '1')->get('contributions')->row()->deposit; ?>
					}
				],
				colors: ['#ec3b83', '#00acd6']
			});
			donut_chart_demo.parent().attr('style', 'width: 100% !important;');
		}

	});

	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
</script>
<div class="row">
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3><?php echo number_format($this->db->select('sum(amount) as shares')->where('type', '1')->get('contributions')->row()->shares); ?></h3>
			<p>Total Monthly Deposits</p> <span class="contributions"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3><?php echo $this->db->select('count(member_id) as members')->where('status', '1')->get('members')->row()->members; ?> Members</h3>
			<p><?php echo $this->db->select('count(member_id) as members')->where('status', '1')->where('date_format(from_unixtime(date_joined), "%m %Y") =', date('m Y'))->get('members')->row()->members; ?> more registered this month</p> <span class="registrations"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<h3><?php echo number_format($this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares); ?></h3>
			<p>Total Shares</p> <span class="share-capital"></span>
		</div>
	</div>
	<div class="col-md-3 col-sm-6">
		<div class="tile-stats tile-white stat-tile">
			<p>
				<?php
				$deposits = $this->db->select('sum(amount) as shares')->where('type', '1')->get('contributions')->row()->shares;
				$shares = $this->db->select('sum(amount) as shares')->where('type', '2')->get('contributions')->row()->shares;
				$loans = $this->db->select('sum(amount) as shares')->get('loans')->row()->shares;

				$total = $deposits + $shares + $loans;
				?>
				<span style="color: #ec3b83;">Loans <?php echo number_format((float)($loans * 100) / $total, 1, '.', ''); ?>%</span> <br />
				<span style="color: #00acd6;">Deposits <?php echo number_format((float)($deposits * 100) / $total, 1, '.', ''); ?>%</span> <br />
				<span style="color: #e8b51b;">Shares <?php echo number_format((float)($shares * 100) / $total, 1, '.', ''); ?>%</span>
			</p> <span class="pie-chart"></span>
		</div>
	</div>
</div> <br />
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="input-group">
						<select class="form-control adjust-stats">
							<option value="">Choose stats time</option>
							<option value="0">Last 24 hours</option>
							<option value="1">Yesterday</option>
							<option value="7">Last 7 days</option>
							<option value="30">Lat 30 days</option>
							<option value="90">Last 90 days</option>
							<option value="365">Last 365 days</option>
							<option value="31">Last month</option>
							<option value="366">Last year</option>
							<option value="all">All Time</option>
						</select>
					</div>
				</div>
				<div class="panel-options">
					<ul class="nav nav-tabs">
						<li class=""><a href="#area-chart" data-toggle="tab">Loans</a></li>
						<li class="active"><a href="#line-chart" data-toggle="tab">Deposits &amp; Shares</a></li>
						<li class=""><a href="#pie-chart" data-toggle="tab">Comparison Chart</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane" id="area-chart">
						<div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
					</div>
					<div class="tab-pane active" id="line-chart">
						<div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
					</div>
					<div class="tab-pane" id="pie-chart">
						<div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <br />
<div class="row">
	<div class="col-sm-4">
		<div class="panel panel-primary">
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th class="padding-bottom-none text-center"> <br /> <br /> <span class="monthly-sales"></span> </th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="panel-heading">
							<h4>Monthly Registrations</h4>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-8">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Latest registrations</div>
				<div class="panel-options"> <a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> <a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a> <a href="#" data-rel="close"><i class="entypo-cancel"></i></a> </div>
			</div>
			<table class="table table-bordered table-responsive">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->db->where('status', '1')->order_by('member_id', 'DESC')->limit('3')->get('members')->result_array() as $fetch) : ?>
						<tr>
							<td><?php echo $fetch['member_id'] ?></td>
							<td><?php echo $fetch['name'] ?></td>
							<td class="text-center"><span class="inlinebar">
									<?php
									foreach ($this->db->select('sum(amount) as contributions, date_format(from_unixtime(date), "%m") as month, date_format(from_unixtime(date), "%Y %m %d") as year')->where('type', '1')->where('member', $fetch['member_id'])->group_by('month')->order_by('year', 'asc')->get('contributions')->result_array() as $fetch) {
										echo $fetch['contributions'] . ',';
									}
									?>
								</span></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div> <br />