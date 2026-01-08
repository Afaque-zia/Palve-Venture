# Palve Ventures - Real Estate Website

A modern, responsive real estate website for Palve Ventures - Trusted Property Consultants serving Palghar, Wada, and Boisar regions.

## 🏠 Project Overview

This is a complete real estate website with property listings, investor zone, buyer qualification forms, feasibility reports, and contact management.

## ✨ Features

- **Modern UI/UX**: Clean, light, and professional design
- **Fully Responsive**: Works perfectly on all devices
- **Property Listings**: Verified properties with detailed information
- **Investor Zone**: High ROI opportunities section
- **Buyer Qualification**: Interactive form to match buyers with properties
- **Feasibility Reports**: Free 1-page property analysis
- **Contact Forms**: Multiple forms with email integration
- **Smooth Animations**: Professional transitions and effects
- **SEO Friendly**: Optimized structure and content

## 🛠️ Technologies Used

- **HTML5**: Semantic markup
- **CSS3**: Modern styling with custom properties
- **Bootstrap 5.3**: Responsive framework
- **JavaScript (ES6)**: Interactive functionality
- **jQuery 3.7**: DOM manipulation and AJAX
- **PHP 7.4+**: Server-side form processing
- **SVG Graphics**: Scalable vector illustrations

## 📁 Project Structure

```
new realstate/
│
├── index.html              # Main website file
├── css/
│   └── style.css          # Custom styles
├── js/
│   └── script.js          # JavaScript functionality
├── php/
│   └── form-handler.php   # Form processing & email handling
└── README.md              # This file
```

## 🚀 Quick Start

### 1. Basic Setup (View Website Locally)

1. Download all files
2. Open `index.html` in your web browser
3. The website will work without a server for viewing

### 2. Full Setup with PHP (For Forms to Work)

#### Option A: Using XAMPP (Windows)

1. Install XAMPP from https://www.apachefriends.org/
2. Copy the project folder to `C:\xampp\htdocs\`
3. Start Apache from XAMPP Control Panel
4. Open browser and go to: `http://localhost/new realstate/`

#### Option B: Using PHP Built-in Server

1. Open terminal/command prompt in project folder
2. Run: `php -S localhost:8000`
3. Open browser and go to: `http://localhost:8000`

#### Option C: Using WAMP (Windows)

1. Install WAMP from http://www.wampserver.com/
2. Copy project to `C:\wamp64\www\`
3. Start WAMP
4. Visit: `http://localhost/new realstate/`

## 📧 Email Configuration

The forms are configured to send emails. You need to set up email settings:

### Step 1: Open `php/form-handler.php`

### Step 2: Update Email Address (Line 20)

```php
$toEmail = 'your-email@example.com'; // Replace with your actual email
```

### Step 3: Choose Email Method

#### Method A: Simple PHP mail() (Quick Setup)
- Works if your hosting supports mail()
- Just update the email address
- May go to spam

#### Method B: Gmail SMTP (Recommended - More Reliable)

1. **Install PHPMailer** (if using Gmail):
   ```bash
   composer require phpmailer/phpmailer
   ```

2. **Enable 2-Factor Authentication** on Gmail:
   - Go to your Google Account
   - Security > 2-Step Verification

3. **Generate App Password**:
   - Google Account > Security > 2-Step Verification
   - Scroll to "App passwords"
   - Select "Mail" and generate password
   - Copy the 16-character password

4. **Update PHP Settings** (Lines 28-31):
   ```php
   $smtpUsername = 'your-email@gmail.com';
   $smtpPassword = 'your-16-char-app-password';
   ```

5. **Uncomment Gmail Function** (Line 66-93)

## 🎨 Customization Guide

### Change Colors

Edit `css/style.css` (Lines 7-14):

```css
:root {
    --primary: #3B82F6;      /* Main blue color */
    --success: #10B981;      /* Green for success */
    --dark: #1F2937;         /* Dark text */
    /* Change these hex values to your preferred colors */
}
```

### Update Content

1. **Company Name**: Search and replace "Palve Ventures" in `index.html`
2. **Locations**: Change "Palghar | Wada | Boisar" to your areas
3. **Phone Numbers**: Update in footer (Line 670)
4. **Email Addresses**: Update in footer (Line 680)

### Add Real Images

Replace SVG placeholders with real images:

```html
<!-- Replace this: -->
<svg viewBox="0 0 300 200">...</svg>

<!-- With this: -->
<img src="images/property1.jpg" alt="Property Name">
```

### Modify Property Listings

Edit property cards in `index.html` (Lines 390-450):

```html
<h5 class="fw-semibold mb-2">Your Property Name</h5>
<p class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> Your Location</p>
```

## 📱 Pages & Sections

1. **Home** - Hero section with categories
2. **About Us** - Company story, vision, mission
3. **Services** - 4 service categories
4. **Investor Zone** - ROI opportunities
5. **Properties** - Verified property listings
6. **Buyer Qualification** - Property matching form
7. **Buying Process** - 4-step guide
8. **Feasibility Report** - Free analysis form
9. **Contact** - Contact information & form

## 🔧 Common Issues & Solutions

### Issue 1: Forms Not Sending Emails

**Solution**: 
- Check PHP is installed: `php -v`
- Verify email settings in `form-handler.php`
- Check spam folder
- Use Gmail SMTP method (more reliable)

### Issue 2: CSS/JS Not Loading

**Solution**:
- Check file paths are correct
- Use a web server (not just opening HTML file)
- Clear browser cache (Ctrl + F5)

### Issue 3: Bootstrap Not Loading

**Solution**:
- Check internet connection (uses CDN)
- Or download Bootstrap locally

## 🌐 Deployment

### Deploy to Shared Hosting (cPanel)

1. Login to cPanel
2. Go to File Manager
3. Upload all files to `public_html`
4. Configure email in PHP file
5. Visit your domain

### Deploy to Free Hosting

**InfinityFree / 000webhost**:
1. Create account
2. Upload files via FTP or File Manager
3. Configure database (if needed)
4. Update email settings

## 📊 Form Types

### 1. Contact Form
- Name, Email, Phone, Message
- Sends to your email
- Auto-response possible

### 2. Buyer Qualification
- Property Type, Budget, Location, Purpose
- Helps match buyers with properties

### 3. Feasibility Report
- Property details submission
- Promises 24-hour report delivery

## 🎯 SEO Tips

1. Add meta descriptions to `<head>`
2. Use proper heading hierarchy (H1, H2, H3)
3. Add alt text to images
4. Create sitemap.xml
5. Add Google Analytics

## 🔐 Security Best Practices

1. **Never commit passwords** to version control
2. **Use environment variables** for sensitive data
3. **Validate all inputs** on server-side
4. **Use HTTPS** in production
5. **Keep PHP updated**

## 📝 License

This project is created for Palve Ventures. All rights reserved.

## 👨‍💻 Developer Notes

- Website built with mobile-first approach
- All forms use AJAX for smooth submission
- jQuery handles all interactive elements
- Bootstrap grid system for layouts
- Custom CSS for unique styling

## 📞 Support

For any issues or customization requests:
- Email: developer@example.com
- Update location paths as needed
- Check browser console for errors (F12)

## 🚀 Future Enhancements

- [ ] Add property search functionality
- [ ] Integrate payment gateway
- [ ] Add admin panel
- [ ] Create property comparison feature
- [ ] Add virtual tour support
- [ ] WhatsApp integration
- [ ] Blog section
- [ ] Customer testimonials
- [ ] Live chat support

## 📄 Change Log

### Version 1.0.0 (January 2026)
- Initial release
- All core features implemented
- Responsive design complete
- Form handling with PHP
- Email integration ready

---

**Made with ❤️ for Palve Ventures**

*For the best experience, use Google Chrome or Firefox browser.*