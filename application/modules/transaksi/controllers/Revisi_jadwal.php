<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Revisi_jadwal extends Absent_Controller
{
    public $title = 'Revisi Jam Kerja';
    //protected $showButtonRight = false;
    protected $showButtonLeft = false;

    public function __construct()
    {
        $this->load->model('absent_model', 'am');
        $this->model = $this->am;
        $this->model->setGroupAbsent(array('12'));
        $this->model->setGenderAbsent(array('S', 'F'));
        $this->model->setWithEndDate(false);
        $this->model->setWithStartDate(false);
        $this->model->setMultipleEmployee(true);
        $this->model->setCodePengajuan('RJ');
        $this->model->setLabel('revisi');

        parent::__construct();
    }

    public function index($referencesId = null)
    {
        $this->model->setColumnTableData(['absents.id', 'no_pengajuan', 'start_date', 'end_date', 'count_employees', 'absent_type_id', 'description', 'absents.updated_at', 'absents.created_at', 'absents.status', 'urutan', 'approval_count','absent_type_group_id']);
        $this->model->setHeaderTableData([
            [['data' => 'No Pengajuan'], ['data' => 'Tanggal Mulai'], ['data' => 'Tanggal Akhir'], ['data' => 'Jumlah Karyawan'], ['data' => 'Jenis Pengajuan'], ['data' => 'Keterangan'], ['data' => 'Approve Terakhir'], ['data' => 'Tanggal Pengajuan'], ['data' => 'Status Pengajuan']],
        ]);

        parent::index($referencesId);
    }
}
