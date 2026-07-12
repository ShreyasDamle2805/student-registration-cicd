# 🚀 Student Registration Portal | AWS CI/CD Pipeline

An end-to-end CI/CD pipeline for deploying a PHP-based Student Registration Portal on AWS using Jenkins, GitHub Webhooks, Apache, MariaDB, Amazon EFS, and an Application Load Balancer.

---

## 🏗️ Architecture

```text
VS Code
   │
Git Push
   │
GitHub
   │
Webhook
   │
Jenkins
   │
Build & Deploy
   │
Amazon EFS
   │
Apache Servers
   │
Application Load Balancer
   │
PHP Application
   │
MariaDB
```

---

## ✨ Features

- 🔄 Automated CI/CD using Jenkins
- 📦 GitHub Webhook Integration
- 🌐 PHP Student Registration & Login
- 🗄️ MariaDB Database
- 📁 Shared Storage using Amazon EFS
- ⚖️ Application Load Balancer
- 🔐 Secure Password Hashing
- 🚀 Automatic Deployment on every Git Push

---

## 🛠️ Tech Stack

- AWS EC2
- Jenkins
- Git & GitHub
- Apache
- PHP
- MariaDB
- Amazon EFS
- Application Load Balancer
- Linux

---

## 📂 Project Structure

```text
student-registration-cicd/
│── index.php
│── register.php
│── login.php
│── dashboard.php
│── logout.php
│── db.php
│── health.php
│── style.css
```

---

## 🚀 CI/CD Workflow

1. Code changes pushed to GitHub.
2. GitHub Webhook triggers Jenkins.
3. Jenkins pulls the latest code.
4. PHP validation and deployment.
5. Application is deployed to Amazon EFS.
6. Apache serves the updated application.
7. ALB routes traffic to healthy instances.

---


## 📚 Learning Outcomes

- Jenkins CI/CD Pipeline
- AWS EC2 Deployment
- GitHub Webhooks
- Amazon EFS
- Apache & PHP
- MariaDB Integration
- Application Load Balancer

---
