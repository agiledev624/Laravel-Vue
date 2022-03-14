import requests
import time

def period_func():
  while True:
    print('update match_list')
    r = requests.post('http://202.169.100.190/api/v1/lockers/check_reminder')
    print(r.text)
    
    time.sleep(60 * 30) # update every 30 mins

period_func()
