import requests
import json

API_URL = "http://honey-sting.test/api/card-payment"

good_payload = {
    "card_id": 1,
    "payment_method_id": 1,
    "amount": 250.75,
    "description": "Test payment from Python"
}

bad_card_payload = {
    "card_id": 2,
    "payment_method_id": 1,
    "amount": 250.75,
    "description": "Test payment from Python"
}

bad_merchant_payload = {
    "card_id": 1,
    "payment_method_id": 2,
    "amount": 250.75,
    "description": "Test payment from Python"
}

bad_payload = {
    "card_id": 2,
    "payment_method_id": 2,
    "amount": 250.75,
    "description": "Test payment from Python"
}

# Update this to change payload
payload = bad_payload

headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
    "User-Agent": "FraudSimulationClient/1.0"
}

try:
    response = requests.post(
        API_URL,
        json=payload,
        headers=headers,
        allow_redirects=False  # critical for debugging
    )

    print("\n=== REQUEST INFO ===")
    print("Requested URL:", API_URL)
    print("Final URL:", response.url)
    print("Status Code:", response.status_code)

    # Detect redirect
    if 300 <= response.status_code < 400:
        print("\n⚠ Redirect detected")
        print("Location:", response.headers.get("Location"))
        print("Response body preview:")
        print(response.text[:500])
        exit()

    print("\n=== RESPONSE ===")

    try:
        print(json.dumps(response.json(), indent=4))
    except ValueError:
        print("⚠ Not JSON. Raw response:")
        print(response.text[:1000])

except requests.exceptions.RequestException as e:
    print("Request failed:", str(e))