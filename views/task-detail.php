<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 12/09/2017
 * Time: 17:12
 */
?>
<?php if($this->sts):?>
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Alert!</strong> Task <strong>#<?= $this->data['id']?></strong> save success!
</div>
<?php endif ?>
<div class="widget">

    <div class="widget-header"><i class="icon-tasks"></i>
        <h3> <a href="<?= $this->widgetUrl()?>">All Tasks</a><i class="icon-chevron-right"></i> <?= $this->data['name']?></h3>
        <?=$this->backButton()?>
    </div>

    <!-- /widget-header -->
    <div class="widget-content">
        <p><strong>Status:</strong>
            <?php if($this->data['status']): ?>
                <i class="btn-icon-only icon-ok"> </i>
            <?php else:?>
                <i class="btn-icon-only  icon-remove"> </i>
            <?php endif ?>
        </p>
        <p><strong>Name:</strong> <?= $this->data['name']?></p>
        <p><strong>Email:</strong> <?= $this->data['email']?></p>
        <p><strong>Task:</strong> <?= $this->data['tasks']?></p>

        <p><img src="<?= $this->widgetUrl().'media/'.$this->data['image']?>"></p>
    </div>
</div>