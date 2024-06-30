<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TrackingController extends Controller
{
    public function index()
    {
        try {
            $response = Http::withHeaders([
                'key'=> '977ca5db4e4cafbd504ced6cc96428e1'
            ])->get('https://api.rajaongkir.com/starter/city');

            if ($response->successful()) {
                $cities = $response['rajaongkir']['results'];
            } else {
                $cities = [];
            }
        } catch (\Exception $e) {
            // Jika ada error, set $cities ke array kosong dan kirim pesan error ke view
            $cities = [];
            $error = 'Page error, please refresh the page.';
            return view('frontend.tracking.tracking', ['cities' => $cities, 'ongkir' => '', 'error' => $error]);
        }

        return view('frontend.tracking.tracking', ['cities' => $cities, 'ongkir' => '', 'error' => null]);
    }

    public function cekOngkir(Request $request)
    {
        try {
            $response = Http::withHeaders([
                'key'=> '977ca5db4e4cafbd504ced6cc96428e1'
            ])->get('https://api.rajaongkir.com/starter/city');

            if ($response->successful()) {
                $cities = $response['rajaongkir']['results'];
            } else {
                $cities = [];
            }

            $responseCost = Http::withHeaders([
                'key'=> '977ca5db4e4cafbd504ced6cc96428e1'
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $request->origin,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier,
            ]);

            if ($responseCost->successful()) {
                $ongkir = $responseCost['rajaongkir'];
            } else {
                $ongkir = '';
            }
        } catch (\Exception $e) {
            // Jika ada error, set $ongkir ke string kosong dan kirim pesan error ke view
            $ongkir = '';
            $cities = [];
            $error = 'Page error, please refresh the page.';
            return view('frontend.tracking.tracking', ['cities' => $cities, 'ongkir' => $ongkir, 'error' => $error]);
        }

        return view('frontend.tracking.tracking', ['cities' => $cities, 'ongkir' => $ongkir, 'error' => null]);
    }
}
