<?php $this->start('body')?>
<div class="dashboard-content">
  <div class="col-sm-12">
    <?php $this->page('admin/dashboard','welcome-div'); ?>
    <?php $this->page('admin/dashboard','report-div'); ?>
    <?php $this->page('admin/dashboard','chart-div'); ?>
    <?php $this->page('admin/dashboard','button-div'); ?>
    <?php $this->page('admin/dashboard','offer-div'); ?>
  </div>
</div>

<?php $this->end()?>
