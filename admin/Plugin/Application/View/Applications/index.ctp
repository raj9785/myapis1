
<?php echo $this->Html->css(array('sweet-alert.css', 'ie9.css', 'toastr.min.css', 'DT_bootstrap.css', 'jquery.fancybox.css'), null, array('inline' => false)); ?>
<?php echo $this->Html->script(array('jquery.dataTables.min.js', 'sweet-alert.min.js', 'ui-notifications.js', 'jquery.fancybox.js'), array('inline' => false)); ?>
<script type='text/javascript'>
    $(function() {



    })

    function status_change(id, status) {


        swal({
            title: "Are you sure?",
            text: "Status will be changed.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            closeOnConfirm: false,
        },
                function() {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->Html->url(array('plugin' => 'application', 'controller' => 'applications', 'action' => 'change_status')); ?>',
                        data: {
                            'id': id,
                            'status': status,
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.succ == 1) {
                                swal({
                                    title: "Changed!",
                                    text: data.msg,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonColor: '#d6e9c6',
                                    confirmButtonText: 'OK',
                                    closeOnConfirm: false,
                                }, function() {
                                    window.location.reload();
                                });
                            } else {
                                swal({
                                    title: "Error!",
                                    text: data.msg,
                                    type: "error",
                                    showCancelButton: false,
                                    confirmButtonColor: '#d6e9c6',
                                    confirmButtonText: 'OK',
                                    closeOnConfirm: false,
                                }, function() {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                });

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
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle"><?php  echo $title_for_layout;?></h1>
                        </div>
                        <div class="col-sm-4 text-align-right">						
                            <?php echo $this->Html->link('<i class="fa fa-plus"></i> ' . __('Add New App', true) . "", array('plugin' => "application", 'controller' => 'applications', "action" => "add"), array("class" => "btn btn-green add-row", "escape" => false)); ?>
                        </div>
                    </div>
                </section>
                <?php echo $this->Session->flash(); ?>
                <div class="container-fluid container-fullw bg-white">

                    <!--<div class="row">
                        <div class="col-md-12 space20">
                            <div class="pull-left1 driver_index1">

                    <?php
                    echo $this->Form->create($model, array('class' => 'form-inline', 'inputDefaults' => array('label' => false, 'div' => false)));
                    echo $this->Form->text('name', array('placeholder' => __('Search By Name', true), 'class' => 'form-control input-medium'));
                    ?>
                                &nbsp;&nbsp;<?php echo $this->Form->button("<i class='icon-search icon-white'></i> " . __("Search", true), array('class' => 'btn btn-primary', 'escape' => false)); ?>
                    <?php echo $this->Form->end(); ?>
                            </div>
                        </div>
                    </div>-->
                    <div class="clear"></div>
                    <table class="table table-striped table-bordered  table-full-width">
                        <thead>
                            <tr style="height:30px;">
                                <th class="hidden-xs" width="5%">S.No.</th>
                                <th class="hidden-xs">Name</th>
                                <th class="hidden-xs">Code</th>
                                <th class="hidden-xs">Created On</th>
                                <th class="hidden-xs">Modified On</th>
                                <th class="hidden-xs">Created By</th>
                                <th class="hidden-xs">Modified By</th>

                                <th class="hidden-xs"><?php echo __('Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($result)) {

                                $i=1;


                                foreach ($result as $records) {
                                    //pr($records);
                                    ?>
                            <tr style="height:30px;" class="gallerytr">
                                <td><?php echo $i; ?></td>
                                <td>
                                            <?php echo $records[$model]['name']; ?>
                                </td>
                                <td>
                                            <?php echo $records[$model]['application_code']; ?>
                                </td>
                                <td>
                                            <?php echo $records[$model]['created_on']?date(DATETIME_FORMAT, strtotime($records[$model]['created_on'])):""; ?>
                                </td>
                                <td>
                                            <?php echo $records[$model]['modified_on']? date(DATETIME_FORMAT, strtotime($records[$model]['modified_on'])):""; ?>
                                </td>


                                <td>
                                            <?php echo @$records['Created']['firstname']?$records['Created']['firstname']." ".$records['Created']['lastname']:""; ?>
                                </td>

                                <td>
                                            <?php echo @$records['Modified']['firstname']?$records['Modified']['firstname']." ".$records['Modified']['lastname']:""; ?>
                                </td>






                                <td>
                                            <?php /* ?> <a href='javascript:void(0)' id='operate_city_<?php echo $records[$model]['id']; ?>' class='' title="City list in which vehicle is active.">Operation Cities</a> &nbsp;&nbsp;
                                              <?php */ ?>

                                    <div class="dropdown" style='float:left'>
                                        <a class="btn btn-info dropdown-toggle" id="dLabel" role="button"
                                           data-toggle="dropdown" data-target="#" href="javascript:void(0)"
                                           style='text-decoration:none'>
                                                    <?php echo __('Action'); ?> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                            <li> <?php
                                                        echo $this->Html->link(__('Edit', true), array('plugin' => 'application', 'controller' => 'applications', 'action' => 'edit', $records[$model]['id']), array('class' => '', 'escape' => false));
                                                        ?>
                                            </li>

                                        </ul>
                                    </div>


                                </td>
                            </tr>
                                    <?php
                                    $i++;
                                }
                                ?>

                            <tr>
                                <td colspan="20"><?php echo $this->element('pagination'); ?></td>
                            </tr>
                                <?php
                            } else {
                                ?>
                            <tr>
                                <td align="center" style="text-align:center;" colspan="6" class=""><?php echo __('No Result Found'); ?></td>
                            </tr>

                            <?php } ?>        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- start: FOOTER -->
    <?php echo $this->element('footer'); ?>
</div>

<script>

    var checkboxes = $("input[type='checkbox']"),
            submitButt = $("input[type='submit']");

    checkboxes.click(function() {
        submitButt.attr("disabled", !checkboxes.is(":checked"));
    });
    $('#selectall').click(function() {
        submitButt.attr("disabled", !checkboxes.is(":checked"));
    });
    // add multiple select / deselect functionality
    $("#selectall").click(function() {

        $('.case').attr('checked', this.checked);
        if ($(".case:checked").length == 0)
        {
            $('input[type="submit"]').attr('disabled', 'disabled');
        }
        ;

    });


    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function() {

        if ($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }

    });

</script>
<style type="text/css">
    .fancybox-overlay.fancybox-overlay-fixed{
        display: none !important;
    }
</style>
