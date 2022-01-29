<div class="sidebar-menu">
			<div class="sidebar-menu-inner">
				<header class="logo-env">
					<!-- logo collapse icon -->
					<div class="sidebar-collapse"> <a href="#" class="sidebar-collapse-icon">
							<!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
							<i class="entypo-menu"></i> </a> </div>
					<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
					<div class="sidebar-mobile-menu visible-xs"> <a href="#" class="with-animation">
							<!-- add class "with-animation" to support animation --> <i class="entypo-menu"></i> </a>
					</div>
				</header>
				<div class="sidebar-user-info" style="display: none;">
					<div class="sui-normal"> <a href="#" class="user-link"> <img
								src="<?php echo base_url(); ?>assets/images/favicon.ico" width="55" alt="" class="img-circle" />
							<span>Welcome,</span> <strong><?php echo ucwords($this->db->where('admin_id', $this->session->userdata('user_id'))->get('admin')->row()->username); ?></strong> </a> </div>
					<div class="sui-hover inline-links animate-in"> <a href="#"> <i class="entypo-pencil"></i>
							New Page
						</a> <a href="#"> <i class="entypo-mail"></i>
							Inbox
						</a> <a href="#"> <i class="entypo-lock"></i>
							Log Off
						</a> <span class="close-sui-popup">&times;</span></div>
				</div>
				<ul id="main-menu" class="main-menu">
					<li class="<?php if($page_name == 'dashboard'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>"><i
								class="entypo-gauge"></i><span class="title">Dashboard</span></a>
					</li>
					<li class="<?php if($page_name == 'members'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>members"><i
								class="entypo-users"></i><span class="title">Members</span></a>
                    </li>
					<li class="<?php if($page_name == 'payments'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>payments"><i
								class="fa fa-bank"></i><span class="title">Payments</span></a>
                    </li>
					<li class="<?php if($page_name == 'contributions'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>contributions"><i
								class="fa fa-money"></i><span class="title">Contributions</span></a>
                    </li>
					<li class="<?php if($page_name == 'loans'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>loans"><i
								class="entypo-book"></i><span class="title">Loans</span></a>
                    </li>
					<li class="has-sub <?php if($page_name == 'reciepts_monthly' || $page_name == 'reciepts_total'){ echo 'active'; }?>"> <a href="https://demo.neontheme.com/dashboard/main/">
						<i class="entypo-gauge"></i><span class="title">Reciepts</span></a>
						<ul>
							<li class="<?php if($page_name == 'reciepts_monthly' || $page_name == 'reciepts_total'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>reciepts/monthly"><i
									class="entypo-book-open"></i><span class="title">Monthly Reciepts</span></a>
							</li>
							<li class="<?php if($page_name == 'reciepts_monthly' || $page_name == 'reciepts_total'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>reciepts/total"><i
									class="entypo-book-open"></i><span class="title">Total Reciepts</span></a>
							</li>
						</ul>
                    </li>
					<li class="has-sub <?php if($page_name == 'payroll' || $page_name == 'payroll_list'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>payroll">
						<i class="entypo-tag"></i><span class="title">Payroll</span></a>
						<ul>
							<li class="<?php if($page_name == 'payroll' || $page_name == 'payroll_list'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>payroll"><i
									class="entypo-book-open"></i><span class="title">Create Payroll</span></a>
							</li>
							<li class="<?php if($page_name == 'payroll' || $page_name == 'payroll_list'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>payroll_list"><i
									class="entypo-book-open"></i><span class="title">Payroll List</span></a>
							</li>
						</ul>
                    </li>
					<li class="<?php if($page_name == 'managepayments'){ echo 'active'; }?>"> <a href="<?php echo base_url(); ?>managepayments"><i
								class="entypo-chart-bar"></i><span class="title">Income/Expense Categories</span></a>
                    </li>
				</ul>
			</div>
		</div>