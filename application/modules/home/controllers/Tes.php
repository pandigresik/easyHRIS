<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Tes extends DB_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $t = \Model\Storage\Users::with('roleUser')->find(2);
        $menuArr = array_column($t->roleUser->menus->toArray(), 'menus_id');
        $m = \Model\Storage\Menus::with('permissions')->whereIn('id', $menuArr)->get()->toArray();

        $allRoute = [];
        if ($m) {
            foreach ($m as $_m) {
                if (!empty($_m['route'])) {
                    array_push($allRoute, $_m['route']);
                    if (!empty($_m['permissions'])) {
                        $allRoute = array_merge($allRoute, array_column($_m['permissions'], 'route'));
                    }
                }
            }
        }
        echo '<pre>';
        print_r($allRoute);
        $s = serialize($allRoute);
        echo $s;
        print_r(unserialize($s));
        cetak_r($allRoute);
    }

    public function coba()
    {
        $capsule = $this->getCapsule();
        $start = '2019-01-01';
        $end = '2019-05-09';
        echo str_replace('-', '', $end);
        $kodepel = '111S3976';
        echo substr($kodepel, -4);
        //$tmp = \Model\Storage\Dpenagihan::fakturTanggal($start, $end, [])->whereNotNull('NOFAKTUR')->get();
        //$tmp = \Model\Storage\Billing\Fakturhfeed::whereNofaktur('FE04253/19')->with('pelanggan')->get();
        //cetak_r($tmp->toArray());
    }
}
