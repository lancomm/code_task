<div id='content'>
	<div class='row' style='padding-bottom:25px;padding-right:10px'>
		<div class='form-submit-div'>
			<div class="col-lg-12" style='text-align:right;'>
			<?php
			if (!empty($custom)) {
				echo $custom;
			}
			if (empty($submitButton)) {
			?>
			    <button type="submit" name="" value="save" class="btn btn-primary form-submit">Submit</button>
			<?php
			}
			?>
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
</div>
