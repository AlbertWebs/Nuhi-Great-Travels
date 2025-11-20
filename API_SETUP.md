# API Setup Guide

This document explains the API setup for the mobile booking app.

## API Routes

The API routes are defined in `routes/api.php` and are accessible at `/api/v1/`.

### Available Endpoints

1. **GET /api/v1/cars**
   - Get all car categories
   - Response: `{ success: true, data: [...] }`

2. **GET /api/v1/fleets**
   - Get all vehicles (fleets)
   - Query parameters:
     - `car_id` (optional): Filter by car category
     - `search` (optional): Search by vehicle name
   - Response: `{ success: true, data: [...] }`

3. **GET /api/v1/fleets/{id}**
   - Get single vehicle details
   - Response: `{ success: true, data: {...} }`

4. **POST /api/v1/calculate-price**
   - Calculate booking price
   - Body:
     ```json
     {
       "fleet_id": 1,
       "pickup_datetime": "2024-01-15 10:00:00",
       "dropoff_datetime": "2024-01-17 10:00:00"
     }
     ```
   - Response: `{ success: true, data: { days: 2, price_per_day: 50, total_price: 100 } }`

5. **POST /api/v1/bookings**
   - Create a new booking
   - Body:
     ```json
     {
       "fleet_id": 1,
       "pickup_datetime": "2024-01-15 10:00:00",
       "dropoff_datetime": "2024-01-17 10:00:00",
       "pickup_location": "123 Main St",
       "dropoff_location": "123 Main St",
       "full_name": "John Doe",
       "email": "john@example.com",
       "mobile": "+1234567890",
       "notes": "Optional notes"
     }
     ```
   - Response: `{ success: true, message: "Booking created successfully", data: {...} }`

6. **GET /api/v1/bookings/{id}**
   - Get booking details
   - Response: `{ success: true, data: {...} }`

## CORS Configuration

CORS middleware has been added to allow cross-origin requests from the mobile app. The middleware is automatically applied to all API routes.

## Testing the API

You can test the API using:

1. **Postman** or **Insomnia**
2. **cURL**:
   ```bash
   curl http://localhost:8000/api/v1/fleets
   ```
3. **Browser**: Visit `http://localhost:8000/api/v1/fleets` in your browser

## Mobile App Configuration

Update the `.env` file in the mobile app directory:

```
VITE_API_BASE_URL=http://your-laravel-app-url/api/v1
```

For local development:
```
VITE_API_BASE_URL=http://localhost:8000/api/v1
```

## Notes

- All API responses follow a consistent format with `success` and `data` fields
- Error responses include `success: false` and an `errors` or `message` field
- The API uses standard HTTP status codes (200, 201, 404, 422, etc.)
- Image URLs are returned as full URLs using `asset('storage/...')`

