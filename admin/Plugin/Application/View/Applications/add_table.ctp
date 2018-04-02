<?php

echo $this->Html->css(array('validationEngine.jquery'));
echo $this->Html->script(array('jquery.validationEngine-en', 'jquery.validationEngine'));
?>
<script type="text/javascript">
    jQuery(document).ready(function () {
        //jQuery("#ApplicationAddForm").validationEngine();
        $(".add-row").on("click", function () {
            make_clone();
        });
//        $(".fields_table").on("change", function () {
//            var options = '';
//            $(".fields_table").each(function () {
//                var name_value = $(this).val();
//                options += "<option value='" + name_value + "'>" + name_value + "</option>";
//            });
//            $("#primary_key").empty().html(options);
//
//        });
        $("#foreign_key_ref_table").on("change",function(){
            $("#submit").attr('disabled', 'disabled');
            $("#table_field").attr('disabled', 'disabled');
            $("#table_field").empty();
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->Html->url(array('plugin' => 'application', 'controller' => 'applications', 'action' => 'get_field_list')) ?>',
                data: 'table_name=' + $(this).val(),
                success: function(data) {
                    $("#submit").removeAttr('disabled');
                    $("#table_field").removeAttr('disabled');
                    $("#table_field").html(data);
                }
            });
        });
    });
    cloneIndex = 2;

    function make_clone() {
        var clone_div = $(".row_fields").children().clone();
        clone_div.appendTo(".row_new").on("change", function () {
            var options = "<option value=''>Select</option>";
            $(".fields_table").each(function () {
                var name_value = $(this).val();
                options += "<option value='" + name_value + "'>" + name_value + "</option>";
            });
            $("#primary_key").empty().html(options);
            $("#foreign_key").empty().html(options);
        });
        cloneIndex++;
    }

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
                    <?php 
                    if($application_id){
                    ?>
                    <div class="row">
                        <div class="col-md-12">   

                             <?php echo $this->Form->create($model, array('url' => array('plugin' => 'application', 'controller' => 'applications', 'action' => 'add_table'), 'enctype' => 'multipart/form-data')); ?>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Table Name <span class="symbol required"></span></label>
                                        <?php echo $this->Form->input($model . '.table_name', array('type' => 'text', 'maxlength' => '75', 'class' => 'form-control ', 'div' => false, 'label' => false, 'required' => true)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row_fields">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Field Name <span class="symbol required"></span></label>
                                        <?php echo $this->Form->input($model . '.name.', array('type' => 'text', 'maxlength' => '75', 'class' => 'form-control fields_table', 'div' => false, 'label' => false)); ?>
                                            <span id="email-error" class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Type <span class="symbol required"></span></label>
                                        <?php 
                                         echo $this->Form->input($model . '.field_data_type.', array('type' => 'select', 'empty' => 'Select','options' => $data_types, 'class' => 'form-control  validate[required]', 'id' => 'application_type_id', 'div' => false, 'label' => false)); ?>
                                            <span id="email-error" class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Length <span class="symbol required"></span></label>
                                       <?php echo $this->Form->input($model . '.data_length.', array('type' => 'text', 'class' => 'form-control', 'div' => false, 'label' => false)); ?>
                                            <span id="email-error" class="help-block"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row_new">

                            </div>

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-sm-4 text-align-right">						
                                    <a href="javascript:void(0)" class="btn btn-green add-row"><i class="fa fa-plus"> Add More Fields</i></a> 
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Mark Primary Key </label>
                                        <?php 
                                         echo $this->Form->input($model . '.primary_key', array('type' => 'select', 'empty' => 'Select','options' => array(), 'class' => 'form-control', 'id' => 'primary_key', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>

                                <div class="col-md-4">



                                    <div class="form-group <?php echo ($this->Form->error('db_option')) ? 'error' : ''; ?>">
                                <?php
                                echo $this->Form->label($model . '.auto_incremented', __("Auto increment id?", true) . ' :');
                                ?>
                                        <div class="input featuresdetailsfontsize<?php echo ($this->Form->error('backend_server')) ? 'error' : ''; ?>">
                                    <?php
                                    $options=array(
                                            1=>"Yes",
                                            2=>'No',
                                        );
                                    echo $this->Form->input($model . '.auto_incremented', array(
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Mark Foreign Key </label>
                                        <?php 
                                         echo $this->Form->input($model . '.foreign_key', array('type' => 'select', 'empty' => 'Select','options' => array(), 'class' => 'form-control  validate[required]', 'id' => 'foreign_key', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Table</label>
                                        <?php 
                                         echo $this->Form->input($model . '.foreign_key_ref_table', array('type' => 'select', 'empty' => 'Select','options' => $tableNames, 'class' => 'form-control', 'id' => 'foreign_key_ref_table', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Field</label>
                                        <?php 
                                         echo $this->Form->input($model . '.table_field', array('type' => 'select', 'empty' => 'Select','options' => array(), 'class' => 'form-control', 'id' => 'table_field', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
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
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    <?php echo $this->Form->button('Save', array('class' => 'btn btn-primary btn-wide pull-right', 'type' => 'submit', 'id' => 'submit')) ?>
                                    <?php //echo $this->Form->button('Cancel', array('class' => 'btn btn-primary btn-wide pull-right', 'type' => 'button', 'id' => 'cancel_button')) ?>
                                </div>
                            </div>
                            <?php echo $this->Form->end(); ?>
                        </div>
                    </div>
                    
                    <?php }else{
                        ?>
                    
                     <?php
                    } ?>
                </div>
                <!-- end: FORM VALIDATION EXAMPLE 1 -->
            </div>
        </div>
    </div>
    <!-- start: FOOTER -->
    <?php echo $this->element('footer'); ?>
    <!-- end: FOOTER -->
</div>

