import requests
import time

def period_func():
  
  print('update partnership bonus')
  r = requests.get('http://127.0.0.1/api/update_partnership_bonus')
  print(r.text)
  time.sleep(86400)
 
period_func()
