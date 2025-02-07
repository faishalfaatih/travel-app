# Travel Booking API

## 📌 Persyaratan
Pastikan komputer Anda memiliki:
- PHP 8.2 atau lebih baru
- Composer
- PostgreSQL
- Node.js & npm (jika menggunakan frontend tambahan)

## 🛠️ Instalasi

### 1. Clone Repository
```sh
git clone https://github.com/username/travel-booking-api.git
cd travel-booking-api
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Konfigurasi .env
Salin file `.env.example` ke `.env`:
```sh
cp .env.example .env
```
Kemudian, atur koneksi database PostgreSQL di file `.env`:
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=travel_booking
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

### 4. Generate Key dan Jalankan Migration
```sh
php artisan key:generate
php artisan migrate --seed
```

### 5. Jalankan Server
```sh
php artisan serve
```
Aplikasi akan berjalan di `http://127.0.0.1:8000`

## 🔑 Autentikasi dengan Laravel Sanctum
### 1. Registrasi Pengguna
#### **Endpoint**: `POST /api/register`
```json
{
    "name": "User",
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### 2. Login
#### **Endpoint**: `POST /api/login`
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```
_Response:_
```json
{
    "token": "your-token-here"
}
```
Gunakan token ini untuk mengakses endpoint yang membutuhkan autentikasi.

## 🚀 Fitur API
### 1. Melihat Jadwal Travel
#### **Endpoint**: `GET /api/available-travel-schedules`
_Response:_
```json
[
    {
        "id": 1,
        "destination": "Yogyakarta",
        "departure_time": "2025-02-10 08:00:00",
        "quota": 5,
        "ticket_price": 150000
    }
]
```

### 2. Pemesanan Tiket
#### **Endpoint**: `POST /api/book-ticket`
```json
{
    "travel_schedule_id": 1
}
```
_Response Berhasil:_
```json
{
    "message": "Tiket berhasil dipesan",
    "reservation": {
        "id": 1,
        "travel_schedule_id": 1,
        "user_id": 2,
        "status": "pending"
    }
}
```

### 3. Melihat Riwayat Pemesanan
#### **Endpoint**: `GET /api/booking-history`
_Response:_
```json
[
    {
        "id": 1,
        "travel_schedule": {
            "destination": "Yogyakarta",
            "departure_time": "2025-02-10 08:00:00"
        },
        "status": "pending"
    }
]
```

## 🔬 Pengujian dengan Postman
1. Buka **Postman**.
2. Tambahkan request untuk login dan dapatkan token.
3. Gunakan token sebagai **Bearer Token** dalam request lain.
4. Uji endpoint seperti **jadwal travel**, **pemesanan tiket**, dan **riwayat pemesanan**.
