<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyWeight;
use Gemini;
use GeminiAPI\Resources\Parts\TextPart;
use Illuminate\Support\Facades\Log;
// use Gemini\Laravel\Facades\Gemini;




class BodyWeightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'weight' => 'required|numeric',
            'date' => 'nullable|date',
        ]);
        $userId = Auth::id();
        $date = $request->input('date') ?: date('Y-m-d');
        $existing = BodyWeight::where('user_id', $userId)->where('date', $date)->first();
        if ($existing) {
            $existing->update([
                'weight' => $request->input('weight'),
            ]);
        } else {
            BodyWeight::create([
                'user_id' => $userId,
                'date' => $date,
                'weight' => $request->input('weight'),
            ]);
        }
        return response()->json(['success' => true]);
    }
    public function getDate(Request $request)
    {
        $userId = Auth::id();
        // $endDate = $request->input('endDate') ?? date('Y-m-d');
        // $startDate = $request->input('startDate') ?? date('Y-m-d', strtotime('-2 weeks', strtotime($endDate)));
        $endDate = $request->input('endDate');
        $startDate = $request->input('startDate');
        $data = BodyWeight::where('user_id', $userId)->whereBetween('date', [$startDate, $endDate])->orderBy('date', 'ASC')->get();
        return response()->json($data);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    // public function getGeminiResponse(Request $request)
    // {
    //     // $api_key =getenv('GEMINI_API_KEY')
    //     Log::info("Entering getGeminiResponse function.");
    //     $api_key = env('GEMINI_API_KEY');
    //     if (empty($api_key)) {
    //         Log::error("GEMINI_API_KEY is not set in Heroku.");
    //         return response()->json(['error' => 'API key is missing.'], 500);
    //     } else {
    //         Log::info("GEMINI_API_KEY is set correctly.");
    //     }
        
    //     $client = new Client($api_key);
    //     $totalWeight = $request->input('weight');
    //     $prompt = "Tell me fun fact about{$totalWeight} kg in one sentence. Be precise.";
    //     try {
    //         // $response = $client->geminiPro()->generateContent(
    //         //     new TextPart($prompt),
    //         // );
    //         $response = $client->model('gemini-2.0-flash')->generateContent(
    //             new TextPart($prompt),
    //         );
            
    //         if (empty($response) || empty($response->text())) {
    //             Log::error("No response from Gemini API. Prompt: " . $prompt);
    //             return response()->json(['error' => 'No response from Gemini API.'], 500);
    //         }
    //         return response()->json(['response' => $response->text()]);
    //     } catch (Exception $e) {
    //         Log::error("Gemini API Error: " . $e->getMessage() . " Prompt: " . $prompt);
    //         return response()->json(['error' => 'Gemini API error: ' . $e->getMessage()], 500);
    //     }
    // }

    public function getGeminiResponse(Request $request)
    {
        Log::info("Entering getGeminiResponse function.");
        $api_key = env('GEMINI_API_KEY');
        $client = Gemini::client($api_key);
        // Log::info("Client {$client}");
        // Log::info("This is the API key {$api_key}");

        $totalWeight = $request->input('weight');
        $prompt = "Tell me fun fact about {$totalWeight} kg in one sentence. Double check your answer and if it is not accurate, reproduce it until it is accurate.";

        try {
            $response = $client->geminiFlash()->generateContent($prompt)->text();
            // $response = $client->generativeModel(model: 'models/gemini-2.0-flash')->generateContent('Hello');
            // $response = $client->ListModels();
            // Log::info($response->text());

            if (empty($response) || empty($response)) {
                Log::error("No response from Gemini API. Prompt: " . $prompt);
                return response()->json(['error' => 'No response from Gemini API'], 500);
            }

            return response()->json(['response' => $response]);

        } catch (Exception $e) {
            Log::error("Gemini API Error: " . $e->getMessage(), ['prompt' => $prompt]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}