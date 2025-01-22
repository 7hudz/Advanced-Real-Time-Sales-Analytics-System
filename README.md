# Advanced Real-Time Sales Analytics System

This project is an advanced real-time sales analytics system designed to help businesses track and analyze sales data efficiently. It provides real-time insights into sales performance, allows for product promotion recommendations, and integrates external APIs for weather-related analytics.

## Features

- **Real-Time Sales Tracking**: View sales data in real time with up-to-date order management and analytics.
- **Product Promotion Recommendations**: Powered by AI to suggest products to promote based on recent sales data.
- **Sales Analytics**: Display detailed insights such as total sales, top-selling products, and revenue breakdown.
- **Weather Integration**: Displays weather data that could be used for correlating sales trends with weather patterns.
- **API Integration**: Communicates with external APIs like OpenAI for recommendations and weather services.

## Technologies Used

- **Frontend**: Vue.js 3, Axios
- **Backend**: PHP, Laravel 11
- **Database**: MySQL
- **AI Integration**: OpenAI API (GPT-4) for generating promotion recommendations
- **Real-Time Features**: WebSockets (Pusher) for live updates
- **Weather API**: External API for weather data

## Installation

### Prerequisites

- PHP 8.0 or higher
- Composer
- Node.js and npm
- MySQL
2.............................................
  # 2. Navigate to the project directory:
cd Advanced-Real-Time-Sales-Analytics-System

# 3. Install the required dependencies for the backend (Laravel):
composer install

# 4. Install the frontend dependencies (Vue.js):
npm install

# 5. Set up your .env file for both frontend and backend (API keys, database settings, etc.).



# 6. Start the Laravel server:
php artisan serve

# 7. Run the Vue.js development server:
npm run dev

### Backend Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/7hudz/Advanced-Real-Time-Sales-Analytics-System.git
   cd Advanced-Real-Time-Sales-Analytics-System
