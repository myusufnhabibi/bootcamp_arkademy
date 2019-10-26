<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cashier extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cashier_model', 'cm');
    }

    public function index()
    {
        $this->load->view('cashier');
    }

    public function get_data_cashier()
    {
        $list = $this->cm->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="ubah(' . "'" . $field->id . "'" . ')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="hapus(' . "'" . $field->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $row[] = $field->name;

            $data[] = $row;
        }

        $output = array(

            // "draw" => $_POST['draw'],
            "recordsTotal" => $this->cm->count_all(),
            "recordsFiltered" => $this->cm->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function tambah()
    {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
        );
        $insert = $this->cm->simpan($data);
        echo json_encode(array("status" => TRUE));
    }

    public function ubah($id)
    {
        $data = $this->cm->get_by_id($id);
        echo json_encode($data);
    }

    public function update()
    {
        $this->_validate();
        $data = array(
            'name' => $this->input->post('name'),
        );
        $this->cm->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function hapus($id)
    {
        $this->cm->hapus($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('name') == '') {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'Please fill name in the fields';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
