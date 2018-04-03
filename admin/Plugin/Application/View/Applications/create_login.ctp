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
        $(".fields_table").on("change", function () {
            var options = '';
            $(".fields_table").each(function () {
                var name_value = $(this).val();
                options += "<option value='" + name_value + "'>" + name_value + "</option>";
            });
            $("#primary_key").empty().html(options);

        });
        
        $("#table_name").on("change",function(){
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
            var counter = 0;
            $(".is_home_page").each(function () {
                if ($(this).val() == 1) {
                    counter++;
                }
            });
            if (counter > 1) {
                $(".is_home_page").each(function () {
                    $(this).val('0');
                });
            }

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

                             <?php echo $this->Form->create($model, array('enctype' => 'multipart/form-data')); ?>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">User Type </label>
                            <?php 
                              echo $role_detail['UserRole']['name'];
                            ?>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Menu </label>
                                      <?php 
                                        echo $menu_detail['Menu']['menu_name'];
                                     ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-md-4">



                                    <div class="form-group <?php echo ($this->Form->error('db_option')) ? 'error' : ''; ?>">
                                <?php
                                echo $this->Form->label($model . '.login_id', __("Login ID", true) . ' :');
                                ?>
                                        <div class="input">
                                    <?php
                                    $options=array(
                                            'mobile'=>"Mobile No",
                                            'email'=>'Email ID',
                                            'mobile_or_email'=>'Mobile No or Email ID',
                                        );
                                    echo $this->Form->input($model . '.login_id', array(
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Table</label>
                                        <?php 
                                         echo $this->Form->input($model . '.table_name', array('type' => 'select', 'empty' => 'Select','options' => $tableNames, 'class' => 'form-control', 'id' => 'foreign_key_ref_table', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Field</label>
                                        <?php 
                                         echo $this->Form->input($model . '.table_field', array('type' => 'select', 'empty' => 'Select','options' => array(), 'class' => 'form-control', 'id' => 'table_field', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>    





                            <div class="row_new">

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
                                    <?php echo $this->Form->button('Next', array('class' => 'btn btn-primary btn-wide pull-right', 'type' => 'submit', 'id' => 'submit')) ?>
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

