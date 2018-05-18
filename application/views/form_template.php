<?php
if (!isset($skipHeader)) {
?>
    <div class="row">
        <div class="col-md-6">
            <legend>
                <?php
                echo $title;
                ?>
            </legend>
        </div>
    </div>
    <?php
    if (!empty($info_message)) {
        ?>
        <div class='row'>
            <div class='col-md-12'>
                <?php
                echo $info_message;
                ?>
            </div>
        </div>
        <br>
        <?php
    }
    ?>
    <div class='row'>
        <div class='col-md-12'>
            <font color='red'>
            <?php
            if (!empty($alert)) {
                echo $alert;
            }
            if (!isset($required_fields)) {
            ?>
            * fields = required
            <?php
            }
            ?>
            </font>
        </div>
    </div>
<?php
}
?>
<div class="panel panel-default" <?php
    if (!empty($form_style)) {
        echo ' style="'.$form_style.'" ';
    }

    if (!empty($form_id)) {
        echo ' id="'.$form_id.'" ';
    }
    ?>
>
    <?php
    if (!empty($panel_heading)) {
    ?>
    <div class="panel-heading">
		<div class="row">
            <?php
            foreach($panel_heading as $pkey => $pheading) {
            ?>
			<div class="col-md-6" style="text-align: center;">
				<a href="#" class="" id="pheading_<?php echo $pkey;?>"><?php echo ucfirst($pkey);?></a>
			</div>
            <?php
            }
            ?>
		</div>
	</div>
    <?php
    }
    ?>
    <div class="panel-body">
        <div class='row'>
            <?php
            $i = 1;
            foreach ($input_group as $key => $input) {
                if (!empty($input['skipCol'])) {
                ?>
            </div>
            <div class='row'>
                <?php
                }
            ?>
            <div class='<?php echo $key;?>_div'>
                <div class="col-md-2">
                    <label><?php
                        if (!empty($input['label'])) {
                            echo $input['label'];
                        } else {
                            $explode = array();
                            $label = array();
                            if (strpos($key, '_')) {
                                if(strpos($key, '_id')) {
                                    $new_key = str_replace('_id', '', $key);
                                } else {
                                    $new_key = $key;
                                }
                                $explode = explode('_', $new_key);
                                foreach ($explode as $word) {
                                    $label[] = ucfirst($word);
                                }
                                echo implode(' ', $label);
                            } else {
                                echo ucfirst($key);
                            }
                        }
                       ?>
                        :
                        <font color='red'>
                        <?php
                            if (!empty($input['required'])) {
                                echo '*';
                            }
                        ?>
                        </font>
                    </label>
                    <?php
                     if (!empty($input['tool-tip'])){
							?>
							<button
                                class="btn btn-xs btn-default"
                                style="float:right;width:19px;height:19px;padding:0;margin-left:20px;"
                                data-content="<?php echo $input['tool-tip'];?>"
                                data-placement="top"
                                data-toggle="popover"
                                data-container="body"
                                type="button"
                            >
						        <i class="fa fa-question"></i>
							</button>
						<?php
						}
                        ?>
                </div>
                <div class="<?php
                    if (!empty($input['col']) AND $input['col'] ==2) {
                        echo 'col-md-10';
                    } else {
                        echo 'col-md-4';
                    }
                    ?>
                ">
                    <div class="form-group">
                        <?php
                        if (!empty($input['input'])) {
                            echo $input['input'];
                        } else {
                            if (!empty($input['type']) && $input['type'] == 'hidden') {
                            ?>
                            <input
                                name="<?php echo $key;?>" id="<?php echo $key;?>"
                                type="hidden"
                                value="<?php
                                    if (isset($this->data[$key])) {
                                        echo $this->data[$key];
                                    }
                                ?>"
                            >
                            <?php
                            } elseif (!empty($input['type']) && $input['type'] == 'select_opt_group') {
                            ?>
                                <select
                                    class='form-control <?php
                                        if (!empty($input['class'])) {
                                            echo $input['class'];
                                        }
                                    ?>'
                                    data-attribute="<?php echo $key;?>[]"
                                    id='<?php
                                        if (!empty($input['id'])) {
                                            echo $input['id'];
                                        } else {
                                            echo $key;
                                        }
                                    ?>'
                                    name="<?php echo $key;?>" id="<?php echo $key;?>"
                                >
                                    <option value=''>Select Value</option>
                                    <?php
                                    foreach($input['options'] as $opt_key => $opt_value) {
                                    ?>
                                        <optgroup label="<?php echo $opt_value['text'];?>">
                                        <?php
                                        if (!empty($opt_value['children'])) {
                                            foreach($opt_value['children'] as $opt_child_key => $opt_child) {
                                            ?>
                                            <option
                                                value="<?php echo $opt_child['value'];?>"
                                                <?php
                                                if (!empty($this->data[$key]) && $this->data[$key] == $opt_child['value']) {
                                                    echo " selected=\"selected\"";
                                                }
                                                ?>
                                            >
                                            <?php echo $opt_child['text'];?>
                                            </option>
                                            <?php
                                            }
                                        }
                                        ?>
                                        </optgroup>
                                        <?php
                                    }
                                    ?>
                                </select>
                            <?php
                        } elseif (!empty($input['type']) && $input['type'] == 'select_multiple') {
                        ?>
                        <select
                            class='form-control js-example-basic-multiple'
                            name="<?php echo $key;?>[]"
                            multiple='multiple'
                        >
                            <?php
                            foreach ($input['options'] as $opt_key => $opt_value) {
                            ?>
                                <option
                                    value="<?php echo $opt_key;?>"
                                    <?php
                                    if (!empty($this->data[$key]) && in_array($opt_key, $this->data[$key])) {
                                        echo " selected=\"selected\"";
                                    } elseif (!empty($input['selected']) && $input['selected'] == $opt_key) {
                                        echo " selected=\"selected\"";
                                    } elseif (!empty($input['value']) && in_array($opt_key, $input['value'])) {
                                        echo " selected=\"selected\"";
                                    }

                                    ?>
                                >
                                    <?php echo $opt_value;?>
                                </option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php
                    } elseif (!empty($input['type']) && $input['type'] == 'select_input') {
                        ?>
                            <select
                                class='form-control <?php
                                    if (!empty($input['class'])) {
                                        echo $input['class'];
                                    }

                                    if (!empty($form_class)) {
                                        echo $form_class;
                                    }

                                ?>'
                                <?php
                                if (!empty($input['onchange'])) {
                                    echo 'onChange="'.$input['onchange'].'"';
                                }
                                ?>
                                data-attribute="<?php echo $key;?>[]"
                                id='<?php
                                    if (!empty($input['id'])) {
                                        echo $input['id'];
                                    } else {
                                        echo $key;
                                    }
                                ?>'
                                name="<?php echo $key;?>"
                            >
                                <option value=''>Select Value</option>
                                <?php
                                foreach($input['options'] as $opt_key => $opt_value) {
                                ?>
                                    <option
                                        value="<?php echo $opt_key;?>"
                                        <?php
                                        if(!empty($this->data[$key]) && $this->data[$key] == $opt_key) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>
                                    >
                                        <?php echo $opt_value;?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                        } elseif (!empty($input['type']) && $input['type'] == 'select') {
                            ?>
                            <select
                                <?php
                                if (isset($input['disabled']) && $input['disabled'] == true) {
                                    echo 'disabled';
                                }

                                if (isset($input['readonly']) && $input['readonly'] == true) {
                                    echo 'readonly';
                                }
                                ?>
                                class='form-control <?php
                                    if (!empty($input['class'])) {
                                        echo $input['class'];
                                    }

                                    if (!empty($form_class)) {
                                        echo $form_class;
                                    }

                                ?>'
                                name="<?php echo $key;?>"
                                id='<?php
                                    if (!empty($input['id'])) {
                                        echo $input['id'];
                                    } else {
                                        echo $key;
                                    }
                                ?>'

                                <?php
                                    if (!empty($input['data-attr-base-url'])) {
                                        echo ' data-attr-base-url="'.$input['data-attr-base-url'].' "';
                                    }
                                    if (!empty($input['required'])) {
                                        echo "required";
                                    }
                                ?>
                            >
                                <option value='<?php echo @$input['default'];?>'>Select Value</option>
                                <?php
                                foreach($input['options'] as $opt_key => $opt_value) {
                                ?>
                                    <option
                                        <?php
                                        if (!empty($input['default'])) {
                                            if ($opt_key == $input['default'] && empty($this->data[$key])) {
                                                echo "selected";
                                            }
                                        }
                                        ?>
                                        value="<?php echo $opt_key;?>"
                                        <?php

                                        if (isset($this->data[$key]) && $this->data[$key] == $opt_key) {
                                            echo " selected=\"selected\"";
                                        } elseif (!empty($input['selected']) && $input['selected'] == $opt_key) {
                                            echo " selected=\"selected\"";
                                        } elseif (isset($input['value']) && $input['value'] == $opt_key) {
                                            echo " selected=\"selected\"";
                                        }
                                        ?>
                                    ><?php echo $opt_value;?></option>
                                <?php
                                }
                                ?>
                            </select>
                            <?php
                            } elseif (!empty($input['type']) && $input['type'] == 'textarea') {
                                $textarea_value = !empty($this->data[$key]) ? $this->data[$key] : '';
                                if (!$textarea_value && !empty($input['value'])) {
                                    $textarea_value = $input['value'];
                                }
                                if (!isset($input['rows'])) {
                                    $input['rows'] = 3;
                                }

                                $class = "form-control";
                                if (!empty($form_class)) {
                                    $class .= " ".$form_class;
                                }

                                if (!empty($input['class'])) {
                                    $class .= " ".$input['class'];
                                }

                                $textarea_values = [
                                    'value' => $textarea_value,
                                    'rows' => $input['rows'],
                                    'class' => $class,
                        			'name' => $key
                                ];

                                if (!empty($input['readonly'])) {
                                    $textarea_values['readonly'] = true;
                                }
                                if (!empty($input['disabled'])) {
                                    $textarea_values['disabled'] = true;
                                }
                                if (isset($input['html_required'])) {
                                    $textarea_values['required'] = isset($input['html_required']);
                                }

                                if (isset($input['style'])) {
                                    $textarea_values['style'] = isset($input['style']);
                                }

                                if (!empty($input['id'])) {
                                    $textarea_values['id'] = $input['id'];
                                }

                                echo form_textarea($textarea_values);

                            } elseif (!empty($input['type']) && $input['type'] == 'radio') {
                                if (!empty($this->data[$key]) && $this->data[$key] ==1 ) {
                                    $checked = 'checked';
                                } else {
                                    $checked = '';
                                }
                                ?>
                                <input
                                    type='hidden'
                                    name='<?php echo $key;?>'
                                    value='0'
                                    checked
                                >
                                <input
                                type='checkbox'
                                name='<?php echo $key;?>'
                                value='1'
                                id='<?php
                                    if (!empty($input['id'])) {
                                        echo $input['id'];
                                    } else {
                                        echo $key;
                                    }
                                ?>'
                                <?php echo $checked; ?>>
                                <?php
                            } elseif (!empty($input['type']) && $input['type'] == 'file') {
                                ?>
                                <input
                                    <?php
                                        if (!empty($input['readonly'])) {
                                            echo 'readonly';
                                        }
                                    ?>
                                    <?php
                                        if (!empty($input['disabled'])) {
                                            echo 'disabled';
                                        }
                                    ?>
                                    name="<?php echo $key;?>"
                                    id="<?php
                                        if (isset($input['id'])) {
                                            echo $input['id'];
                                        } else {
                                            echo $key;
                                        }
                                    ?>"

                                    data-attr-<?php echo $key;?>="<?php
                                        if (isset($input['data-attr-'. $key])) {
                                            echo $input['data-attr-'. $key];
                                        }
                                    ?>"

                                    type='file'
                                    value="<?php
                                        if (isset($this->data[$key])) {
                                            echo $this->data[$key];
                                        } elseif (isset($input['value'])) {
                                            echo $input['value'];
                                        }
                                    ?>"
                                    <?php
                                    if (isset($input['html_required'])) {
                                        echo ' required ';
                                    }
                                    ?>

                                    class="form-control <?php if (isset($input['class'])) { echo $input['class']; }?> <?php if (!empty($form_class)) {
                                        echo $form_class;
                                    }?>"
                                >

                                <?php
                            } else {
                            ?>
                                <input
                                    <?php
                                        if (!empty($input['readonly'])) {
                                            echo 'readonly';
                                        }
                                    ?>
                                    <?php
                                        if (!empty($input['disabled'])) {
                                            echo 'disabled';
                                        }
                                    ?>
                                    name="<?php echo $key;?>"
                                    id="<?php
                                        if (isset($input['id'])) {
                                            echo $input['id'];
                                        } else {
                                            echo $key;
                                        }
                                    ?>"

                                    data-attr-<?php echo $key;?>="<?php
                                        if (isset($input['data-attr-'. $key])) {
                                            echo $input['data-attr-'. $key];
                                        }
                                    ?>"

                                    <?php
                                    if (isset($input['type'])) {
                                    ?>
                                    type="<?php echo $input['type']; ?>"
                                    <?php
                                        if ($input['type'] == 'number') {
                                            echo "min=\"0\"";
                                            echo "step=\"0.01\"";
                                        }
                                        if (isset($input['multiple'])) {
                                            echo ' multiple ';
                                        }
                                    } else {
                                    ?>
                                    type='text'
                                    <?php
                                    }
                                    ?>
                                    value="<?php
                                        if (isset($this->data[$key])) {
                                            echo $this->data[$key];
                                        } elseif (isset($input['value'])) {
                                            echo $input['value'];
                                        }
                                    ?>"
                                    <?php
                                    if (isset($input['html_required'])) {
                                        echo ' required ';
                                    }
                                    ?>

                                    class="form-control <?php if (isset($input['class'])) { echo $input['class']; }?> <?php if (!empty($form_class)) {
                                        echo $form_class;
                                    }?>"
                                >
                            <?php
                            }
                        }
                        ?>
                        <div class='formError'><font size="2" color="red"><?php echo form_error($key);?></font></div>
                    </div>
                </div>
            </div>
            <?php
            if ($i % 2 == 0 || (!empty($input['col'])))
            {
                if (!empty($input['col'])) {
                    $i--;
                }
            ?>
        </div>
        <div class='row'>
            <?php
                }
            $i++;
            }
            ?>
        </div>
    </div>
</div>
