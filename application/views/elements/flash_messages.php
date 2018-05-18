
<?php
if (!empty($this->session->flashdata('msg'))) {
    ?>
    <div class="alert alert-info alert-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Info!</strong>
        <?php
        echo $this->session->flashdata('msg');
        ?>
    </div>
    <?php
}
if (!empty($this->session->flashdata('error'))) {
    ?>
    <div class="alert alert-danger alert-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Error!</strong>
        <?php
        echo $this->session->flashdata('error');
        ?>
    </div>
    <?php
}

if (!empty($this->session->flashdata('success'))) {
    ?>
    <div class="alert alert-success alert-message">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <strong>Success!</strong>
        <?php
        echo $this->session->flashdata('success');
        ?>
    </div>
    <?php
}
?>
