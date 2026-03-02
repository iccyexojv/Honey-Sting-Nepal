"""
Fraud Detection Transaction Simulator
======================================

Simulates both legitimate and fraudulent transactions against the /api/card-payment endpoint.

USAGE:
    1. Seed database:
       php artisan migrate:fresh --seed

    2. Start Laravel dev server:
       php artisan serve

    3. Run this simulation:
       python Hardware/simulate.py

    4. Results are saved to fraud_simulation_results.json

PATTERNS TESTED:
  - Normal transactions (low risk)
  - Small amount probes (card testing)
  - Large amount outliers (anomaly detection)
  - High velocity transactions (rapid succession)

"""

import requests
import json
import random
import csv
from datetime import datetime
import sys

# API configuration
# Update these to match your Laravel Herd setup
API_BASE = "http://127.0.0.1:8000"  # or your actual host:port
API_ENDPOINT = f"{API_BASE}/api/card-payment"

# Demo data: these IDs should match your seeded database
# Run: php artisan migrate:fresh --seed to generate these
DEMO_CUSTOMERS = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
DEMO_MERCHANTS = [11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
DEMO_CARDS = list(range(1, 100))
DEMO_PAYMENT_METHODS = list(range(1, 100))

# results log
RESULTS = []

def log_transaction(tx_type, payload, response):
    """Log transaction result"""
    result = {
        'timestamp': datetime.now().isoformat(),
        'type': tx_type,
        'customer_id': payload['customer_id'],
        'amount': payload['amount'],
        'card_id': payload['card_id'],
        'merchant_id': payload['merchant_id'],
        'status_code': response.status_code if response else 'ERROR',
        'response': response.json() if response and response.status_code == 200 else response.text if response else 'No response',
    }
    RESULTS.append(result)
    return result

def normal_transaction():
    """Generate legitimate transaction"""
    return {
        'customer_id': random.choice(DEMO_CUSTOMERS),
        'merchant_id': random.choice(DEMO_MERCHANTS),
        'card_id': random.choice(DEMO_CARDS),
        'payment_method_id': random.choice(DEMO_PAYMENT_METHODS),
        'amount': round(random.uniform(10, 200), 2),  # normal range
        'description': 'Normal purchase',
    }

def small_amount_probe():
    """Card testing: multiple small amounts"""
    customer = random.choice(DEMO_CUSTOMERS)
    return {
        'customer_id': customer,
        'merchant_id': random.choice(DEMO_MERCHANTS),
        'card_id': random.choice(DEMO_CARDS),
        'payment_method_id': random.choice(DEMO_PAYMENT_METHODS),
        'amount': round(random.uniform(1, 50), 2),  # small probe
        'description': 'Small test transaction',
    }

def large_outlier():
    """Amount outlier: unusually large"""
    return {
        'customer_id': random.choice(DEMO_CUSTOMERS),
        'merchant_id': random.choice(DEMO_MERCHANTS),
        'card_id': random.choice(DEMO_CARDS),
        'payment_method_id': random.choice(DEMO_PAYMENT_METHODS),
        'amount': round(random.uniform(5000, 10000), 2),  # outlier
        'description': 'Large suspicious amount',
    }

def rapid_velocity():
    """Velocity test: same card, multiple txns"""
    card = random.choice(DEMO_CARDS)
    return {
        'customer_id': random.choice(DEMO_CUSTOMERS),
        'merchant_id': random.choice(DEMO_MERCHANTS),
        'card_id': card,
        'payment_method_id': random.choice(DEMO_PAYMENT_METHODS),
        'amount': round(random.uniform(50, 200), 2),
        'description': 'Velocity test',
    }

def send_transaction(payload, label):
    """Send transaction to API and log result"""
    try:
        response = requests.post(API_ENDPOINT, json=payload, timeout=10)
        result = log_transaction(label, payload, response)
        
        if response.status_code == 200:
            data = response.json()
            risk = data.get('risk_score', '?')
            status = data.get('status', '?')
            card_flag = data.get('card_flagged', '?')
            print(f"✅ [{label}] Amount: ${payload['amount']:>8.2f} | Risk: {risk:>3} | Status: {status:>15} | Card: {card_flag}")
        else:
            print(f"⚠️ [{label}] Error {response.status_code}: {response.text[:100]}")
        
        return result
    except requests.exceptions.Timeout:
        print(f"❌ [{label}] Request timeout - API may be unresponsive")
        log_transaction(label, payload, None)
    except requests.exceptions.ConnectionError:
        print(f"❌ [{label}] Connection refused - ensure Laravel is running")
        log_transaction(label, payload, None)
    except Exception as e:
        print(f"❌ [{label}] Exception: {e}")
        log_transaction(label, payload, None)

def save_results(filename='fraud_simulation_results.json'):
    """Save results to JSON"""
    with open(filename, 'w') as f:
        json.dump(RESULTS, f, indent=2)
    print(f"\n📊 Results saved to {filename}")

def main():
    print("🛡️ Fraud Detection Simulation Active...")
    print(f"📍 Target API: {API_ENDPOINT}\n")

    # Health check
    try:
        print("🔍 Checking API health...")
        resp = requests.get(f"{API_BASE}/api/user", timeout=2)
        print("✅ API is reachable\n")
    except Exception as e:
        print(f"❌ Cannot reach API at {API_BASE}")
        print(f"   Make sure Laravel is running: php artisan serve")
        print(f"   Error: {e}")
        sys.exit(1)

    # Test 1: Normal transactions (should pass)
    print("--- Simulating Normal Transactions ---")
    for i in range(3):
        payload = normal_transaction()
        send_transaction(payload, f"Normal-{i+1}")

    # Test 2: Small amount probes (card testing pattern)
    print("\n--- Simulating Small Amount Probes (Card Testing) ---")
    for i in range(3):
        payload = small_amount_probe()
        send_transaction(payload, f"Probe-{i+1}")

    # Test 3: Large outliers (amount anomaly)
    print("\n--- Simulating Large Amount Outliers ---")
    for i in range(2):
        payload = large_outlier()
        send_transaction(payload, f"Outlier-{i+1}")

    # Test 4: Rapid velocity (multiple txns same card)
    print("\n--- Simulating High Velocity Transactions ---")
    for i in range(5):
        payload = rapid_velocity()
        send_transaction(payload, f"Velocity-{i+1}")

    # Summary
    print("\n" + "="*60)
    print("SIMULATION SUMMARY")
    print("="*60)
    print(f"Total transactions sent: {len(RESULTS)}")
    
    flagged = [r for r in RESULTS if isinstance(r['response'], dict) and r['response'].get('status') == 'flagged_fraud']
    print(f"Flagged as fraud: {len(flagged)}")
    print(f"Passed/Normal: {len(RESULTS) - len(flagged)}")

    # Save results
    save_results()

if __name__ == '__main__':
    main()
