<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = config('services.whapi.token');
        $this->baseUrl = config('services.whapi.url', 'https://gate.whapi.cloud');
    }

    /**
     * Enviar mensaje de texto (Whapi.cloud)
     */
    public function sendMessage($to, $message)
    {
        // Limpiar el número y asegurarnos del formato (Whapi acepta el número directo)
        $phone = preg_replace('/[^0-9]/', '', $to);
        $url = "{$this->baseUrl}/messages/text";

        Log::info("Enviando Whapi a {$phone}...");

        try {
            $response = Http::withToken($this->token)->post($url, [
                'to' => $phone,
                'body' => $message
            ]);

            if ($response->successful()) {
                Log::info("Whapi enviado con éxito.");
                return ['success' => true, 'data' => $response->json()];
            }

            Log::error("Error Whapi API: " . $response->body());
            return ['success' => false, 'message' => $response->body()];

        } catch (\Exception $e) {
            Log::error("Excepción Whapi API: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Whapi usualmente no requiere templates forzados, pero mantenemos esta función
     * si se desea simular uno o usar una funcionalidad específica.
     */
    public function sendTemplateMessage($to, array $variables)
    {
        // En Whapi podemos simplemente formatear el texto aquí mismo
        // Suponiendo que las variables son [fecha, hora]
        $message = "Recordatorio: Tienes una cita el día {$variables['1']} a las {$variables['2']}.";
        return $this->sendMessage($to, $message);
    }
}
