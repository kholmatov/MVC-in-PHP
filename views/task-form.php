<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:57
 */
?>
<?php if($this->sts):?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Alert!</strong> Task <strong>#<?= $this->data['id']?></strong> update success!
    </div>
<?php endif ?>

<div class="widget">

    <div class="widget-header"><i class="icon-tasks"></i>
        <h3> <a href="<?= $this->widgetUrl()?>">All Tasks</a><i class="icon-chevron-right"></i> <span id="title"><?= $this->title ?></span></h3>
        <?= $this->backButton() ?>
    </div>

    <!-- /widget-header -->
    <div class="widget-content">

        <div id="form-show">
            <form id="task-form" name="taskform" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= $this->action ?>">
            <fieldset>
                <?php if($this->is_admin()):?>
                    <div class="control-group">
                        <label class="control-label">Status:</label>
                        <div class="controls">
                            <label class="checkbox inline">
                                <input name="status" id="status" type="checkbox" <?php if($this->data['status']) echo"checked"?>>
                            </label>
                        </div>        <!-- /controls -->
                    </div> <!-- /control-group -->
                <?php endif ?>
                <div class="control-group">
                    <label class="control-label" for="name">Name:</label>
                    <div class="controls">
                        <input type="text" class="span4 request" name="name" id="name"  value="<?= $this->data['name'] ?>">
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->
                <div class="control-group">
                    <label class="control-label" for="email">Email Address:</label>
                    <div class="controls">
                        <input type="text" class="span4 request" id="email" name="email"  value="<?= $this->data['email'] ?>">
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->

                <div class="control-group">
                    <label class="control-label" for="email">Task:</label>
                    <div class="controls">
                        <textarea class="span4 request" rows="5" id="tasks" name="tasks" ><?= $this->data['tasks'] ?></textarea>
                    </div> <!-- /controls -->
                </div> <!-- /control-group -->


                <div class="control-group">
                    <label class="control-label">Image:</label>

                    <div class="controls">

                        <div class="form-group field-category-file btn btn-warning">
                            <i class="icon-large icon-upload"></i> Choose Image
                            <input type="hidden" value="" name="fileimage">
                            <input type="file" onchange="readURL(this);" name="fileimage" id="fileimage">
                            <div class="help-block"></div>
                        </div>
                        <div class="clearfix"></div>
                        <img id="image-src" src="<?= $this->widgetURL() . 'media/' . $this->data['image'] ?>" class="span3">
                    </div>

                </div>





                <div class="form-actions">
                    <?php if($this->is_admin() && $this->data['id']):?>
                    <button type="submit" class="btn btn-primary" onclick="updateform(); return false">Update</button>
                    <button class="btn btn-danger"data-bb-example-key="confirm-options" onclick="deleteform(); return false">Remove</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-primary" onclick="saveform(); return false">Save</button>
                    <?php endif ?>
                    <button type="submit" class="btn btn-success"  onclick="preview(); return false">Preview</button>
                    <a href="<?= $this->widgetURL() ?>" class="btn btn-invert">Cancel</a>

                </div> <!-- /form-actions -->
                <input type="hidden" name="id" id="id" value="<?= $this->data['id']?>">
            </fieldset>
        </form>
        </div>

        <div id="prev-show" class="form-horizontal">

            <p><strong>Status:</strong> <span id="prv-status"></span></p>
            <p><strong>Name:</strong> <span id="prv-name"></span></p>
            <p><strong>Email:</strong> <span id="prv-email"></span></p>
            <p><strong>Task:</strong> <span id="prv-task"></span></p>
            <p><img id="prv-image" src=""></p>
            <div class="clearfix"></div>
            <div class="form-actions">
            <?php if($this->is_admin() && $this->data['id']):?>
                <button type="submit" class="btn btn-primary" onclick="updateform(); return false">Update</button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary" onclick="saveform(); return false">Save</button>
            <?php endif ?>
            <button type="button" class="btn btn-default" onclick="editform(); return false">Edit</button>
            </div>
        </div>

    </div>
</div>

<?php $rmUrl = $this->widgetUrl().'?controller=tasks&action=delete&id='.$this->data['id'] ?>
<style>
    input[type="file"] {
        padding: 4px;
    }
    .input-error{
        border:1px solid #f00;
        -webkit-box-shadow: 0px 0px 5px 1px rgba(245,10,57,1);
        -moz-box-shadow: 0px 0px 5px 1px rgba(245,10,57,1);
        box-shadow: 0px 0px 5px 1px rgba(245,10,57,1);
    }
    #prev-show{
        display:none;
    }

</style>

<script>
    $(document).ready(function () {
        $(".request").focus(function () {
            $(this).removeClass('input-error');
        });
    });

    function preview(){
       if(validation()) {
           $('#form-show').hide();
           $('#prev-show').show();
           $('#title').text("Preview task");
           if($('#status').is(":checked")){
                html = '<i class="btn-icon-only icon-ok"> </i>';
            }else{
                html = '<i class="btn-icon-only icon-remove"> </i>';
            }
           $('#prv-status').html(html);
           $('#prv-name').text($('#name').val());
           $('#prv-email').text($('#email').val());
           $('#prv-task').text($('textarea#tasks').val());
           $('#prv-image').attr('src', $('#image-src').attr('src'));
           if($('#prv-image').width() > $('#prv-image').height()){
               $('#prv-image').width(320);
               $('#prv-image').css('height','auto');

           }else{
               $('#prv-image').height(240);
               $('#prv-image').css('width','auto');
           }
       }
    }

    function editform() {
        $('#prev-show').hide();
        $('#form-show').show();
        $('#title').text("Create new task");
     }

    function saveform(){
        if(validation()){
            $('#task-form').submit();
        }
    }

    function deleteform(){
        var id = $('#id').val();
        bootbox.confirm({
            message: "Do you delete <?= $this->data['name']?>?",
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
                    window.location.href = "<?= $rmUrl ?>";
                }
                console.log('This was logged in the callback: ' + result);
            }
        });
    }

    function updateform(){
        if(validation()){
            $('#task-form').submit();
        }
    }


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-src').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validation(){
        var check = true;
        var filter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
        $('#task-form .request').each(function(e) {
            if($(this).val() == '') {
                check = false;
                $(this).addClass('input-error');
            }
        });

        if(!filter.test($('#task-form #email').val())){
            $('#task-form #email').addClass('input-error');
            check = false;
        }
        return check;
    }
</script>