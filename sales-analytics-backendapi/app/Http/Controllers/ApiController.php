<?php
namespace App\Http\Controllers;
use App\Events\OrderAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    // Add a new order
    public function addOrder(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $price = $request->input('price');
        $date = $request->input('date');

        // Use PDO to insert the new order
        $pdo = DB::connection()->getPdo();
        $pdo->exec("INSERT INTO orders (product_id, quantity, price, date, created_at, updated_at)
                    VALUES ('$productId', $quantity, $price, '$date', NOW(), NOW())");

        // Get the inserted order data (optional)
        $order = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
            'date' => $date,
        ];

        // Broadcast the event
        event(new OrderAdded($order));

        return response()->json(['message' => 'Order added successfully'], 201);
    }

    // Get real-time analytics
    public function getAnalytics()
    {
        $pdo = DB::connection()->getPdo();

        // Total revenue
        $totalRevenue = $pdo->query(
            "SELECT SUM(price * quantity) AS revenue FROM orders"
        )->fetchColumn();

        // Top products by sales
        $topProducts = $pdo->query(
            "SELECT product_id, SUM(quantity) AS sold FROM orders GROUP BY product_id ORDER BY sold DESC LIMIT 5"
        )->fetchAll(\PDO::FETCH_ASSOC);

        // Revenue changes in the last 1 minute
        $revenueLastMinute = $pdo->query(
            "SELECT SUM(price * quantity) AS revenue FROM orders WHERE created_at >= NOW() - INTERVAL 1 MINUTE"
        )->fetchColumn();

        // Count of orders in the last 1 minute
        $recentOrders = $pdo->query(
            "SELECT COUNT(*) AS orders FROM orders WHERE created_at >= NOW() - INTERVAL 1 MINUTE"
        )->fetchColumn();

        return response()->json([
            'totalRevenue' => $totalRevenue,
            'topProducts' => $topProducts,
            'revenueLastMinute' => $revenueLastMinute,
            'recentOrders' => $recentOrders
        ]);
    }

    // Get product promotion recommendations from AI (e.g., ChatGPT/Gemini)
    public function getRecommendations()
{
    $pdo = DB::connection()->getPdo();

    // Fetch recent sales data (last 1 hour)
    $salesData = $pdo->query(
        "SELECT product_id, SUM(quantity) AS sold, SUM(price * quantity) AS total_sales FROM orders
         WHERE created_at >= NOW() - INTERVAL 1 HOUR GROUP BY product_id"
    )->fetchAll(\PDO::FETCH_ASSOC);

    // Prepare AI API request with the sales data
    $response = Http::post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-4', // Choose model for AI, adjust as needed
        'messages' => [
            ['role' => 'system', 'content' => 'You are a sales strategy assistant.'],
            ['role' => 'user', 'content' => 'Given the following sales data, which products should we promote for higher revenue? ' . json_encode($salesData)],
        ],
        

    ])->json();

    // Process the AI response content (string or text) into an array
    $content = $response['choices'][0]['message']['content'] ?? '';

    // Assuming the AI provides recommendations separated by line breaks, split them into an array
    $recommendations = explode("\n", $content);

    // Return AI recommendations response
    return response()->json([
        'recommendations' => array_filter($recommendations) // Remove empty values
    ]);
}


    // Get weather-based recommendations from external API (OpenWeather)
    public function getWeatherRecommendations()
    {
        // Call the OpenWeather API to get weather data for your location (e.g., Cairo)
        $weatherResponse = Http::get('http://api.openweathermap.org/data/2.5/weather', [
            'q' => 'Cairo,EG',
            'appid' => 'ab169b993c74157ab125eb631a036116',
            'units' => 'metric',
        ])->json();

        $temperature = $weatherResponse['main']['temp']; // Temperature in Celsius

        // Suggest promotion based on temperature
        $promotionSuggestion = $temperature > 25
            ? 'Promote cold drinks like sodas and iced beverages.'
            : 'Promote hot drinks like coffee and tea.';

        // Add dynamic pricing logic based on seasonality or temperature
        $pricingSuggestion = $temperature > 30
            ? 'Consider discounting cold beverages for higher sales during the summer.'
            : 'Consider adding extra toppings to hot drinks for a seasonal increase in revenue.';

        return response()->json([
            'promotionSuggestion' => $promotionSuggestion,
            'pricingSuggestion' => $pricingSuggestion,
            'temperature' => $temperature
        ]);
    }
}
