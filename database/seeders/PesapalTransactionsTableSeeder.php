<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PesapalTransaction;
use Illuminate\Support\Str;

class PesapalTransactionsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            PesapalTransaction::create([
                'tracking_id' => Str::upper(Str::random(12)),
                'merchant_reference' => 'INV'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'payment_method' => 'M-Pesa',
                'payment_status' => ['completed', 'pending', 'failed'][array_rand(['completed', 'pending', 'failed'])],
                'payment_status_description' => 'Sample transaction',
                'amount' => rand(1000, 10000),
                'currency' => 'KES',
                'sender_phone' => '07'.rand(10000000, 99999999),
                'sender_name' => 'Client '.$i,
                'raw_response' => [
                    'note' => 'Sample API response data'
                ],
            ]);
        }
    }
}
