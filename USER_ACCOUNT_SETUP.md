# User Account System Setup

This document explains the user account system for the mobile booking app.

## Database Migration

Run the migration to add `api_token` and `phone` fields to users table:

```bash
php artisan migrate
```

## API Endpoints

### Authentication

1. **POST /api/v1/register**
   - Register a new user
   - Body: `{ name, email, password, phone? }`
   - Returns: `{ success, data: { user, token } }`

2. **POST /api/v1/login**
   - Login user
   - Body: `{ email, password }`
   - Returns: `{ success, data: { user, token } }`

3. **POST /api/v1/logout** (Protected)
   - Logout user
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, message }`

### User Profile

4. **GET /api/v1/profile** (Protected)
   - Get user profile with loyalty points
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, data: { id, name, email, phone, loyalty_points, total_spent } }`

5. **PUT /api/v1/profile** (Protected)
   - Update user profile
   - Headers: `Authorization: Bearer {token}`
   - Body: `{ name?, email?, phone?, password? }`
   - Returns: `{ success, data: { user } }`

### User Account Data

6. **GET /api/v1/my-bookings** (Protected)
   - Get user's bookings
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, data: [...] }`

7. **GET /api/v1/my-invoices** (Protected)
   - Get user's invoices
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, data: [...] }`

8. **GET /api/v1/my-payments** (Protected)
   - Get user's payment history
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, data: [...] }`

9. **GET /api/v1/loyalty-points** (Protected)
   - Get loyalty points and summary
   - Headers: `Authorization: Bearer {token}`
   - Returns: `{ success, data: { loyalty_points, total_spent, next_reward_at, total_bookings, completed_bookings } }`

## Authentication Flow

1. User registers/logs in → Receives API token
2. Token is stored in localStorage
3. Token is sent in `Authorization: Bearer {token}` header for protected routes
4. Token is validated by `ApiAuth` middleware

## Loyalty Points System

- **Earning**: 1 point per $10 spent on paid invoices
- **Calculation**: `floor(total_spent / 10)`
- Points are calculated in real-time from invoice data
- Points never expire

## Mobile App Pages

- `/login` - Login page
- `/register` - Registration page
- `/profile` - User profile dashboard
- `/profile/edit` - Edit profile
- `/my-bookings` - View all bookings
- `/my-invoices` - View all invoices
- `/my-payments` - Payment history
- `/loyalty` - Loyalty points dashboard

## Protected Routes

All account-related pages are protected and require authentication. Users are redirected to `/login` if not authenticated.

## Bottom Navigation

The bottom nav includes a Profile/Account icon that:
- Shows `/profile` if user is logged in
- Shows `/login` if user is not logged in

