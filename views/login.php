<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 12/09/2017
 * Time: 18:07
 */
?>

<div class="widget">

    <div class="widget-header"><i class="icon-tasks"></i>
        <h3>Login panel</h3>
        <a href="<?= $this->widgetUrl()?>" class="btn btn-invert pull-right" style="margin:6px 5px">Back <i class="icon-share-alt"></i></a>
    </div>

    <!-- /widget-header -->
    <div class="widget-content">

        <div class="content clearfix">
            <?php if (!$this->sts): ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h4>Warning!</h4>
                Login or password incorrect!
            </div>
            <?php endif ?>
            <form action="?controller=admin&action=login" method="post">

                 <div class="login-fields">

                    <p>Please provide your details</p>

                    <div class="field">
                        <label for="login">Login</label>
                        <input type="text" id="login" name="login" value="" placeholder="Login" class="login login-field" />
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
                    </div> <!-- /password -->

                </div> <!-- /login-fields -->

                <div class="login-actions">

<!--				<span class="login-checkbox">-->
<!--					<input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />-->
<!--					<label class="choice" for="Field">Keep me signed in</label>-->
<!--				</span>-->

                    <button class="button btn btn-success btn-large">Login</button>

                </div> <!-- .actions -->



            </form>

        </div> <!-- /content -->


    </div>
</div>
