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
                        <h3 class="box-title"><?php echo anchor('admin/blog/create', '<i class="fa fa-plus"></i> ' . lang('blog_create_blog'), array('class' => 'btn btn-block btn-primary btn-flat')); ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blog_data as $data): ?>
                                    <tr>
                                        <td><a href="admin/blog/blog_view/" style="text-decoration: none;"><?php echo htmlspecialchars($data->title, ENT_QUOTES, 'UTF-8'); ?></a></td>
                                        <td><?php echo htmlspecialchars($data->date, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($data->author, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo ($data->status == "yes") ? anchor('admin/blog/deactivate/' . $data->blog_id, '<span class="label label-success">' . lang('blog_active') . '</span>') : anchor('admin/blog/activate/' . $data->blog_id, '<span class="label label-default">' . lang('blog_inactive') . '</span>'); ?></td>
                                        <td>
                                            <?php echo anchor('admin/blog/edit/' . $data->blog_id, lang('blod_edit')); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
