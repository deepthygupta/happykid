<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="content-wrapper">
    <section class="content-header">
        <?php echo $pagetitle; ?>
        <?php echo $breadcrumb; ?>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo lang('gallary_add_image'); ?></h3>
                    </div>
                    <div class="box-body">
                        <?php echo $message; ?>

                        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-add_image')); ?>
                        <div class="form-group">
                            <?php echo lang('gallery_name', 'name', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_input($name); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo lang('gallery_image', 'image', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_input($image); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php echo lang('gallery_description', 'description', array('class' => 'col-sm-2 control-label')); ?>
                            <div class="col-sm-10">
                                <?php echo form_input($description); ?>
                            </div>
                        </div>     
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="btn-group">
                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                    <?php echo anchor('admin/gallery', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
