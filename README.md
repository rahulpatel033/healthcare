# 🚀 Project Setup Guide

Follow the steps below to build and run the application using Docker.
Also make sure that PORT 80 is free in your system, if not you need to change it in docker compose inside nginx container logic

---

## 🐳 1. Build & Start Containers

```bash
sudo docker compose up --build -d
```

This command will:

- Build all Docker images  
- Start all containers in detached mode  
- Prepare the application environment  

---

## 🗄️ 2. Run Database Migrations

```bash
sudo docker compose exec app php artisan migrate
```

This creates all necessary database tables inside the container.

---

## 🌱 3. Seed the Database

```bash
sudo docker compose exec app php artisan db:seed
```

This seeds the initial data required for the application.

---

## 📘 4. API Documentation

Once the containers are running, access the API documentation here:

👉 **http://localhost/docs**
