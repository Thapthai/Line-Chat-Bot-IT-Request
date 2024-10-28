
# ระบบแจ้งปัญหาผ่าน LINE Message API

ระบบนี้พัฒนาขึ้นเพื่อช่วยให้ผู้ใช้สามารถแจ้งปัญหาโดยใช้ LINE โดยรองรับทั้งข้อความและรูปภาพ 
พร้อมทั้งจัดการสถานะของการแจ้งปัญหาอย่างเป็นระบบในฐานข้อมูล SQL Server และมีการใช้ Laravel Framework

---

## คุณสมบัติหลัก (Features)

- รองรับการแจ้งปัญหาผ่าน Line Message API
- บันทึกข้อมูลปัญหาและรายละเอียดลงในฐานข้อมูล SQL Server
- การตอบกลับอัตโนมัติผ่าน LINE Message API
- ใช้โครงสร้าง MVC ใน Laravel เพื่อให้การจัดการโค้ดง่ายขึ้น

---

## การติดตั้ง (Installation)

1. **Clone โปรเจกต์**: 
   ```bash
   git clone https://github.com/Thapthai/Line-Chat-Bot-IT-Request.git
   cd Line-Chat-Bot-IT-Request
   ```
2. **เปิดใช้งาน PHP Sockets Extension**:
   - เปิดไฟล์ php.ini ด้วยโปรแกรมแก้ไขข้อความ (เช่น Notepad หรือ VS Code).
   - ค้นหาบรรทัดที่มีคำว่า ;extension=sockets และลบ ; ที่อยู่หน้าบรรทัดนั้น เพื่อเปิดใช้งาน
   ```bash
   extension=sockets
   ```

4. **ติดตั้ง dependencies**:
   ```bash
   composer install
   npm install
   ```

5. **ตั้งค่าไฟล์ .env**:
   - คัดลอกไฟล์ `.env.example` เป็น `.env`
   - ตั้งค่ารายละเอียดดังนี้:
     ```plaintext
     
     LINE_BOT_CHANNEL_ACCESS_TOKEN=your_line_channel_access_token
     LINE_BOT_CHANNEL_SECRET=your_line_channel_secret
     LINE_BOT_CHANNEL_ID=your_line_channel_id
     
     DB_CONNECTION=sqlsrv
     DB_HOST=localhost
     DB_PORT=1433
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_user
     DB_PASSWORD=your_database_password
     ```

6. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

7. **ตั้งค่าและ migrate ฐานข้อมูล**:
   ```bash
   php artisan migrate
   ```

8. **รันเซิร์ฟเวอร์**:
   ```bash
   php artisan serve
   ```

---

## การใช้งาน (Usage)

1. ผู้ใช้พิมพ์ **"แจ้งปัญหา"** เพื่อเริ่มต้นการแจ้งปัญหา
2. ระบบจะบันทึกปัญหาลงในฐานข้อมูลพร้อมแสดงข้อความตอบกลับ
3. ผู้ใช้พิมพ์ **"สิ้นสุด"** เพื่อยุติการแจ้งปัญหา

---

## โครงสร้างโฟลเดอร์ (Project Structure)

```plaintext
/project-root
|-- /app
|   |-- /Http
|       |-- Controllers
|           |-- LineController.php       # ควบคุมการรับ-ส่งข้อมูลจาก LINE
|   |-- /Models
|       |-- Ticket.php                   # จัดการการบันทึกข้อมูลแจ้งปัญหา
|
|-- /routes
|   |-- api.php                          # กำหนดเส้นทาง API
|
|-- /config
|   |-- database.php                     # ตั้งค่าฐานข้อมูล
|
|-- .env                                 # ข้อมูลการตั้งค่าตัวแปรลับ
|-- composer.json                        # รายการ dependencies ของ PHP
```

---

## การทดสอบ (Testing)

- ทดสอบการรับ-ส่งข้อความผ่าน LINE Developer Console โดยเชื่อมต่อ webhook URL ของโปรเจกต์
- ทดสอบการบันทึกข้อมูลลงในฐานข้อมูล SQL Server ว่ามีการสร้างข้อมูลการแจ้งปัญหาได้ถูกต้องหรือไม่

---

## ข้อมูลเพิ่มเติม

โปรเจกต์นี้พัฒนาโดยใช้ Laravel Framework และการเชื่อมต่อกับ LINE API เพื่ออำนวยความสะดวกในการแจ้งปัญหา

