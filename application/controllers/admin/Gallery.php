<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        $this->lang->load('admin/gallery');
        $this->page_title->push(lang('menu_gallery'));
        $this->data['pagetitle'] = $this->page_title->show();
        $this->breadcrumbs->unshift(1, lang('menu_gallery'), 'admin/gallery');
    }

    public function index() {
        if (!$this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin()) {
            redirect('auth/login', 'refresh');
        } else {
            $k = 0;
            $this->data['breadcrumb'] = $this->breadcrumbs->show();
            $this->data['gallery_data'] = $this->ion_auth->gallery()->result();
            foreach ($this->data['gallery_data'] as $k => $gallery) {
                $this->data['gallery_data'][$k] = $gallery;
                $k++;
            }
            $this->template->admin_render('admin/gallery/index', $this->data);
        }
    }

    public function create() {
        $this->breadcrumbs->unshift(2, lang('menu_gallery'), 'admin/gallery/create');
        $this->data['breadcrumb'] = $this->breadcrumbs->show();

        $this->form_validation->set_rules('name', 'lang:gallery_name', 'required');
        $this->form_validation->set_rules('description', 'lang:gallery_description', 'required');
        $this->form_validation->set_rules('image', 'lang:gallery_image', 'required');

        if ($this->form_validation->run() == TRUE) {
            $name = strtolower($this->input->post('name'));
            $description = strtolower($this->input->post('description'));
            $image = $this->input->post('image');
        }

        if ($this->form_validation->run() == TRUE && $this->ion_auth->add_image($name, $description, $image)) {
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect('admin/gallery', 'refresh');
        } else {
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['name'] = array(
                'name' => 'name',
                'id' => 'name',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('description'),
            );
            $this->data['image'] = array(
                'name' => 'image',
                'id' => 'image',
                'type' => 'text',
                'class' => 'form-control',
                'autoComplete' => 'off',
                'value' => $this->form_validation->set_value('image'),
            );
            $this->template->admin_render('admin/gallery/create', $this->data);
        }
    }

    public function delete($id = '') {
        $delete = $this->ion_auth->delete_image($id);
        if ($delete) {
            $this->session->set_flashdata('Image Removed Successfully');
        } else {
            $this->session->set_flashdata('Error on Deletion');
        }
        redirect('admin/gallery', 'refresh');
    }

}
