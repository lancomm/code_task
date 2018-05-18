<?php
echo $this->load->view("elements/flash_messages", $this->session->flashdata(), true);
?>
<div id="main" role="main">
	<div id="content" class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <form role="form" action="<?php echo base_url()?>admin/send_reset_email" name="adminlogin" id="adminlogin" method="post" class="smart-form client-form">
                    <fieldset>
						<section>
							<label class="label">E-mail</label>
							<label class="input">
								<i class="icon-append fa fa-user"></i>
								<input name="email" class="form-control required" required placeholder="Email"  type="email" autofocus value="<?php echo @$_POST['email'];?>">
								<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address</b>
							</label>
							<div style='padding-top:5px !important;'>
	                            <font color='red'>
	                                <?php echo form_error('user_name', '<div class="error">', '</div>'); ?>
	                            </font>
	                        </div>
						</section>
					</fieldset>
                    <footer>
                        <button type="submit" class="btn btn-primary">Send Reset Email</button>
                        <a href="<?php echo base_url()?>index.php/admin/login">Cancel</a>
                    </footer>
                </form>
            </div>
        </div>
    </div>
</div>


