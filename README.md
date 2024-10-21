# Line Bot แจ้งปัญหา

Line Bot นี้ถูกพัฒนาขึ้นเพื่อให้ผู้ใช้งานสามารถแจ้งปัญหาผ่านทาง Line Message โดยระบบจะรับข้อมูลและบันทึกข้อมูลปัญหาลงในฐานข้อมูล SQL Server รวมถึงส่งข้อมูลปัญหากลับไปยัง email ที่ผูกกับ `line_id` ของผู้ใช้ได้

## คุณสมบัติหลัก (Features)

- รองรับการแจ้งปัญหาผ่าน Line Message API
- บันทึกข้อมูลปัญหาและรายละเอียดลงในฐานข้อมูล SQL Server โดยใช้ Sequelize ORM
- ส่งข้อมูลปัญหาผ่าน email (สำหรับการแจ้งเตือนผู้ดูแลระบบ)
- ใช้โครงสร้าง MVC แยกส่วน Controller, Model, และ Service เพื่อการดูแลและขยายโค้ดง่ายขึ้น

## การติดตั้ง (Installation)

ทำตามขั้นตอนดังต่อไปนี้เพื่อติดตั้งและรันโปรเจกต์:

1. **Clone repository**
    ```bash
    git clone https://github.com/username/repo-name.git
    cd repo-name
    ```

2. **ติดตั้ง dependencies**
    ```bash
    npm install
    ```

3. **สร้างไฟล์ `.env`** และกำหนดค่าต่อไปนี้:
    ```plaintext
    LINE_CHANNEL_ACCESS_TOKEN=your_line_channel_access_token
    LINE_CHANNEL_SECRET=your_line_channel_secret
    DB_HOST=localhost
    DB_NAME=your_database_name
    DB_USER=your_database_user
    DB_PASS=your_database_password
    PORT=3000
    EMAIL_SERVICE=your_email_service
    EMAIL_USER=your_email_address
    EMAIL_PASS=your_email_password
    ```

4. **ตั้งค่าและเชื่อมต่อฐานข้อมูล SQL Server**

   ตรวจสอบว่าฐานข้อมูล SQL Server ของคุณพร้อมทำงาน จากนั้นรันคำสั่งการ migrate:
    ```bash
    npx sequelize-cli db:migrate
    ```

5. **รันโปรเจกต์**
    ```bash
    npm start
    ```

## การใช้งาน (Usage)

เมื่อเซิร์ฟเวอร์เริ่มทำงานแล้ว คุณสามารถใช้ Line Bot เพื่อแจ้งปัญหาโดยการพิมพ์ข้อความดังนี้:

1. **พิมพ์คำว่า "แจ้งปัญหา"** ตามด้วยชื่อปัญหาที่ต้องการแจ้ง เช่น:
    ```
    แจ้งปัญหา ปัญหาที่ 1
    ```

2. **พิมพ์ "รายละเอียด"** ตามด้วยรายละเอียดของปัญหา:
    ```
    รายละเอียด รายละเอียด 1
    ```

3. **ระบบจะบันทึกข้อมูล** ลงในฐานข้อมูล และแจ้งกลับผู้ใช้ว่าได้รับข้อมูลเรียบร้อยแล้ว

## โครงสร้างโฟลเดอร์ (Project Structure)

```plaintext
/project-root
|-- /config
|   |-- database.js           # การตั้งค่าฐานข้อมูล
|
|-- /controllers
|   |-- issueController.js     # จัดการการรับและส่งข้อมูลจาก Line Bot
|
|-- /models
|   |-- issue.js               # Sequelize model สำหรับจัดการข้อมูลปัญหา
|
|-- /services
|   |-- issueService.js        # บริการจัดการธุรกิจลอจิก
|
|-- /routes
|   |-- issueRoutes.js         # กำหนดเส้นทาง (routes)
|
|-- app.js                     # จุดเริ่มต้นของแอปพลิเคชัน
|-- .env                       # ข้อมูลการตั้งค่า environment

````

### คำอธิบายเพิ่มเติม

- ในหัวข้อ **Features** จะอธิบายถึงคุณสมบัติหลักของระบบ เช่น การแจ้งปัญหาและบันทึกข้อมูลลงฐานข้อมูล
- ส่วน **Installation** มีรายละเอียดการตั้งค่าและติดตั้งโปรเจกต์ รวมถึงการสร้างไฟล์ `.env`
- **Project Structure** แสดงโครงสร้างของโฟลเดอร์เพื่อให้เข้าใจง่ายขึ้นว่าฟังก์ชันต่างๆ อยู่ที่ไหน
- **Usage** อธิบายขั้นตอนการใช้งาน Line Bot สำหรับผู้ใช้ใหม่

สามารถปรับแต่งเพิ่มเติมได้ตามความต้องการของโปรเจกต์ของคุณครับ!

