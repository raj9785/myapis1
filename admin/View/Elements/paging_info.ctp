<?php
$paginator = $this->Paginator;
$default = Configure::read('defaultPaginationLimit');
if (!isset($limitValue)) {
    $limitValue = Configure::read('defaultPaginationLimit');
}
if (isset($limit) && $limit != "") {
    $limitValue = $limit;
} else {
    $limitValue = Configure::read('defaultPaginationLimit');
}
$pagingViews = Configure::read('pagingViews');

//pr($pagingViews); exit;
?>
<div class="col-sm-6">
<form method="post" class="form-horizontal">
    <div class="pull-left1 grytxt12 pr10 pt5 paginginfo " style="padding-top: 5px;"><?php echo $paginator->counter(array('format' => 'Page %page% of&nbsp;&nbsp;%pages%, Total records %count% | ')); ?>Views&nbsp;&nbsp;</div>
    <div class="pull-left1">
        <select onchange="this.form.submit();" name="data[recordsPerPage]" style="width:85px;"  class="lstfld60">
            <option value="<?php echo $default; ?>">Default</option>
            <?php foreach ($pagingViews as $views) { ?>
                <option <?php echo (($limit == $views) ? 'selected="selected"' : ''); ?> value="<?php echo $views; ?>"><?php echo $views; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="clr"></div>
</form>
</div>