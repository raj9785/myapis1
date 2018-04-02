<?php

echo $this->Html->css(array('validationEngine.jquery'));
echo $this->Html->script(array('jquery.validationEngine-en', 'jquery.validationEngine'));
?>
<script type="text/javascript">
    jQuery(document).ready(function () {

        $("#check_all").on("click", function () {
            $("input[id^=city_id_]").each(function () {
                $("#" + $(this).attr('id')).prop('checked', 'checked');
            });
        });

        $("#uncheck_all").on("click", function () {
            $("input[id^=city_id_]").each(function () {
                $("#" + $(this).attr('id')).removeAttr('checked');
            });
        });

        jQuery("#ApplicationAddForm").validationEngine();
        $("#application_type_id").on("change", function () {
            if ($(this).val() == 'OTHER') {
                $(".app_tp_name").show();
            } else {
                $(".app_tp_name").hide();
            }
        });

    });

</script>

<div id="app">
    <!-- sidebar -->
    <?php echo $this->element('sidebar'); ?>
    <!-- / sidebar -->
    <div class="app-content">
        <!-- start: TOP NAVBAR -->
        <?php echo $this->element('header'); ?>
        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                <!-- start: PAGE TITLE -->
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle"><?php echo $title_for_layout; ?></h1>                            
                        </div>                        
                    </div>
                </section>
                <!-- end: PAGE TITLE -->
                <!-- Global Messages -->
                <?php echo $this->Flash->render(); ?>
                <!-- Global Messages End -->
                <!-- start: FORM VALIDATION EXAMPLE 1 -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">   

                             <?php echo $this->Form->create($model, array('url' => array('plugin' => 'application', 'controller' => 'applications', 'action' => 'add'), 'enctype' => 'multipart/form-data')); 
                             echo $this->Form->hidden('id');
                             
                             ?>


                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">What the App Name or project name <span class="symbol required"></span></label>
                                        <?php echo $this->Form->input($model . '.name', array('type' => 'text', 'maxlength' => '75', 'class' => 'form-control confirmpassword', 'div' => false, 'label' => false, 'required' => true)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label" style="margin-bottom: 16px;">App Logo (if any) <span class="symbol required"></span></label> 
				     <?php  echo $this->Form->input($model . '.image', array('type' => 'file','label' => false,'div' => false,'id'=>'image')); ?>

                                        <span id="image-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                 <?php
                                            $file_name = $app_data['Application']['image'];
                                            if (is_file(WBROOT_PATH_LOGO . $file_name)) {
                                                ?>
                                    <img src="<?php echo HTTP_PATH_LOGO .$file_name; ?>" width="75px"  class="img-rounded" />
                                                <?php
                                            }
                                            ?>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mult_chk types" id="type_1">
                                        <label class="control-label">Choose UI's (Choose Multiple) <span class="symbol required"></span>
                                            <?php
                                            //echo '&nbsp;&nbsp;' . $this->Html->link('Check All', 'javascript:void(0)', array('escape' => false, 'id' => 'check_all_f'));
                                            //echo '&nbsp;&nbsp;' . $this->Html->link('Uncheck All', 'javascript:void(0)', array('escape' => false, 'id' => 'uncheck_all_f'));
                                            ?>
                                        </label>
                                        <?php 
                                        $options1=array(
                                            1=>"Android",
                                        );
                                        $options2=array(
                                         1=>'IOS',
                                        );
                                        $options3=array(
                                            1=>"Web"
                                        );
                                        
                                        echo $this->Form->input($model . '.android', array('type' => 'select', 'div' => false, 'multiple' => 'checkbox', 'options' => $options1, 'class' => '', 'id' => 'ui_types', 'label' => false, 'tabindex' => 4, 'required' => true)); 
                                        echo $this->Form->input($model . '.ios', array('type' => 'select', 'div' => false, 'multiple' => 'checkbox', 'options' => $options2, 'class' => '', 'id' => 'ui_types', 'label' => false, 'tabindex' => 4, 'required' => true));
                                        echo $this->Form->input($model . '.web', array('type' => 'select', 'div' => false, 'multiple' => 'checkbox', 'options' => $options3, 'class' => '', 'id' => 'ui_types', 'label' => false, 'tabindex' => 4, 'required' => true));
                                        
                                        
                                        ?>
                                        <span id="type1-error" class="help-block"></span>
                                    </div>
                                </div>  
                            </div>


                            <div class="row">

                                <div class="col-md-5">



                                    <div class="form-group <?php echo ($this->Form->error('db_option')) ? 'error' : ''; ?>">
                                <?php
                                echo $this->Form->label($model . '.backend_server', __("Choose API's Backend Server (One option)", true) . ' :<span class="symbol required"></span>', array('style' => ""));
                                ?>
                                        <div class="input featuresdetailsfontsize<?php echo ($this->Form->error('backend_server')) ? 'error' : ''; ?>" style="" >
                                    <?php
                                    $options=array(
                                            1=>"Common hosting as per our hosting",
                                            2=>'On your own instance',
                                        );
                                    echo $this->Form->input($model . '.backend_server', array(
                                        'div' => false,
                                        'label' => false,
                                        "separator" => "&nbsp &nbsp &nbsp",
                                        'type' => 'radio',
                                        'legend' => false,
                                        'options' => $options,
                                        "class" => " ac"
                                    ));
                                    ?>

                                        </div>
                                    </div>

                                </div>





                                <div class="col-md-5">
                                    <div class="form-group <?php echo ($this->Form->error('db_option')) ? 'error' : ''; ?>">
                                <?php
                                echo $this->Form->label($model . '.db_option', __('Choose DB Option (One option)', true) . ' :<span class="symbol required"></span>', array('style' => ""));
                                ?>
                                        <div class="input featuresdetailsfontsize<?php echo ($this->Form->error('db_option')) ? 'error' : ''; ?>" style="" >
                                    <?php
                                    $options=array(
                                            1=>"Shared on same DB",
                                            2=>'Seperate DB/Schema',
                                        );
                                    echo $this->Form->input($model . '.db_option', array(
                                        'div' => false,
                                        'label' => false,
                                        "separator" => "&nbsp &nbsp &nbsp",
                                        'type' => 'radio',
                                        'legend' => false,
                                        'options' => $options,
                                        "class" => " ac"
                                    ));
                                    ?>

                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-5">						
                                    <div class="form-group <?php echo ($this->Form->error('type_of_end_user')) ? 'error' : ''; ?>">
                                <?php
                                echo $this->Form->label($model . '.type_of_end_user', __('Type of End User / Customer (One option)', true) . ' :<span class="symbol required"></span>', array('style' => ""));
                                ?>
                                        <div class="input featuresdetailsfontsize<?php echo ($this->Form->error('ac')) ? 'error' : ''; ?>" style="" >
                                    <?php
                                    $options=array(
                                            1=>"B2B",
                                            2=>'B2C',
                                        );
                                    echo $this->Form->input($model . '.type_of_end_user', array(
                                        'div' => false,
                                        'label' => false,
                                        "separator" => "&nbsp &nbsp &nbsp",
                                        'type' => 'radio',
                                        'legend' => false,
                                        'options' => $options,
                                        "class" => " ac"
                                    ));
                                    ?>

                                        </div>
                                    </div>
                                </div>



                            </div>




                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Please suggest domain (One Option) <span class="symbol required"></span></label>
                                        <?php 
                                        
                                        //pr($application_type_list);
                                        $ApplicationTypes['OTHER']="Any Other";
                                        echo $this->Form->input($model . '.application_type_id', array('type' => 'select', 'empty' => 'Select','options' => $ApplicationTypes, 'class' => 'form-control  validate[required]', 'id' => 'application_type_id', 'div' => false, 'label' => false, 'required' => true)); ?>

                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div> 
                                <div class="col-md-5 app_tp_name" style="display:none;">
                                    <div class="form-group">
                                        <label class="control-label">If other please enter domain name here </label>
                                        <?php echo $this->Form->input($model . '.application_type_name', array('type' => 'text', 'maxlength' => '75', 'class' => 'form-control confirmpassword', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div> 
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mult_chk types" id="type_1">
                                        <label class="control-label">User types of login (choose multiple) <span class="symbol required"></span>
                                            <?php
                                            //echo '&nbsp;&nbsp;' . $this->Html->link('Check All', 'javascript:void(0)', array('escape' => false, 'id' => 'check_all_f'));
                                            //echo '&nbsp;&nbsp;' . $this->Html->link('Uncheck All', 'javascript:void(0)', array('escape' => false, 'id' => 'uncheck_all_f'));
                                            ?>
                                        </label>
                                        <?php 
                                        $options = array(
                                           4=>"Admin",
                                           5=>"Customer",
                                           6=>"Employee",
                                        );
                                        
                                       //pr($app_data);
                                        $selected=array();
                                        if(!empty($app_data)){
                                            $lg_types=$app_data['ApplicationRole'];
                                            foreach($lg_types as $rdata){
                                                $selected[]=$rdata['user_role_id'];
                                            }
                                        }
                                        
                                        
                                        echo $this->Form->input($model . '.login_types', array('type' => 'select', 'div' => false, 'multiple' => 'checkbox', 'options' => $options, 'selected' => $selected,'class' => '', 'id' => 'ui_types', 'label' => false, 'tabindex' => 4, 'required' => true)); ?>
                                        <span id="type1-error" class="help-block"></span>
                                    </div>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <span class="symbol required"></span>Required Fields
                                        <hr>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">                                        
                                </div>
                                <div class="col-md-2">
                                    <?php echo $this->Form->button('Save', array('class' => 'btn btn-primary btn-wide pull-right', 'type' => 'submit', 'id' => 'submit')) ?>
                                    <?php //echo $this->Form->button('Cancel', array('class' => 'btn btn-primary btn-wide pull-right', 'type' => 'button', 'id' => 'cancel_button')) ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
                <!-- end: FORM VALIDATION EXAMPLE 1 -->
            </div>
        </div>
    </div>
    <!-- start: FOOTER -->
    <?php echo $this->element('footer'); ?>
    <!-- end: FOOTER -->
</div>

