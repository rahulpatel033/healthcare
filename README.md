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


## 5. Thisgs should be added in future in this project

Redis
For caching to improve system speed and scalability.

Memcached
Ultra-fast in-memory cache for simple, short-lived key–value data. Its fater then redis but can store only string so use it when we have simple things to store

Kafka or Laravel Horizon
Distributed event streaming platform for async processing, background jobs.

Grafana Loki
Centralized log aggregation solution.

Prometheus
Metrics collection and monitoring system for performance benchmarking and alerting.

OpenTelemetry
Distributed tracing for end-to-end visibility across services and debugging latency issues.

Microservices Architecture
Split high-traffic modules into independent services to improve performance.

Kubernetes (K8s)
Modern orchestration platform ideal for deploying, scaling, and managing containerized microservices in production.