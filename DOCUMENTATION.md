# Smart Conversion Booster (Laravel Version) - Complete Guide

> **Note:** Yeh guide bilkul beginners ke liye hai. Agar aapko React/Node.js nahi aati, toh yeh Laravel (PHP) version perfect hai!

---

## Part 1: Local Computer Par Run Karna (Step by Step)

### Step 1: XAMPP Install Karein (Agar nahi hai toh)

1. **XAMPP Download karein:**
    - Website jayein: https://www.apachefriends.org/
    - "Download" button click karein (PHP 8.1 ya 8.2 wala version)
    - File download hone ke baad install karein

2. **XAMPP Install karna:**
    - Download ki file par double-click karein
    - Next, Next, Next... click karte jayein
    - Default settings rehne dein
    - Install hone ke baad Finish karein

3. **XAMPP Control Panel open karein:**
    - Windows Start menu mein "XAMPP" search karein
    - "XAMPP Control Panel" open karein
    - **Apache** aur **MySQL** ke saamne "Start" button click karein
    - Dono green ho jayenge

### Step 2: Project Files Rakhna

1. **XAMPP ke htdocs folder mein jayein:**
    - Usually: `C:\xampp\htdocs\`

2. **Naya folder banayein:**
    - `smart-conversion-booster` naam se folder banayein

3. **Saari files copy karein:**
    - Jo files maine di hain, un sab ko is folder mein copy karein

### Step 3: Composer Install Karein

1. **Composer download karein:**
    - https://getcomposer.org/download/ par jayein
    - "Composer-Setup.exe" download karein
    - Install karein (Next, Next...)

2. **Command Prompt open karein:**
    - Windows key press karein, "cmd" type karein
    - Command Prompt open karein

3. **Project folder mein jayein:**

    ```cmd
    cd C:\xampp\htdocs\smart-conversion-booster
    ```

4. **Composer install karein:**

    ```cmd
    composer install
    ```

    - Yeh thoda time lega (5-10 minutes)
    - Dependencies download hongi

### Step 4: Database Setup

1. **phpMyAdmin open karein:**
    - Browser mein jayein: `http://localhost/phpmyadmin`

2. **Nayi database banayein:**
    - Left side "New" click karein
    - Database name: `smart_conversion_booster`
    - "Create" button click karein

3. **.env file banayein:**
    - Project folder mein `.env.example` file hai
    - Usay copy karein aur rename karein to `.env`

4. **.env file edit karein:**

    ```env
    APP_NAME="Smart Conversion Booster"
    APP_URL=http://localhost:8000

    DB_DATABASE=smart_conversion_booster
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    - Baqi sab default rehne dein

### Step 5: App Key Generate Karein

1. **Command Prompt mein yeh command run karein:**
    ```cmd
    php artisan key:generate
    ```

### Step 6: Database Tables Banayein

1. **Command Prompt mein:**

    ```cmd
    php artisan migrate
    ```

    - Yeh saari tables bana dega

### Step 7: Server Start Karein

1. **Command Prompt mein:**

    ```cmd
    php artisan serve
    ```

    - Server start ho jayega
    - URL dikhayega: `http://127.0.0.1:8000`

2. **Browser mein open karein:**
    - `http://127.0.0.1:8000` par jayein
    - App ki welcome page dikhayegi

---

## Part 2: Shopify App Setup Karna

### Step 1: Shopify Partner Account Banayein

1. **Website jayein:** https://partners.shopify.com
2. **"Join now"** click karein
3. **Sign up karein:**
    - Name, email, password daalein
    - Email verify karein

### Step 2: Development Store Banayein

1. **Partner Dashboard mein:**
    - Left side "Stores" click karein
    - "Add store" → "Create development store"
    - Store name: `smart-conversion-test`
    - Password set karein
    - "Create" karein

2. **Test products add karein:**
    - Store mein jayein
    - "Products" → "Add product"
    - 2-3 test products add karein

### Step 3: App Create Karein

1. **Partner Dashboard mein:**
    - "Apps" click karein
    - "Create app" → "Create app manually"
    - App name: `Smart Conversion Booster`
    - "Create" karein

2. **Configuration mein jayein:**
    - "Configuration" tab click karein
    - **App URL:** `http://127.0.0.1:8000/auth`
    - **Allowed redirection URL(s):**
        - `http://127.0.0.1:8000/auth/callback`
    - "Save" karein

3. **API credentials copy karein:**
    - "API key" copy karein
    - "API secret key" copy karein (Reveal pehle click karein)

### Step 4: .env File Update Karein

Project ki `.env` file mein yeh add karein:

```env
SHOPIFY_API_KEY=apka_api_key_yahan_dalein
SHOPIFY_API_SECRET=apka_secret_key_yahan_dalein
SHOPIFY_APP_URL=http://127.0.0.1:8000
```

**Note:** Real keys daalein jo Shopify se copy ki hain!

---

## Part 3: App Test Karna

### Step 1: App Install Karein

1. **Browser mein jayein:**

    ```
    https://example-app.test/auth?shop=smart-conversion-test.myshopify.com
    ```

    - `apna-dev-store` ki jagah apna store name daalein

2. **Install app:**
    - Shopify permissions page ayega
    - "Install app" click karein

3. **Dashboard dikhayega:**
    - App ka dashboard open ho jayega
    - Saari features yahan se control hongi

### Step 2: Widgets Enable Karein

1. **Dashboard mein:**
    - Left side "Settings" click karein
    - Widgets enable karein
    - Settings save karein

2. **Store par check karein:**
    - Apna development store open karein
    - Kisi product page par jayein
    - Widgets dikhne chahiyein!

---

## Part 4: Cloud Par Upload Karna (Deployment)

### Option A: Shared Hosting Par Upload Karna (Easy)

#### Step 1: Hosting Account Banayein

1. **Hosting provider choose karein:**
    - Hostinger, Bluehost, ya Namecheap
    - PHP 8.1+ support honi chahiye

2. **Account banayein aur login karein**

#### Step 2: Database Banayein

1. **cPanel open karein**
2. **"MySQL Database Wizard" click karein**
3. **Database banayein:**
    - Database name: `smart_conversion_booster`
    - Username aur password banayein
    - Save karein (baad mein chahiye hoga)

#### Step 3: Files Upload Karein

1. **cPanel mein "File Manager" open karein**
2. **public_html folder mein jayein**
3. **Saari project files upload karein:**
    - Zip file banayein project ki
    - Upload karein
    - Extract karein

#### Step 4: .env File Update Karein

Hosting ke according `.env` update karein:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://apka-domain.com

DB_HOST=localhost
DB_DATABASE=apna_database_name
DB_USERNAME=apna_username
DB_PASSWORD=apna_password

SHOPIFY_API_KEY=apka_key
SHOPIFY_API_SECRET=apka_secret
SHOPIFY_APP_URL=https://apka-domain.com
```

#### Step 5: Composer Install on Server

1. **cPanel mein "Terminal" open karein**
2. **Project folder mein jayein:**
    ```bash
    cd /home/username/public_html
    ```
3. **Composer install:**
    ```bash
    composer install --no-dev --optimize-autoloader
    ```

#### Step 6: Migrations Run Karein

```bash
php artisan migrate --force
```

#### Step 7: Shopify App URLs Update Karein

1. **Partner Dashboard mein jayein**
2. **App Configuration update karein:**
    - App URL: `https://apka-domain.com/auth`
    - Redirect URL: `https://apka-domain.com/auth/callback`

---

### Option B: VPS/Cloud Server Par Upload (Advanced)

#### Step 1: Server Setup (Ubuntu)

1. **DigitalOcean, AWS, ya Vultr se server lein**
2. **SSH se connect karein:**

    ```bash
    ssh root@apna-server-ip
    ```

3. **LAMP stack install karein:**
    ```bash
    apt update
    apt install apache2 mysql-server php8.1 php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl composer -y
    ```

#### Step 2: Database Setup

```bash
mysql -u root -p
```

```sql
CREATE DATABASE smart_conversion_booster;
CREATE USER 'scb_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON smart_conversion_booster.* TO 'scb_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 3: Project Upload

```bash
cd /var/www
git clone https://github.com/apna-repo/smart-conversion-booster.git
cd smart-conversion-booster
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
```

#### Step 4: .env Configure

```bash
nano .env
```

Edit karke save karein (Ctrl+X, Y, Enter)

#### Step 5: Permissions Set Karein

```bash
chown -R www-data:www-data /var/www/smart-conversion-booster
chmod -R 755 /var/www/smart-conversion-booster
chmod -R 775 /var/www/smart-conversion-booster/storage
```

#### Step 6: Apache Virtual Host

```bash
nano /etc/apache2/sites-available/smart-conversion.conf
```

Add karein:

```apache
<VirtualHost *:80>
    ServerName apka-domain.com
    DocumentRoot /var/www/smart-conversion-booster/public

    <Directory /var/www/smart-conversion-booster/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Enable karein:

```bash
a2ensite smart-conversion
a2enmod rewrite
systemctl restart apache2
```

#### Step 7: SSL Certificate (HTTPS)

```bash
apt install certbot python3-certbot-apache
certbot --apache -d apka-domain.com
```

---

## Part 5: Common Issues & Solutions

### Issue 1: "404 Not Found" Error

**Solution:**

- `.htaccess` file check karein (public folder mein honi chahiye)
- Apache mod_rewrite enable hona chahiye

### Issue 2: "500 Server Error"

**Solution:**

- `.env` file mein `APP_DEBUG=true` karein
- Error message dekhein
- Storage folder permissions check karein (775 honi chahiye)

### Issue 3: Database Connection Error

**Solution:**

- `.env` mein database credentials check karein
- Database exist karti hai ya nahi check karein
- Username/password correct hain ya nahi

### Issue 4: Shopify OAuth Error

**Solution:**

- App URL aur Redirect URL correct hain ya nahi
- API keys correct hain ya nahi
- `SHOPIFY_APP_URL` mein HTTPS use karein (production mein)

---

## Part 6: Files Checklist

Ensure karein ke yeh saari files hain:

```
smart-conversion-booster/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SettingsController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── PopupController.php
│   │   │   ├── WidgetController.php
│   │   │   ├── ImportController.php
│   │   │   └── AnalyticsController.php
│   │   └── Middleware/
│   │       └── AuthShop.php
│   └── Models/
│       ├── Shop.php
│       ├── Settings.php
│       ├── Review.php
│       ├── Popup.php
│       └── Analytics.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000000_create_all_tables.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       ├── reviews.blade.php
│       ├── settings.blade.php
│       ├── popups.blade.php
│       ├── import.blade.php
│       └── welcome.blade.php
├── public/
│   └── widgets/
│       ├── main.js
│       ├── sales-popup.js
│       ├── reviews-widget.js
│       ├── social-proof.js
│       ├── trust-badges.js
│       ├── urgency.js
│       └── styles.css
├── routes/
│   └── web.php
├── .env.example
├── composer.json
└── DOCUMENTATION.md (yeh file)
```

---

## Support

Agar koi problem aye toh:

1. **Laravel Documentation:** https://laravel.com/docs
2. **Shopify Developer Docs:** https://shopify.dev
3. **Error message Google karein**

---

**Good Luck! 🚀**
