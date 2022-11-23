from dotenv import dotenv_values
from datetime import datetime
import pymysql
import os

config = dotenv_values(os.path.realpath(os.path.join(os.path.dirname(__file__),"../.env")))

db = pymysql.connect(
  host=config['DB_HOST'],
  user=config['DB_USERNAME'],
  passwd=config['DB_PASSWORD'],
  database=config['DB_DATABASE']
)


def get_last_timestamp(serial_number):
  cursor = db.cursor()
  sql = f"""select fingertime, fingerprint_device_id from attendance_logfingers 
    where fingerprint_device_id in (select id from fingerprint_devices where serial_number = '{serial_number}')
    and fingertime <= now()
    order by fingertime desc limit 1"""  
  cursor.execute(sql)
  result = cursor.fetchone()
  return result

def get_employee():
  cursor = db.cursor()
  sql = "select id, code from employees where (resign_date  is null or resign_date >= date_add(now(), interval -30 day))"
  cursor.execute(sql)
  return cursor.fetchall()

def insert_logfinger(attendances):  
  cursor = db.cursor()
  sql = "INSERT INTO attendance_logfingers (employee_id, fingertime, fingerprint_device_id, created_at, updated_at) VALUES (%s, %s, %s, %s, %s) ON DUPLICATE KEY UPDATE updated_at=VALUES(updated_at)"
  cursor.executemany(sql, attendances)
  cursor.close()
  db.commit()
