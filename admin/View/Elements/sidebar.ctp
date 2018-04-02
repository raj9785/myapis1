<div class="sidebar app-aside" id="sidebar">
    <div class="sidebar-container perfect-scrollbar">
        <nav>
            <ul class="main-navigation-menu">

                <?php if (!isset($permissions) || (isset($permissions) && ((isset($permissions['checkdashboard4']) && $permissions['checkdashboard4'] == 1) || (isset($permissions['checkdashboard1']) && $permissions['checkdashboard1'] == 1) || isset($permissions['dcustomer_invoices']) && $permissions['dcustomer_invoices'] == 1) || (isset($permissions['ddaily_booking_trend']) && $permissions['ddaily_booking_trend'] == 1) || (isset($permissions['dcity_wise_bookings']) && $permissions['dcity_wise_bookings'] == 1) || (isset($permissions['dbooking_types']) && $permissions['dbooking_types'] == 1) || (isset($permissions['dbooking_types']) && $permissions['dbooking_status'] == 1) || (isset($permissions['dtrip_feedback']) && $permissions['dtrip_feedback'] == 1) || (isset($permissions['duser_pattern']) && $permissions['duser_pattern'] == 1) || (isset($permissions['dpanic_button']) && $permissions['dpanic_button'] == 1) || (isset($permissions['dcity']) && $permissions['dcity'] == 1) || (isset($permissions['dvendors']) && $permissions['dvendors'] == 1) || (isset($permissions['dvehicles']) && $permissions['dvehicles'] == 1) || (isset($permissions['ddrivers']) && $permissions['ddrivers'] == 1) || (isset($permissions['dcustomer_invoices']) && $permissions['dcustomer_invoices'] == 1) || (isset($permissions['dcustomer_receipts']) && $permissions['dcustomer_receipts'] == 1) || (isset($permissions['dcustomer_refunds']) && $permissions['dcustomer_refunds'] == 1) || (isset($permissions['dvendor_receipts']) && $permissions['dvendor_receipts'] == 1) )) { ?>



                <li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'dashboard') ? 'active open' : '' ?>">
                    <a href="<?php echo $this->Html->url(array('plugin' => false, 'controller' => 'users', 'action' => 'dashboard')); ?>">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-home"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title"> Dashboard </span>
                            </div>
                        </div>
                    </a>
                </li>       


                <?php } ?>


                <li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'applications') ? 'active open' : '' ?>">
                    <a href="<?php echo $this->Html->url(array('plugin' => 'application', 'controller' => 'applications', 'action' => 'add')); ?>">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-settings"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title">My App </span>
                            </div>
                        </div>
                    </a>

                </li>
                
                <li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'tables') ? 'active open' : '' ?>">
                    <a href="<?php echo $this->Html->url(array('plugin' => 'application', 'controller' => 'applications', 'action' => 'add_table')); ?>">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-settings"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title">Add Tables </span>
                            </div>
                        </div>
                    </a>

                </li>
                
                <li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'menus') ? 'active open' : '' ?>">
                    <a href="<?php echo $this->Html->url(array('plugin' => 'application', 'controller' => 'applications', 'action' => 'menus')); ?>">
                        <div class="item-content">
                            <div class="item-media">
                                <i class="ti-settings"></i>
                            </div>
                            <div class="item-inner">
                                <span class="title">Menus </span>
                            </div>
                        </div>
                    </a>

                </li>










<!--               <li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'followers') ? 'active open' : '' ?>">
    <a href="<?php echo $this->Html->url(array('plugin' => 'influencer', 'controller' => 'influencers', 'action' => 'index')); ?>">
        <div class="item-content">
            <div class="item-media">
                <i class="ti-settings"></i>
            </div>
            <div class="item-inner">
                <span class="title">Import </span>
            </div>
        </div>
    </a>

</li>


<li class="slide_class <?php echo (isset($tab_open) && $tab_open == 'influencer_list') ? 'active open' : '' ?>">
    <a href="<?php echo $this->Html->url(array('plugin' => 'influencer', 'controller' => 'influencers', 'action' => 'influencer_list')); ?>">
        <div class="item-content">
            <div class="item-media">
                <i class="ti-settings"></i>
            </div>
            <div class="item-inner">
                <span class="title">Influencers </span>
            </div>
        </div>
    </a>

</li>-->








            </ul>
        </nav>
    </div>
</div>
<script type='text/javascript'>
    $(document).ready(function() {
        $(".heading_left").on("dblclick", function() {
            $(this).removeClass('open');
            var idthis = $(this).attr("id");
            // alert(idthis);
            var href = $("." + idthis + "_1").attr('href');
            //alert(href);
            window.location = href;
        });
    });

</script>