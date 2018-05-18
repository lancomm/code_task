<?php echo $this->load->view("admin/includes/login_top", $this->data, true)?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Change Password</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="<?php echo base_url()?>Admin/change_password?tok=<?php echo $_GET['tok'];?>" name="new_password" id="new_password" method="post">
                            <fieldset>
                                <div class="form-group">
                                <input name="user_id" value="<?php echo $this->data['user_id'];?>" type="hidden" />
                                <input name="tok" value="<?php echo $_GET['tok'];?>" type="hidden" />
                                 <?php echo form_error('user_password'); ?>
                                    <input class="form-control required" placeholder="" id="password" type="password" name="password"  autocomplete="off">
                                   <script>
                                   	$('#password').val();
                                   </script>
                                </div>
                                <input type="submit" name="" value="Change Password" class="btn btn-lg btn-success btn-block">
                                <?php
                                if (@$errorMsg != ''){
									echo $errorMsg;
								}
                                ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo $this->load->view("admin/includes/footer", $this->data, true)?>
