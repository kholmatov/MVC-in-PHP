<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:57
 */
?>
<div class="widget">

    <div class="widget-header"><i class="icon-tasks"></i>
        <h3>Create new task</h3>
    </div>

    <!-- /widget-header -->
    <div class="widget-content">

        <form id="task-form" name="taskform" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?= $this->action ?>">
            <fieldset>

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
                        <textarea class="span4 request" rows="5" id="tasks" name="tasks" ></textarea>
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
                        <div class="row">
                            <div class="alert myinfo span4" style="display:none"></div>
                            <?php if($this->data['image']!='no-photo.jpg'):?>
                            <div class="clearfix"></div>
                            <div class="alert alert-info span4">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                Must be 96x96 pix, PNG
                            </div>
                            <?php endif?>

                        </div>
                        <div class="clearfix"></div>
                        <img id="image-src" src="<?= $this->widgetURL() . 'media/' . $this->data['image'] ?>" class="span3">
                    </div>

                </div>

                <?php if($this->admin):?>
                <div class="control-group">
                    <label class="control-label">Status:</label>
                    <div class="controls">
                        <label class="checkbox inline">
                            <input type="checkbox">
                        </label>
                    </div>        <!-- /controls -->
                </div> <!-- /control-group -->
                <?php endif ?>



                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" onclick="saveform(); return false">Save</button>
                    <button type="submit" class="btn btn-success"  onclick="preview(); return false">Preview</button>
                    <a href="<?= $this->widgetURL() ?>" class="btn btn-invert">Cancel</a>
                    <?php if($this->admin):?>
                    <button class="btn btn-danger">Remove</button>
                    <?php endif ?>
                </div> <!-- /form-actions -->
                <input type="hidden" name="id" id="id" value="<?= $this->data['id']?>">
            </fieldset>
        </form>

    </div>
</div>
<!-- Modal -->
<div id="preview" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="icon-tasks"></i> Preview task</h4>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="prv-name"></span></p>
                <p><strong>Email:</strong> <span id="prv-email"></span></p>
                <p><strong>Task:</strong> <span id="prv-task"></span></p>
                <p><img class="span3" id="prv-image" src=""></p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="saveform(); return false">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

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

</style>

<script>
    $(document).ready(function () {
        $(".request").focus(function () {
            $(this).removeClass('input-error');
        });
    });
    function preview(){
       if(validation()) {
           $("#preview").modal('show');
           $('#prv-name').text($('#name').val());
           $('#prv-email').text($('#email').val());
           $('#prv-task').text($('#task').val());
           $('#prv-image').attr('src', $('#image-src').attr('src'));
       }
    }

    function saveform(){
        if(validation()){
            $('#task-form').submit();
        }
    }


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-src').attr('src', e.target.result);
                var filename = $('input[type=file]').val().split('\\').pop();
                $('.myinfo').html(filename);
                $('.myinfo').show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validation(){
        var check = true;
        $('#task-form .request').each(function(e) {
            if($(this).val() == '') {
                check = false;
                $(this).addClass('input-error');
            }
        });
        return check;
    }
</script>