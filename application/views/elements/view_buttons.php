
<div class='row' style='padding-bottom:50px'>
	<div class='form-submit-div'>
		<div class="col-lg-12" style='text-align:right;'>
	        <a href="<?php
                if (!empty($cancel)) {
                    echo $cancel;
                } else {
                    echo base_url()?><?php echo $this->router->fetch_class();
                }
                ?>"
                style="text-decoration:none;"
            >
				<input name="cancel" type="button" value="Cancel"  class="btn btn-primary form-cancel"/>
			</a>
	        </div>
	    </div>
	</div>
</div>
