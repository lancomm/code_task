<?php

echo $this->load->view("elements/flash_messages", $this->session->flashdata(), true);
?>
<div id="main" role="main">
	<div id="content" class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-1">

                <form role="form" action="<?php echo base_url()?>index.php/admin/login" name="adminlogin" id="adminlogin" method="post" class="smart-form client-form">

					<?php
					if (!empty($_SESSION['REQUEST_URI'])) {
						?>
						<input
							name="redirect_url" type="hidden" value="<?php echo $_SESSION['REQUEST_URI'];?>"
						>
						<?php
					}
					?>
					<fieldset>
						<section>
							<label class="label">E-mail</label>
							<label class="input">
								<i class="icon-append fa fa-user"></i>
								<input name="user_name" class="form-control required" placeholder="Email" type="email" value="<?php echo @$_POST['user_name'];?>">
								<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address</b>
							</label>
							<div style='padding-top:5px !important;'>
	                            <font color='red'>
	                                <?php echo form_error('user_name', '<div class="error">', '</div>'); ?>
	                            </font>
	                        </div>
						</section>

						<section>
							<label class="label">Password</label>
							<label class="input"> <i class="icon-append fa fa-lock"></i>
								<input class="form-control required" placeholder="Password" name="user_password" type="password" value="<?php echo @$_POST['user_password'];?>">
								<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
							<div class="note">
								<a href="../admin/reset_password">Forgot password?</a><br />
								<a href="../users/add">Register User</a><br />
								
							</div>
							<div style='padding-top:5px !important;'>
	                            <font color='red'>
	                                <?php echo form_error('user_password', '<div class="error">', '</div>'); ?>
	                            </font>
	                        </div>
						</section>
					</fieldset>
					<footer>
						<button type="submit" class="btn btn-primary">
							Sign in
						</button>
					</footer>
				</form>
			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->

