<html>
    <head>
        <title>ZK Test</title>
    </head>
    
    <body>
<?php
    include("zklib/zklib.php");    
    $zk = new ZKLib("192.168.204.71", 4370);
    $ret = $zk->connect();
    sleep(1);
    if ( $ret ): 
        $zk->disableDevice();
        sleep(1);
    ?>
        
        <table border="1" cellpadding="5" cellspacing="2">
            <tr>
                <td><b>Status</b></td>
                <td>Connected</td>
                <td><b>Version</b></td>
                <td><?php echo $zk->version() ?></td>
                <td><b>OS Version</b></td>
                <td><?php echo $zk->osversion() ?></td>
                <td><b>Platform</b></td>
                <td><?php echo $zk->platform() ?></td>
            </tr>
            <tr>
                <td><b>Firmware Version</b></td>
                <td><?php echo $zk->fmVersion() ?></td>
                <td><b>WorkCode</b></td>
                <td><?php echo $zk->workCode() ?></td>
                <td><b>SSR</b></td>
                <td><?php echo $zk->ssr() ?></td>
                <td><b>Pin Width</b></td>
                <td><?php echo $zk->pinWidth() ?></td>
            </tr>
            <tr>
                <td><b>Face Function On</b></td>
                <td><?php echo $zk->faceFunctionOn() ?></td>
                <td><b>Serial Number</b></td>
                <td><?php echo $zk->serialNumber() ?></td>
                <td><b>Device Name</b></td>
                <td><?php echo $zk->deviceName(); ?></td>
                <td><b>Get Time</b></td>
                <td><?php echo $zk->getTime() ?></td>
            </tr>
        </table>
        <hr />
        <table border="1" cellpadding="5" cellspacing="2" style="float: left; margin-right: 10px;">
            <tr>
                <th colspan="5">Data User</th>
            </tr>
            <tr>
                <th>UID</th>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Password</th>
            </tr>
            <?php
            try {
                
                //$zk->setUser(1, '1', 'Admin', '', LEVEL_ADMIN);
                $user = $zk->getUser();
                sleep(1);
                while(list($uid, $userdata) = each($user)):
                    if ($userdata[2] == LEVEL_ADMIN)
                        $role = 'ADMIN';
                    elseif ($userdata[2] == LEVEL_USER)
                        $role = 'USER';
                    else
                        $role = 'Unknown';
                ?>
                <tr>
                    <td><?php echo $uid ?></td>
                    <td><?php echo $userdata[0] ?></td>
                    <td><?php echo $userdata[1] ?></td>
                    <td><?php echo $role ?></td>
                    <td><?php echo $userdata[3] ?>&nbsp;</td>
                </tr>
                <?php
                endwhile;
            } catch (Exception $e) {
                header("HTTP/1.0 404 Not Found");
                header('HTTP', true, 500); // 500 internal server error                
            }
            //$zk->clearAdmin();
            ?>
        </table>
        
        <table border="1" cellpadding="5" cellspacing="2">
            <tr>
                <th colspan="7">Data Attendance</th>
            </tr>
            <tr>
                <th>Index</th>
                <th>UID</th>
                <th>ID</th>
                <th>Function Key</th>
                <th>Status</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php
            $attendance = $zk->getAttendance();
            sleep(1);
            $status_attendance = array(
                '0' => 'Masuk/Pulang',
                '1' => 'DL',
                '2' => 'KP',
                '3' => 'Masuk DL/KP',
                '4' => 'Istirahat Keluar',
                '5' => 'Istirahat Masuk'
            );
            while(list($idx, $attendancedata) = each($attendance)):
                $status = isset($status_attendance[$attendancedata[4]]) ? $status_attendance[$attendancedata[4]] : 'Not Yet Defined';
            ?>
            <tr>
                <td><?php echo $idx ?></td>
                <td><?php echo $attendancedata[0] ?></td>
                <td><?php echo $attendancedata[1] ?></td>
                <td><?php echo $attendancedata[4] ?></td>
                <td><?php echo $status ?></td>
                <td><?php echo date( "Y-m-d", strtotime( $attendancedata[3] ) ) ?></td>
                <td><?php echo date( "H:i:s", strtotime( $attendancedata[3] ) ) ?></td>
            </tr>
            <?php
            endwhile
            ?>
        </table>
        
    <?php
    //    $zk->clearAttendance();
    /*
        $zk->enrollUser('123');
        $zk->setUser(123, '123', 'Shubhamoy Chakrabarty', '', LEVEL_USER);
        $zk->enableDevice();
    */    
        sleep(1);
        $zk->disconnect();
    endif
?>
    </body>
</html>
