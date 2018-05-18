<?php
echo $this->load->view("admin/includes/top", $this->data, true);
?>
<div class="row">
    <div class="col-md-12">
        <h3>
            Permission settings for <?php echo $name; ?>
        </h3>
    </div>
</div>
<br />
<form action="" name="settings_form" method="post">
    <?php
        echo $this->load->view("elements/permissions_settings.php", $this->data, true);
    ?>
</form>
<?php
echo $this->load->view("admin/includes/footer", $this->data, true);
?>
