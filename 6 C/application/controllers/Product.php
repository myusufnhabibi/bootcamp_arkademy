<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model', 'pm');
    }

    public function index()
    {
        $data['cashier'] = $this->pm->get('cashier');
        $data['category'] = $this->pm->get('category');
        $this->load->view('Product/index', $data);
    }

    public function get_data()
    {
        $list = $this->pm->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ubah(' . "'" . $field->id . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $field->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $row[] = $field->name;
            $row[] = $field->name_product;
            $row[] = $field->name_category;
            $row[] = $field->price;

            $data[] = $row;
        }

        $output = array(

            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->pm->count_all(),
            "recordsFiltered" => $this->pm->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function tambah()
    {
        $this->_validate();
        $data = array(
            'name_product' => $this->input->post('product'),
            'price' => $this->input->post('price'),
            'id_category' => $this->input->post('category'),
            'id_cashier' => $this->input->post('cashier'),
        );
        $insert = $this->pm->simpan($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ubah($id)
    {
        $data = $this->pm->get_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $data = array(
            'name_product' => $this->input->post('product'),
            'price' => $this->input->post('price'),
            'id_category' => $this->input->post('category'),
            'id_cashier' => $this->input->post('cashier'),
        );
        $this->pm->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function hapus($id)
    {
        $this->pm->hapus($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('cashier') == '') {
            $data['inputerror'][] = 'cashier';
            $data['error_string'][] = 'Please fill cashier in the fields';
            $data['status'] = FALSE;
        }

        if ($this->input->post('category') == '') {
            $data['inputerror'][] = 'category';
            $data['error_string'][] = 'Please fill category in the fields';
            $data['status'] = FALSE;
        }

        if ($this->input->post('price') == '') {
            $data['inputerror'][] = 'price';
            $data['error_string'][] = 'Please fill price in the fields';
            $data['status'] = FALSE;
        }

        if ($this->input->post('product') == '') {
            $data['inputerror'][] = 'product';
            $data['error_string'][] = 'Please fill product in the fields';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
