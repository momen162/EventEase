
<h1 align="center">🎉 EventEase</h1>

<p align="center">An open-source <b>event management platform</b> built with Laravel.  
Organize events, sell tickets, and manage attendees — all in one place.</p>

---

## ✨ Features

- 🔐 Secure authentication & user profiles  
- 📅 Create, manage & explore events  
- 🎟️ Ticket purchasing and management  
- 🛠️ Admin dashboard for event/user control  
- 🎨 Modern UI with Blade templates  
- 📊 Scalable and built with Laravel best practices  

---

## 🎥 Video Demonstration

👉 *A full demo video of EventEase will be available here soon!*  
(You can embed a YouTube/Vimeo link later.)

📄 Documentation:
---

## 🖼️ Screenshots
Login:
![GUI-3](https://github.com/user-attachments/assets/d835681c-6c42-463c-902a-7f47a73cf8c0)
User Dashboard:
![GUI-5](https://github.com/user-attachments/assets/732f7e13-10f7-422d-b0f4-a76cf9214758)
Edit User Profile:
![GUI-7](https://github.com/user-attachments/assets/55816bd2-07a4-48e4-a09a-e14908006b79)
Checkout:
![GUI-4](https://github.com/user-attachments/assets/3a2935ae-a3e7-42ae-824e-b80437e4e653)


---

## ⚙️ Tech Stack

- **Backend**: Laravel 10, PHP 8.1+  
- **Frontend**: Blade templates, TailwindCSS (if applied)  
- **Database**: MySQL / PostgreSQL  
- **Authentication**: Laravel Breeze / Sanctum (based on setup)  
- **Other Tools**: Composer, NPM, Vite  

---

## 🚀 Installation & Setup

1. **Clone the repository**
   ```bash
   git clone https://github.com/masudbinmazid/EventEase.git
   cd EventEase

2. **Install dependencies**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Set up environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database** in `.env`

5. **Run migrations & seeders**

   ```bash
   php artisan migrate --seed
   ```

6. **Start the local server**

   ```bash
   php artisan serve
   ```

   Open 👉 `http://localhost:8000`

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📌 Future Improvements

* [ ] Social Login Integration(Google,Facebook).
* [ ] Payment gateway integration.
* [ ] Email & SMS notifications.
* [ ] Integrate QR codes into tickets and enable QR-based verification at events.
* [ ] Implement email verification to enhance account security and trust.
* [ ] Configure SMTP services to ensure reliable email delivery.
* [ ] API for mobile apps.

---

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/awesome-feature`)
3. Commit your changes (`git commit -m 'Add awesome feature'`)
4. Push to the branch (`git push origin feature/awesome-feature`)
5. Open a Pull Request 🚀

---

## 🔒 Security

If you discover a security vulnerability, please open an issue or contact the maintainers directly.

---

## 📜 License

This project is licensed under the Masud.

---

<p align="center">Made by Masud ❤️ using Laravel</p>
```

---
