# -*- coding: utf-8 -*-
import os
import sys
import connect_db
from datetime import datetime, timedelta
import logging
import logging.handlers as handlers
from zk import ZK

CWD = os.path.dirname(os.path.realpath(__file__))
ROOT_DIR = os.path.dirname(CWD)
sys.path.append(ROOT_DIR)

logfilename = os.path.realpath(os.path.join(os.path.dirname(__file__),".." ,"storage", "logs","pulldata.log"))
logger = logging.getLogger('pulldata')
logger.setLevel(logging.INFO)
logHandler = handlers.TimedRotatingFileHandler(logfilename, when='d', interval=1)
logformat = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
logHandler.setFormatter(logformat)
logHandler.setLevel(logging.INFO)
logger.addHandler(logHandler)

ip_address = sys.argv[1] 
port = int(sys.argv[2])
# default hari ini minus 30
start_fingertime = (datetime.now() + timedelta(days = int(connect_db.config['DEFAULT_START_LOGFINGERTIME'])))

conn = None
zk = ZK(ip_address, port, 600)
attendance_updates = []
try:
    conn = zk.connect()
    serial_number = conn.get_serialnumber()
    
    fingerprint_device_id = 1
    last_fingertime = connect_db.get_last_timestamp(serial_number)
    start_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    logger.info("getting data from fingerprint ip {} port {}".format(ip_address, port))
    if last_fingertime is None:
        logger.info("fingertime tidak ada")
    else:
        start_fingertime = last_fingertime[0]
        fingerprint_device_id = last_fingertime[1]
        
    employees = connect_db.get_employee()
    
    if employees is None:
        exit
    employee_dict = { employee[1]:employee[0] for employee in employees}
    attendances = conn.get_attendance()
    logger.info("total data attendance in device is {}".format(len(attendances)))
    for attendance in attendances:
        if attendance is None:
            pass
        else:
            if attendance.timestamp >= start_fingertime:
                # insert data ke table
                if employee_dict.get(attendance.user_id) != None:
                    # employee_id, fingertime, fingerprint_device_id, created_at, updated_at
                    attendance_updates.append((employee_dict.get(attendance.user_id), attendance.timestamp, fingerprint_device_id, start_time, start_time))
    
    if attendance_updates:
        connect_db.insert_logfinger(attendance_updates)        

except Exception as e:
    logger.error("Exception occurred", exc_info=True)
finally:
    logger.info("{} data created or updated".format(len(attendance_updates)))
    print(str(len(attendance_updates))+" data created or updated")
    if conn:
        conn.disconnect()