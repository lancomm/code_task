<?php
if (!empty($search)) {
    echo $this->load->view("elements/search", $search, true);
}
?>
<section id="widget-grid" class="">
    <div class="row">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2><?php if (!empty($title)) { echo $title; } ?></h2>
                </header>
                <div>
                    <div class="jarviswidget-editbox">
                    </div>
                    <div class="widget-body">
                        <div class='pull-right'><?php
                            if (isset($config)) {
                                $start = empty($_GET['per_page']) ? 1 : (($_GET['per_page']-1)* $config['per_page']);

                                if ($total_rows < $config['per_page']) {
                                    $end = $total_rows;
                                } else {
                                    if (empty($_GET['per_page'])) {
                                        $end = $config['per_page'];
                                    } else {
                                        $end = ($_GET['per_page'] == 1+floor($total_rows/$config['per_page']))? $total_rows : (int)$_GET['per_page'] * $config['per_page'] ;
                                    }
                                }

                                echo "Showing ".$start." - ".$end." of ".$total_rows." Results";
                            }

                        ?></div>
                        <table class="table table-bordered">
                            <thead>
    							<tr>
                                    <?php
                                    
                                    foreach ($headers as $key => $values) {
                                    ?>
                                    <th <?php
                                        if (!empty($values['data-class'])) {
                                            echo 'data-class="'.$values['data-class'].'"';
                                        }
                                        ?>
                                    ><?php echo trim($key); ?></th>
                                    <?php
                                    }
                                    ?>
    							</tr>
    						</thead>
                            <tbody>
                                <?php
                                if (!empty($rows)) {
                                    foreach ($rows as $row => $tds) {
                                        foreach ($tds as $id => $tdArray) {
                                            $count = count($tdArray);
                                            $i = 0;
                                            foreach ($tdArray as $td) {
                                            ?>
                                            <td><?php echo $td; ?></td>
		                                              <?php
		                                              $i++;
		                                              if ($i == $count) {
		                                              $i = 0;
		                                              if (isset($actions) && $actions != false) {
		                                              if (!empty($actions['hide'])) {
		                                                  $show_checked = "checked";
		                                                  $hide_checked = "checked";
		                                                  $hide_row[$id] == 0 ? $hide_checked = "":$show_checked = "checked";
		                                                  ?>
		                                                  <td style="text-align:center">
		                                                      <input type="radio"
		                                                      class="hide-row"
		                                                      data-href="<?php
		                                                      echo base_url().''.$this->router->fetch_class().'/show_hide/'.$id;
		                                                      ?>"
		                                                      data-hide="<?php
		                                                      echo ($hide_row[$id] == 0 ? "1":"0");
		                                                      ?>
		                                                      "
		                                                      name="hide_<?php echo $id;?>"
		                                                      <?php echo $show_checked;?> />
		                                                  </td>
		                                                  <td style="text-align:center">
		                                                      <input
		                                                      class="hide-row"
		                                                      type="radio" data-href="<?php
		                                                      echo base_url().''.$this->router->fetch_class().'/show_hide/'.$id;
		                                                      ?>"
		                                                      data-hide="<?php
		                                                      echo ($hide_row[$id] == 0 ? "1":"0");
		                                                      ?>
		                                                      "
		                                                      name="hide_<?php echo $id;?>"
		                                                      <?php echo $hide_checked;?> />
		                                                  </td>
		                                                  <?php
		                                              }
		                                              ?>
                                                        <td>
                                                            <div class='table_actions' data-id='<?php echo $id;?>' >
                                                            <?php
                                                            if (!empty($actions['notes'])) {
                                                                ?>
                                                                <a href="<?php echo base_url().''.$this->router->fetch_class().'/add_note/'.$id;?>">
                                                                    <button class="btn btn-xs btn-default">
                                                                        <i class="fa fa-comments-o"></i>
                                                                    </button>
                                                                </a>
                                                                <?php
                                                            }
                                                            if (!empty($actions['approve'])) {
                                                                ?>
                                                                <button class="btn  btn-xs btn-default table_approve"
                                                                    data-id="<?php
                                                                        echo $id;
                                                                    ?>"
                                                                    data-attr-url="<?php
                                                                    if ($actions['approve'] !== true) {
                                                                        echo base_url().''.$this->router->fetch_class().'/'.$actions['approve'].'/'.$id;
                                                                    } else {
                                                                        echo "/".$this->router->fetch_class()."/approve/".$id;
                                                                    }?>
                                                                    "
                                                                    >
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                                <?php
                                                            }
                                                            if (!empty($actions['edit'])) {
                                                                if ($actions['edit'] !== true) {
                                                                    ?>
                                                                    <a title="Edit" href="<?php
                                                                        echo base_url().''.$this->router->fetch_class().'/'.$actions['edit'].'/'.$id;
                                                                    ?>">
                                                                        <button class="btn btn-xs btn-default" type="button">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                <?php
                                                                } else {
                                                                    ?>
                                                                    <a title='Edit' href="<?php echo base_url().''.$this->router->fetch_class().'/edit/'.$id;?>">
                                                                        <button class="btn btn-xs btn-default" type="button">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                    </a>
                                                                    <?php
                                                                }
                                                            }
                                                            if (!empty($actions['delete'])) {
                                                                ?>
                                                                <button title='Delete' class="btn btn-xs btn-default"
                                                                    data-href="<?php
                                                                    if ($actions['delete'] !== true) {
                                                                        echo base_url().''.$this->router->fetch_class().'/'.$actions['delete'].'/'.$id;
                                                                    } else {
                                                                        echo "/".$this->router->fetch_class()."/delete/".$id;
                                                                    }?>
                                                                    "
                                                                    data-toggle="modal" data-target="#confirm-delete">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                                <?php
                                                            }                                                           
                                                            if (isset($custom_actions)) {
                                                                foreach ($custom_actions as $action_key => $action_value) {
                                                                    echo $action;
                                                                }
                                                            }
                                                            ?>
                                                            </div>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                    </tr>
                                                <?php
                                                }
                                            }
                                        }
                                    }
                                } else {
                                ?>
                                    <td colspan="<?php echo count($headers);?>" align="center"  style="font-weight:bold">No Records Found</td>
                                <?php
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                    <?php
                        if (isset($this->pagination)) {
                            echo $this->pagination->create_links();
                        }
                    ?>
                </div>
    		</div>
    	</article>
    </div>
</section>
