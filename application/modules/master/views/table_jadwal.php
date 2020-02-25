<?php 
    $departemen = $header['departemen'];
    $periode = explode('-',$header['periode']);
    $year = $periode[0];
    $month = $periode[1];
    $jmlKaryawan = $header['jumlah_karyawan'];
    $jmlhari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
?>
<div class="table-responsive" style="margin-top:15px">
    <div class="row col-md-12 alert alert-info  text-center">
        <div class="col-md-4">Departemen : <?php echo $departemen ?></div>
            <div class="col-md-4">Periode : <?php echo convert_ke_bulan($month).' '.$year ?></div>
            <div class="col-md-4">Jumlah Karyawan : <?php echo $jmlKaryawan ?></div>
        </div>
    </div>    
    
    <div class="sticky-table sticky-headers sticky-ltr-cells">
        <table class="table table-bordered">
        <thead>
            <tr class="sticky-row">
                <th class="sticky-cell">No</th>
                <th class="sticky-cell">NIK</th>
                <th class="sticky-cell">Nama</th>
                <th class="sticky-cell">Jabatan</th>
                <th class="sticky-cell">Tgl Masuk</th>
            <?php 
                for ($i = 1; $i <= $jmlhari; $i++) {
                    echo '<th>'.$i.'</th>';
                }
            ?>  
            </tr>
        </thead>
        <tbody>
        <?php 
            if (!empty($detail)) {
                $no = 1;
                foreach ($detail as $dc) {
                    echo '<tr">';
                    echo '<td class="sticky-cell">'.($no++).'</td>';
                    echo '<td class="sticky-cell">'.$dc['nik'].'</td>';
                    echo '<td class="sticky-cell">'.$dc['nama'].'</td>';
                    echo '<td class="sticky-cell">'.$dc['jabatan'].'</td>';
                    echo '<td class="sticky-cell">'.$dc['tglmasuk'].'</td>';
                    foreach ($dc['tanggal'] as $tgl => $item) {
                        if($tgl > $jmlhari) continue;
                        echo '<td>'.$item.'</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr><td>Data tidak ditemukan</td></tr>';
            }
        ?>
        </tbody>
        </table>
    </div>    
</div>
<br />