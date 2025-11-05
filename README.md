# 🐄 Smart Livestock Drug Logging & QR Verification System

A **smart and transparent livestock treatment logging system** built using **PHP, MySQL, and Bootstrap**, where **farmers** can record the drugs used on animals, **QR codes** are auto-generated to ensure product traceability, and **retailers** and **admins** can verify product safety and manage drug regulations.

---

## 🌟 Features

| Role | Capabilities |
|------|---------------|
| 👨‍🌾 **Farmer** | Logs animal treatments, auto-fetches withdrawal periods, and generates traceable QR codes for animal products. |
| 🧑‍💼 **Admin** | Manages drug withdrawal periods, and updates AMU/MRL (Antimicrobial Usage & Maximum Residue Limit) regulations. |
| 🛒 **Retailer** | Verifies whether a product is *SAFE* or *NOT SAFE* for sale by entering the QR file name. |

---

## 🧠 Project Summary

This system promotes **food safety, traceability, and compliance** in the livestock supply chain.  
Each treatment record generates a unique **QR code** linked to the animal’s treatment data, withdrawal period, and safe date.  
Retailers and consumers can verify the safety of animal products before consumption.

---

## 🏗️ Tech Stack

| Layer | Technology |
|-------|-------------|
| **Frontend** | HTML5, CSS3, Bootstrap 5, JavaScript (jQuery) |
| **Backend** | PHP 8 |
| **Database** | MySQL (phpMyAdmin) |
| **QR Generation** | phpqrcode library |
| **Server** | XAMPP (Apache + MySQL) |

---

## ⚙️ System Modules

### 👨‍🌾 Farmer Dashboard
- Login & secure session management  
- Add treatment record (Animal ID, Drug, Date)  
- Auto-fetch withdrawal period from drug table  
- Calculate safe consumption date automatically  
- Generate & view QR code linked to each treatment  
- View treatment history  

### 🧑‍💼 Admin Dashboard
- Add or edit drugs and their withdrawal periods  
- Manage AMU & MRL regulations  
- View all drugs in a neat dashboard  

### 🛒 Retailer Dashboard
- Enter QR file name to verify product safety  
- View product treatment info (animal, drug, safe date, farmer)  
- Clear visual status:  
  - ✅ SAFE (if today ≥ safe date)  
  - ⚠️ NOT SAFE (if within withdrawal period)

---

## 🧩 Database Design

### Tables Used
- **users** → stores all user types (farmer, retailer, admin)  
- **drugs** → stores drug details and withdrawal periods  
- **treatments** → stores farmer logs, safe dates, and QR filenames  

### Relationships
- Each treatment links to one drug and one farmer  
- `qr_filename` uniquely identifies each QR code image  

---

## 🗃️ Example Data

### users
| user_id | username  | password | role |
|----------|------------|----------|------|
| 1 | farmer1 | 123 | farmer |
| 2 | retailer1 | 123 | retailer |
| 3 | admin | admin | admin |

### drugs
| drug_id | drug_name | withdrawal_period |
|----------|------------|-------------------|
| 1 | Oxytetracycline | 5 |
| 2 | Penicillin | 3 |

---

## 🚀 Installation Guide

### Requirements
- XAMPP (PHP ≥ 8.0, MySQL ≥ 5.7)
- Browser (Chrome/Edge)
- phpMyAdmin

### Steps
1. **Clone or Download the Repository**
   ```bash
   git clone https://github.com/yourusername/farmer_log.git
2.Move Project Folder to XAMPP
C:\xampp\htdocs\farmer_log\

3.Start Apache & MySQL from XAMPP Control Panel.

4.Create Database
Go to http://localhost/phpmyadmin
Create a database named: " farm_logger "

5.Import SQL File
Import the provided farm_logger.sql into your new database.

6.Run the Project
Open in browser:
http://localhost/farmer_log/

7.Login Using Test Accounts
👨‍🌾 Farmer → farmer1 / 123
🛒 Retailer → retailer1 / 123
🧑‍💼 Admin → admin / admin

   



## 🔐 Security & Data Flow
### Session-based access control
### Data integrity across all user roles
### Each treatment record linked to a secure, unique QR code
### Farmers, retailers, and admins each have isolated dashboards

🎯 Future Enhancements
📱 Camera-based QR scanning (using html5-qrcode)
📨 Email/SMS notification on safe-date arrival
🌐 Public consumer verification page
📊 Analytics for drug usage trends
📱 Mobile app integration (Flutter / React Native)


👨‍💻 Developed By
Team:Say Mooooooo!
Institution: BBDITM Lucknow
Year: 2025

Team Members:
Pooja Bisht (Team Head)
Prateek Verma (Backend & Database)
Priyanka Yadav (Testing & Documentation)
Tulika Srivastava (Frontend & UI Design)

🧾 License
This project is open-source under the MIT License.
Feel free to use, modify, or distribute it for educational or research purposes.


❤️ Thank You!
If you like this project, don’t forget to ⭐ star the repo and contribute your ideas!
“Transparency in agriculture begins with digital traceability.”
