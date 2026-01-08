# Email Configuration Guide

## Quick Setup for Palve Ventures Forms

Your website has 3 forms that send emails:
1. Contact Form
2. Buyer Qualification Form  
3. Feasibility Report Form

## 📧 Step-by-Step Email Setup

### Option 1: Simple Setup (5 Minutes)

This method works immediately but emails might go to spam.

1. Open `php/form-handler.php`
2. Find line 20 and change:
   ```php
   $toEmail = 'info@palveventures.com';
   ```
   Replace with YOUR email address where you want to receive form submissions.

3. That's it! Forms will now send to your email.

⚠️ **Note**: Emails may go to spam folder. Check spam regularly.

---

### Option 2: Gmail SMTP Setup (Recommended - 15 Minutes)

This method is more reliable and emails won't go to spam.

#### Step 1: Install PHPMailer

Open command prompt in your project folder and run:
```bash
composer require phpmailer/phpmailer
```

If you don't have Composer, download from: https://getcomposer.org/

#### Step 2: Enable Gmail Settings

1. Go to your Gmail account
2. Click on your profile picture → "Manage your Google Account"
3. Go to "Security" tab
4. Turn ON "2-Step Verification"
5. After enabling, find "App passwords" section
6. Generate a new app password:
   - Select App: "Mail"
   - Select Device: "Other" → Type "Palve Ventures Website"
   - Click "Generate"
   - **SAVE THE 16-CHARACTER PASSWORD** (shown once)

#### Step 3: Configure PHP File

Open `php/form-handler.php` and update:

```php
// Line 28-31: Update these
$smtpUsername = 'your-gmail@gmail.com';        // Your Gmail address
$smtpPassword = 'xxxx xxxx xxxx xxxx';         // 16-char app password from Step 2
```

```php
// Line 20: Where you want to receive emails
$toEmail = 'your-receiving-email@example.com';
```

#### Step 4: Activate Gmail Function

In `php/form-handler.php`:

1. Find line 66 (function `send_gmail`)
2. Remove the `/*` and `*/` around the function (uncomment it)
3. Find where `send_simple_email()` is called (lines 140, 190, 240)
4. Replace with:
   ```php
   if (send_gmail($toEmail, $subject, $emailBody, array(
       'host' => $smtpHost,
       'port' => $smtpPort,
       'username' => $smtpUsername,
       'password' => $smtpPassword,
       'from' => $smtpUsername
   ))) {
   ```

#### Step 5: Test

1. Start your PHP server
2. Fill out the contact form
3. Check your email inbox

---

## 🔍 Troubleshooting

### Problem: "Failed to send email"

**Solution 1**: Check your email address is correct in line 20

**Solution 2**: Make sure PHP is running (not just opening HTML file)
- Use XAMPP or run: `php -S localhost:8000`

**Solution 3**: Check spam folder

### Problem: Gmail SMTP not working

**Solution 1**: Verify 2-Step Verification is ON in Gmail

**Solution 2**: Make sure you used App Password (not regular password)

**Solution 3**: Check you uncommented the send_gmail function

**Solution 4**: Verify PHPMailer is installed:
```bash
composer show phpmailer/phpmailer
```

### Problem: Composer not found

**Download Composer**:
- Windows: https://getcomposer.org/Composer-Setup.exe
- After install, restart command prompt
- Run: `composer --version` to verify

---

## 📝 Testing Checklist

- [ ] Updated `$toEmail` with your email address
- [ ] Started PHP server (not just opened HTML)
- [ ] Filled and submitted contact form
- [ ] Checked inbox for email
- [ ] Checked spam folder if not in inbox
- [ ] Verified email content displays correctly

---

## 🎯 Email Format

Emails will arrive formatted with:
- **Subject Line**: "New Contact Form Submission - Palve Ventures"
- **Styled HTML**: Professional blue theme
- **All Form Data**: Organized and easy to read

### Sample Email Content:

```
New Contact Form Submission
─────────────────────────

Name: John Doe
Email: john@example.com
Phone: 9876543210
Message: I'm interested in a 3 BHK property in Palghar...
```

---

## 💡 Pro Tips

1. **Create a Dedicated Email**: Use `info@palveventures.com` or similar
2. **Set Up Auto-Reply**: Acknowledge form submissions instantly
3. **Use Filters**: Create Gmail filters to organize form submissions
4. **Monitor Regularly**: Check your email at least twice daily
5. **Test Monthly**: Send a test form to ensure everything works

---

## 🔐 Security Notes

⚠️ **NEVER share your app password**
⚠️ **Don't commit passwords to GitHub**
⚠️ **Use environment variables for sensitive data in production**

Good practice:
```php
$smtpPassword = getenv('GMAIL_APP_PASSWORD'); // Instead of hardcoding
```

---

## 📱 Form Notification Setup (Bonus)

Get instant notifications on your phone:

1. **Gmail App**: Enable notifications for your receiving email
2. **WhatsApp**: Use Zapier to connect Gmail → WhatsApp
3. **SMS**: Use Twilio API for SMS alerts (requires additional setup)

---

## 🆘 Still Having Issues?

If emails are still not working:

1. **Check PHP Error Log**:
   - Look in your server error logs
   - Or add to PHP file: `error_log("Debug: " . $message);`

2. **Test PHP mail() function**:
   ```php
   mail('your-email@example.com', 'Test', 'This is a test');
   ```

3. **Contact Your Hosting Provider**:
   - Ask if `mail()` function is enabled
   - Ask for SMTP details

4. **Use Alternative**:
   - SendGrid (free tier available)
   - Mailgun (free tier available)
   - AWS SES (requires AWS account)

---

## 📞 Need Help?

Contact your developer or hosting support with:
- Error messages from browser console (F12)
- PHP error logs
- Email configuration you tried

---

**Last Updated**: January 2026
**Version**: 1.0.0