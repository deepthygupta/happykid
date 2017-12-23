<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->lang->load('admin/blog');
        $this->page_title->push(lang('menu_blog'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->breadcrumbs->unshift(1, lang('menu_blog'), 'admin/blog');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            $k = 0;
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->data['blog_data'] = $this->ion_auth->blog()->result();
            foreach ($this->data['blog_data'] as $k => $blog) {
                $this->data['blog_data'][$k] = $blog;
                $k++;
            }
            $this->template->admin_render('admin/blog/index', $this->data);
        }
    }

    public function create() {
        $this->breadcrumbs->unshift(2, lang('menu_blog_create'), 'admin/blog/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->form_validation->set_rules('title', 'lang:blog_title', 'required');
        $this->form_validation->set_rules('description', 'lang:blog_description', 'required');
        $this->form_validation->set_rules('author', 'lang:blog_author', 'required');

        if ($this->form_validation->run() == TRUE) {
            $title = strtolower($this->input->post('title'));
            $description = strtolower($this->input->post('description'));
            $author = $this->input->post('author');
            }

        if ($this->form_validation->run() == TRUE && $this->ion_auth->add_blog($title, $description, $author)) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin/blog', 'refresh');
        } else {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['title'] = array(
                'name' => 'title',
                'id' => 'title',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('title'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('description'),
            );
            $this->data['author'] = array(
                'name' => 'author',
                'id' => 'author',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('author'),
            );
            $this->template->admin_render('admin/blog/create', $this->data);
        }
    }

    public function edit($id) {
        $id = (int) $id;
        if (!$this->ion_auth->logged_in() OR ( !$this->ion_auth->is_admin())) {
            redirect('auth', 'refresh');
        }
        $this->breadcrumbs->unshift(2, lang('menu_users_edit'), 'admin/blog/edit');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $blog_data = $this->ion_auth->blog($id)->row();
        
        $this->form_validation->set_rules('title', 'lang:edit_blog_validation_title_label', 'required');
        $this->form_validation->set_rules('description', 'lang:edit_blog_validation_description_label', 'required');
        $this->form_validation->set_rules('author', 'lang:edit_blog_validation_author_label', 'required');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('blog_id')) {
                show_error($this->lang->line('error_csrf'));
            }          

            if ($this->form_validation->run() == TRUE) {
                $data = array(
                    'description' => $this->input->post('description'),
                    'author' => $this->input->post('author'),
                    'title' => $this->input->post('title')
                );                     

                if ($this->ion_auth->update_blog($blog_data->blog_id, $data)) {
                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    if ($this->ion_auth->is_admin()) {
                        redirect('admin/blog', 'refresh');
                    } else {
                        redirect('admin', 'refresh');
                    }
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }

        $this->data['csrf'] = $this->_get_csrf_nonce();
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        $this->data['blog'] = $blog_data;

        $this->data['title'] = array(
            'name' => 'title',
            'id' => 'title',
            'type' => 'text',
            'class' => 'form-control',
            'autoComplete' => 'off',
            'value' => $this->form_validation->set_value('title', $blog_data->title)
        );
        $this->data['description'] = array(
            'name' => 'description',
            'id' => 'description',
            'type' => 'text',
            'class' => 'form-control',
            'autoComplete' => 'off',
            'value' => $this->form_validation->set_value('description', $blog_data->description)
        );
        $this->data['author'] = array(
            'name' => 'author',
            'id' => 'author',
            'type' => 'text',
            'class' => 'form-control',
            'autoComplete' => 'off',
            'value' => $this->form_validation->set_value('author', $blog_data->author)
        );
       
        $this->template->admin_render('admin/blog/edit', $this->data);
    }

    function activate($id) {
        $activation = $this->ion_auth->activate_blog($id);
        if ($activation) {
            $this->session->set_flashdata('Blog Activated Successfully');
            redirect('admin/blog', 'refresh');
        } else {
            $this->session->set_flashdata('Error on activation');
            redirect('auth/blog', 'refresh');
        }
    }

    public function deactivate($id = NULL) {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            return show_error('You must be an administrator to view this page.');
        }
        $this->breadcrumbs->unshift(2, lang('menu_users_deactivate'), 'admin/blog/deactivate');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->form_validation->set_rules('confirm', 'lang:deactivate_validation_confirm_label', 'required');
        $id = (int) $id;

        if ($this->form_validation->run() === FALSE) {
            $blog = $this->ion_auth->blog($id)->row();
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['blog_id'] = (int) $blog->blog_id;
            $this->template->admin_render('admin/blog/deactivate', $this->data);
        } else {
            if ($this->input->post('confirm') == 'yes') {
                if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('blog_id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
                    $this->ion_auth->deactivate_blog($id);
                }
            }
            redirect('admin/blog', 'refresh');
        }
    }

    public function profile($id) {
        /* Breadcrumbs */
        $this->breadcrumbs->unshift(2, lang('menu_users_profile'), 'admin/groups/profile');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        /* Data */
        $id = (int) $id;

        $this->data['user_info'] = $this->ion_auth->user($id)->result();
        foreach ($this->data['user_info'] as $k => $user) {
            $this->data['user_info'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }

        /* Load Template */
        $this->template->admin_render('admin/users/profile', $this->data);
    }

    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    public function _valid_csrf_nonce() {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
