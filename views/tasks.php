<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 17:52
 */

?>
<?php
echo $this->paginator->pageNumbers();
?>
<div class="widget widget-table action-table">

    <div class="widget-header"><i class="icon-tasks"></i>
        <h3>All Tasks</h3>
        <a href="<?=$this->widgetURL()?>?controller=tasks&action=new" class="btn btn-medium btn-invert icon-plus-sign" alt="Add new task" title="Add new task"></a>
    </div>

    <!-- /widget-header -->
    <div class="widget-content">

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th> Image</th>
                <th><?=$this->get_sort_link('name', 'Name')?></th>
                <th><?=$this->get_sort_link('email', 'Email')?></th>
                <th class="td-actions"><?=$this->get_sort_link('status', 'Status')?></th>
                <th>Tasks</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $i = ($this->paginator->currentPage > 1)? ($this->paginator->currentPage - 1) * $this->paginator->itemsPerPage+1:1;
            foreach($this->data as $row):
                    if(!$row['image']) $row['image'] = 'no-photo.jpg'; ?>
            <tr>
                <td><?=$i++?></td>
                <td class="span3"><img src="<?=$this->widgetURL().'media/'.$row['image']?>" width="100%" /></td>
                <td><?=$row['name']?></td>
                <td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
                <td class="td-actions">
                    <?php if($row['status']): ?>
                        <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a>
                    <?php else:?>
                        <a href="javascript:;" class="btn btn-invert btn-small"><i class="btn-icon-only  icon-remove"> </i></a>
                    <?php endif ?>
                </td>
                <td><?=$row['tasks']?></td>

            </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

            <?php
                echo $this->paginator->pageNumbers();
            ?>
    <!-- /widget-content -->
</div>


