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

                             <?php echo $this->Form->create($model, array('url' => array('plugin' => 'application', 'controller' => 'applications', 'action' => 'menus'), 'enctype' => 'multipart/form-data')); ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                            <?php 
                              echo $this->Form->input($model . '.application_role_id', array('type' => 'select','options' => $category_list, 'class' => 'form-control is_home_page', 'div' => false, 'label' => false));
                            ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Name <span class="symbol required"></span></label>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Mark as landing Page</label>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Is Master</label>

                                    </div>
                                </div>
                            </div>
                            <?php 
                            if(!empty($menu_list)){
                                //pr($menu_list);
                                foreach($menu_list as $mData){
                                    ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">

                                        <?php echo $this->Form->input($model . '.menu_name.', array('type' => 'text','value'=>$mData['Menu']['menu_name'] ,'maxlength' => '75', 'class' => 'form-control fields_table', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">

                                        <?php 
                                         echo $this->Form->input($model . '.is_home_page.', array('type' => 'select','value'=>$mData['Menu']['is_home_page'],'options' => array("0"=>"NO",1=>"YES"), 'class' => 'form-control is_home_page', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">

                                        <?php 
                                         echo $this->Form->input($model . '.is_master.', array('type' => 'select','value'=>$mData['Menu']['is_master'],'options' => array("0"=>"NO",1=>"YES"), 'class' => 'form-control', 'div' => false, 'label' => false)); ?>
                                        <span id="email-error" class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                                    <?php
                                }
                            }
                            
                            ?>


                            <div class="row_fields">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">

                                        <?php echo $this->Form->input($model . '.menu_name.', array('type' => 'text', 'maxlength' => '75', 'class' => 'form-control fields_table', 'div' => false, 'label' => false)); ?>
                                            <span id="email-error" class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">

                                        <?php 
                                         echo $this->Form->input($model . '.is_home_page.', array('type' => 'select','options' => array("0"=>"NO",1=>"YES"), 'class' => 'form-control is_home_page', 'div' => false, 'label' => false)); ?>
                                            <span id="email-error" class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">

                                        <?php 
                                         echo $this->Form->input($model . '.is_master.', array('type' => 'select','options' => array("0"=>"NO",1=>"YES"), 'class' => 'form-control', 'div' => false, 'label' => false)); ?>
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
                                    <a href="javascript:void(0)" class="btn btn-green add-row"><i class="fa fa-plus"> Add more menu items</i></a> 
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

