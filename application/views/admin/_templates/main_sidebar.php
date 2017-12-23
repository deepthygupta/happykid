<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url($avatar_dir . '/m_001.png'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo $user_login['firstname'] . $user_login['lastname']; ?></p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo site_url('/'); ?>">
                    <i class="fa fa-home text-primary"></i> <span>Go To Website</span>
                </a>
            </li>
            <li class="<?= active_link_controller('dashboard') ?>">
                <a href="<?php echo site_url('admin/dashboard'); ?>">
                    <i class="fa fa-dashboard"></i> <span><?php echo lang('menu_dashboard'); ?></span>
                </a>
            </li>
            <li class="<?= active_link_controller('blog') ?>">
                <a href="<?php echo site_url('admin/blog'); ?>">
                    <i class="fa fa-file"></i> <span><?php echo lang('menu_blog'); ?></span>
                </a>
            </li>
            <li class="<?= active_link_controller('users') ?>">
                <a href="<?php echo site_url('admin/users'); ?>">
                    <i class="fa fa-file"></i> <span><?php echo lang('menu_users'); ?></span>
                </a>
            </li>
            <li class="<?= active_link_controller('groups') ?>">
                <a href="<?php echo site_url('admin/groups'); ?>">
                    <i class="fa fa-shield"></i> <span><?php echo lang('menu_security_groups'); ?></span>
                </a>
            </li>
            <li class="treeview <?= active_link_controller('prefs') ?>">
                <a href="#">
                    <i class="fa fa-cogs"></i>
                    <span><?php echo lang('menu_preferences'); ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="<?= active_link_function('interfaces') ?>"><a href="<?php echo site_url('admin/prefs/interfaces/admin'); ?>"><?php echo lang('menu_interfaces'); ?></a></li>
                </ul>
            </li>
            <li class="<?= active_link_controller('files') ?>">
                <a href="<?php echo site_url('admin/files'); ?>">
                    <i class="fa fa-file"></i> <span><?php echo lang('menu_files'); ?></span>
                </a>
            </li>
            <li class="<?= active_link_controller('database') ?>">
                <a href="<?php echo site_url('admin/database'); ?>">
                    <i class="fa fa-database"></i> <span><?php echo lang('menu_database_utility'); ?></span>
                </a>
            </li>            
        </ul>
    </section>
</aside>
