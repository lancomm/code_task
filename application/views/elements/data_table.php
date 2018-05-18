<?php

#print_r($headers);
?>
<div id="content">
    <div class="row">
        <!-- NEW WIDGET START -->
        <?php if($title != null){
			echo "<h1>".$title."</h1>" ;
		}?>
        <div class="widget-body no-padding">
            <table style="border:solid 1px black;" width="100%">
                <thead>
                    <tr>
                        <?php
                        foreach ($headers as $key => $values) {
                            ?>
                            <th style="text-align: left;">
                                <?php echo trim($key); ?>
                            </th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if (!empty($rows)) {
                                foreach ($rows as $row => $tds) {
                                    foreach ($tds as $id => $tdArray) {
                                        $count = count($tdArray);
                                        $i     = 0;
                                        foreach ($tdArray as $td) {
                                            ?>
                                            <td>
                                                <?php echo $td; ?>
                                            </td>
                                            <?php
                                            $i++;
                                            if ($i == $count) {
                                                $i = 0;
                                                if (isset($actions) && $actions != false) {
                                                    ?>
                                                    <td>
                                                        <div class='table_actions' data-id='<?php echo $id;?>'>
                                                            <?php
                                                            if (!empty($actions['edit'])) {
                                                                ?>
                                                                <a title='Edit' href="<?php echo base_url().'index.php/'.$actions['edit_method'].'/edit/'.$id;?>">
                                                                    <button class="btn btn-xs btn-default" type="button">
                                                                        Edit
                                                                    </button>
                                                                </a>
                                                                <?php
                                                            }
                                                            if (!empty($actions['delete'])) {
                                                                ?>
                                                                <a title='Delete' class="btn btn-xs btn-default"
																	href="
																    <?php
																	     echo base_url().'index.php/'.$actions['delete_method']."/delete/".$id;
																	?>
																	"
																	>
																	 <button class="btn btn-xs btn-default" type="button">
                                                                    Delete
                                                                    </button>
                                                                </a>
                                                                <?php
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
                            }
                            else {
                                     ?>
                                     <td colspan="<?php echo count($headers);?>" align="center"  style="font-weight:bold">
                                         No Records Found
                                     </td>
                                     <?php
                                     }
                                     ?>
                                      
                                       
                                         <?php
                                         if (!empty($custom_action)) {?>
                                         <td colspan="<?php echo count($headers);?>" align="center"  style="font-weight:bold">
                                         <a href="<?php echo $custom_action['url'];?>">
                                         	<button>
                                         		<?php echo $custom_action['method'];?>
                                         	</button>
                                         </a>
                                            
                                            </td> 
                                        <?php } ?>
                                    
                                     </tr>

                </tbody>
            </table>
            
        </div>
    </div>
</div>

</div>
