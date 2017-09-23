<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 17:52
 */

?>
<?php
echo $this->paginator->display_pages();
?>

<script>

    function deleteform(url,title){
        bootbox.confirm({
            message: "Do you delete "+title+"?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                    window.location.href = url;
                }
                console.log('This was logged in the callback: ' + result);
            }
        });
    }
</script>
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
               <?php if($this->is_admin()): ?>
                   <th>Edit</th>
               <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = ($this->paginator->current_page > 1)? ($this->paginator->current_page - 1) * 4:1;
//           $i = 1;
            foreach($this->data as $row):
                    if(!$row['image']) $row['image'] = 'no-photo.jpg'; ?>
            <tr>
                <td><?=$i++?></td>
                <td class="span3"><a href="<?=$this->widgetURL().'?controller=tasks&action=detail&id='.$row['id']?>"><img src="<?=$this->widgetURL().'media/'.$row['image']?>" width="100%" ></a></td>
                <td><a href="<?=$this->widgetURL().'?controller=tasks&action=detail&id='.$row['id']?>"><?=$row['name']?></a></td>
                <td><a href="mailto:<?=$row['email']?>"><?=$row['email']?></a></td>
                <td class="td-actions">
                    <?php if($row['status']): ?>
                        <a href="javascript:;" class="btn btn-small btn-success"><i class="btn-icon-only icon-ok"> </i></a>
                    <?php else:?>
                        <a href="javascript:;" class="btn btn-invert btn-small"><i class="btn-icon-only  icon-remove"> </i></a>
                    <?php endif ?>
                </td>
                <td><?=$row['tasks']?></td>
                <?php if($this->is_admin()): ?>
                    <td>
                       <a href="<?=$this->widgetURL().'?controller=tasks&action=edit&id='.$row['id']?>" class="btn btn-info">
                          <i class="icon-edit"></i> Edit
                        </a>
                        <a href="javascript:void(0)" class="btn btn-danger" onclick="deleteform('<?=$this->widgetURL().'?controller=tasks&action=delete&id='.$row['id']?>','<?= $row['name'] ?>'); return false">
                            <i class="icon-remove"></i> Remove
                        </a>
                    </td>
                <?php endif ?>

            </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

            <?php
                 echo $this->paginator->display_pages();
            ?>
    <!-- /widget-content -->
</div>



