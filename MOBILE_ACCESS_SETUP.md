# Mobile Access Setup Guide

## Problem
When accessing the mobile app from a mobile device using an IP address (e.g., `http://10.155.127.87:3000/`), the app cannot fetch data because it's trying to connect to `localhost:8000` which doesn't exist on the mobile device.

## Solution

### 1. Update API Configuration

The mobile app now automatically detects the API URL based on the current host. If you're accessing the app at `http://10.155.127.87:3000/`, it will automatically use `http://10.155.127.87:8000/api/v1` for API calls.

### 2. Start Laravel Server on Network Interface

Make sure your Laravel server is accessible from your mobile device:

```bash
# Instead of:
php artisan serve

# Use:
php artisan serve --host=0.0.0.0 --port=8000
```

Or specify your IP address:
```bash
php artisan serve --host=10.155.127.87 --port=8000
```

### 3. Configure Firewall

Make sure your firewall allows connections on port 8000:
- Windows: Allow port 8000 in Windows Firewall
- Linux: `sudo ufw allow 8000`

### 4. Manual Configuration (Optional)

If auto-detection doesn't work, create a `.env` file in the `mobile-booking-app` directory:

```env
VITE_API_BASE_URL=http://10.155.127.87:8000/api/v1
```

Then restart the Vite dev server:
```bash
npm run dev
```

### 5. Verify API is Accessible

Test from your mobile device's browser:
```
http://10.155.127.87:8000/api/v1/settings
```

You should see JSON data. If you get an error, check:
- Laravel server is running
- Server is bound to 0.0.0.0 (not just localhost)
- Firewall allows port 8000
- Both devices are on the same network

### 6. Debugging

Check the browser console on your mobile device for:
- API request URLs
- Network errors
- CORS errors

The app now logs all API requests and errors to the console for easier debugging.

## Quick Checklist

- [ ] Laravel server running with `--host=0.0.0.0`
- [ ] Firewall allows port 8000
- [ ] Mobile device can access `http://YOUR_IP:8000/api/v1/settings`
- [ ] Check browser console for API errors
- [ ] Verify both devices are on same network

