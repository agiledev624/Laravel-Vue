import requests
import threading

def period_func():
  threading.Timer(60.0, period_func).start()  
  print('update odd_list')
  r = requests.get('http://127.0.0.1/api/update_odd_list')
  print(r.text)

period_func()
