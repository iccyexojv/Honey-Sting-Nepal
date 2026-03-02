# 🐝 Honey-Sting Nepal  
### *Detect. Deceive. Defend.*  

> An IoT & Web-Based Honeypot System to Track and Analyze Scammers in Nepal 🇳🇵  

---

## 📌 Introduction

With the rapid growth of digital banking, mobile wallets (eSewa, Khalti), online transactions, and ATM usage in Nepal, cyber fraud cases have increased significantly. From OTP phishing and wallet impersonation scams to ATM skimming and card cloning, digital criminals are continuously evolving.

Nepal’s cybersecurity ecosystem is still developing, and proactive defense mechanisms are limited. Most systems react **after** fraud occurs rather than preventing it in real-time.

**Honey-Sting Nepal** is designed to address this challenge by deploying controlled fake vulnerable environments (honeypots) to attract scammers, monitor their behavior, analyze attack patterns, and generate actionable intelligence.

---

## 🎯 Project Objectives

- 🔍 Detect and monitor scam attempts in controlled environments  
- 🧠 Analyze attacker behavior and identify common fraud patterns  
- 🌐 Track IP addresses and suspicious device signatures  
- ⚡ Generate real-time alerts and risk scores  
- 📊 Visualize attack analytics through an interactive web dashboard  
- 🛡️ Contribute to proactive fraud prevention strategies in Nepal  

---

## 🛠️ How the System Works

Honey-Sting Nepal operates in a structured multi-layer workflow:

### Step 1: Deploy Honeypot Environment
A fake vulnerable system (e.g., phishing login page, fake wallet portal, simulated ATM interface) is deployed to attract scammers.

### Step 2: Attacker Interaction
When a scammer interacts with the system:
- Login attempts are recorded  
- IP address is captured  
- Device/browser fingerprint is logged  
- Time, frequency, and behavioral metrics are collected  

### Step 3: IoT Monitoring Layer
IoT devices such as **ESP32** or **Raspberry Pi** act as monitoring nodes:
- Log suspicious activity  
- Send real-time data to backend server  
- Monitor environmental triggers (optional physical trap setups)  

### Step 4: Backend Processing
The backend:
- Stores logs in a secure database  
- Assigns a dynamic **risk score**  
- Identifies repeat offenders  
- Generates alerts for high-risk patterns  

### Step 5: Web Dashboard Analytics
Administrators can:
- View real-time attack logs  
- Monitor geographic attack sources  
- Analyze fraud trends  
- Access risk scoring reports  

---

## 🏗️ System Architecture

Technology Stack – Honey-Sting Nepal 🐝

Based on the Proof of Concept System Flow, the project integrates IoT hardware, secure backend processing, and a real-time monitoring dashboard.

🔌 1. IoT & Hardware Layer
🟢 Arduino UNO (Merchant Node)

Reads NFC/RFID card interactions

Processes input locally

Communicates with backend via serial/WiFi module

📡 RFID / NFC Module

Detects suspicious card taps

Captures unique card identifiers (UID)

Simulates fraud interaction environment

🌐 Communication Module

ESP8266 / ESP32 (WiFi-enabled microcontroller)

Sends JSON payload to backend API

Enables real-time cloud communication

🔄 2. Data Transmission Layer
📦 JSON Payload

Structured data format

Includes:

Card UID

Timestamp

Device ID

Risk indicators

Attempt count

Secure transmission via:

REST API

HTTPS Protocol

🖥️ 3. Backend Layer
🚀 Laravel Backend Framework

RESTful API architecture

Handles authentication & validation

Processes incoming JSON payloads

Implements risk scoring logic

Stores structured fraud logs

🗄️ Database

MySQL / PostgreSQL

Stores:

Transaction logs

Device logs

IP addresses

Risk scores

Alert history

📊 4. Admin Monitoring Dashboard
🌐 Frontend

Blade / React.js (depending on implementation)

TailwindCSS for UI styling

Responsive admin interface

📈 Visualization & Alerts

Chart libraries (ApexCharts / Chart.js)

Real-time suspicious activity feed

Red Alert trigger system

Risk-based flagging system

🔐 5. Security Components

HTTPS encryption

API authentication (JWT / Sanctum)

Input validation & sanitization

Rate limiting

Secure device identification

☁️ 6. Deployment & Infrastructure

Localhost development (XAMPP / Laragon)

VPS / Cloud hosting

Nginx / Apache server

Git version control

Environment configuration via .env




---

## ⚙️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/honey-sting-nepal.git
cd honey-sting-nepal

### 2️⃣ Backend Setup
composer run setup
Create database
Update .env file
php artisan migrate:fresh --seed

---

****This project was developed during:****

**🚀 SANDBOX 3.0 Hackathon

👥 Team Name: ZENOVA
        1.Sujan Shrestha
        2.Srijan Dangol
        3.Prashank Pant
        4.Shahil Jung Gautam
💡 Idea & Mentor: UMANGA PATHAK**
