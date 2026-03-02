# for only one merchant 
# import serial
# import requests
# import json
# import time

# # --- SETUP ---
# SERIAL_PORT = 'COM3'  # Double-check this in Arduino IDE -> Tools -> Port
# BAUD_RATE = 9600
# # Updated to point to your local FastAPI server
# API_ENDPOINT = "http://zenova.test/admin/transactions" 

# try:
#     arduino = serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=1)
#     print(f"✅ Connected to Merchant Terminal on {SERIAL_PORT}")
#     print("🛡️ Honey Trap active. Listening for scans...")
# except Exception as e:
#     print(f"❌ Connection Error: {e}")
#     exit()

# while True:
#     if arduino.in_waiting > 0:
#         # Read the raw string from Arduino
#         try:
#             raw_line = arduino.readline().decode('utf-8').strip()
            
#             if raw_line:
#                 # Convert string to Python Dictionary
#                 data_to_send = json.loads(raw_line)
                
#                 # Extract values for a cleaner console log
#                 m_id = data_to_send.get('merchant_id')
#                 n_id = data_to_send.get('nfc_id')
#                 loc = data_to_send.get('location')

#                 print(f"📩 Processing: Merchant[{m_id}] @ {loc} scanned Card[{n_id}]")

#                 # POST request to your FastAPI server
#                 response = requests.post(API_ENDPOINT, json=data_to_send)
                
#                 if response.status_code == 200:
#                     print("🚀 Data synced to FastAPI successfully.")
#                 else:
#                     print(f"⚠️ API Error: {response.status_code} - {response.text}")

#         except json.JSONDecodeError:
#             # This happens if the serial data is cut off or noisy
#             print(f"⚠️ Received messy data: {raw_line}")
#         except UnicodeDecodeError:
#             print("⚠️ Decoding error. Check your Serial Baud Rate.")
#         except Exception as e:
#             print(f"❌ Error during request: {e}")

#     time.sleep(0.1)


# for multiple merchant 

import serial
import requests
import json
import time
import threading
import random

# --- CONFIGURATION ---
# List your ports here. Add as many as you have Arduinos connected!
MERCHANT_PORTS = ['COM3', 'COM8']
BAUD_RATE = 9600
API_ENDPOINT = "http://zenova.test/api/card-payment"  # updated to Laravel endpoint



def listen_to_arduino(port):
    """Function to run in a thread for each Arduino"""
    try:
        arduino = serial.Serial(port, BAUD_RATE, timeout=1)
        print(f"✅ Started Monitor on {port}")
    except Exception as e:
        print(f"❌ Could not connect to {port}: {e}")
        return

    while True:
        if arduino.in_waiting > 0:
            try:
                raw_line = arduino.readline().decode('utf-8').strip()
                if raw_line:
                    data = json.loads(raw_line)

                    # raw data received from Arduino
                    print(f"📩 [{port}] Raw payload {data}")

                    # interpret Arduino fields according to new mapping:
                    #   nfc_id -> card_id
                    #   merchant_id -> payment_method_id
                    card_id = data.get('nfc_id')
                    pm_id = data.get('merchant_id')

                    if pm_id is None or card_id is None:
                        print(f"⚠️ {port} missing nfc_id or merchant_id in payload {data}")
                        continue

                    # the Arduino doesn't provide amount/description, so make them up
                    amt = data.get('amount')
                    if not amt:
                        amt = round(random.uniform(1, 10000), 2)
                    desc = data.get('location') or 'N/A'

                    payload = {
                        'card_id': card_id,
                        'payment_method_id': pm_id,
                        'amount': amt,
                        'description': desc,
                    }

                    # Send to Laravel with headers and show body
                    headers = {
                        "Accept": "application/json",
                        "Content-Type": "application/json",
                        "User-Agent": "HoneyTrapClient/1.0",
                    }
                    try:
                        response = requests.post(API_ENDPOINT, json=payload, headers=headers)
                        if response.status_code == 200:
                            print(f"🚀 {port} -> Laravel Sync OK -> {response.json()}")
                        else:
                            print(f"⚠️ {port} -> API Error: {response.status_code} - {response.text}")
                    except Exception as e:
                        print(f"❌ {port} -> Request failed: {e}")

            except json.JSONDecodeError:
                print(f"⚠️ {port} messy data: {raw_line}")
            except Exception as e:
                print(f"❌ {port} Error: {e}")
        
        time.sleep(0.05) # Fast polling for 'Wireshark' feel

# --- MAIN ENGINE ---
print("🛡️ Multi-Merchant Honey Trap System Active...")
threads = []

for port in MERCHANT_PORTS:
    # Create a new thread for each port
    t = threading.Thread(target=listen_to_arduino, args=(port,))
    t.daemon = True # Allows script to exit even if threads are running
    threads.append(t)
    t.start()

# Keep the main program alive
try:
    while True:
        time.sleep(1)
except KeyboardInterrupt:
    print("\n🛑 System Shutting Down...")