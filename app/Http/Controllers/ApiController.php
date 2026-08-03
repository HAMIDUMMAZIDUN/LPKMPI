<?php

namespace App\Http\Controllers;

use App\Models\ApiLog;
use App\Models\TraineeEnrollment;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Verify certificate validity and fetch associated trainee details.
     */
    public function verifyCertificate(Request $request)
    {
        $nik = $request->query('nik');
        $certNumber = $request->query('number') ?? $request->query('certificate_number');

        if (empty($nik) || empty($certNumber)) {
            $responseStatus = 400;
            $responsePayload = [
                'status' => 'invalid',
                'message' => 'Parameter NIK dan nomor sertifikat wajib diisi.'
            ];

            // Log the API hit
            ApiLog::create([
                'endpoint' => $request->path(),
                'request_params' => $request->all(),
                'response_status' => $responseStatus,
                'ip_address' => $request->ip(),
            ]);

            return response()->json($responsePayload, $responseStatus)
                             ->header('Access-Control-Allow-Origin', '*');
        }

        // Search case-insensitive
        $trainee = TraineeEnrollment::with('trainingProgram')
            ->where('nik', $nik)
            ->whereRaw('LOWER(certificate_number) = ?', [strtolower($certNumber)])
            ->first();

        if ($trainee) {
            $responseStatus = 200;
            $responsePayload = [
                'status' => 'valid',
                'data' => [
                    'name' => $trainee->name,
                    'nik' => $trainee->nik,
                    'email' => $trainee->email,
                    'phone' => $trainee->phone,
                    'category' => $trainee->category,
                    'company' => $trainee->company,
                    'position' => $trainee->position,
                    'program' => $trainee->trainingProgram->title,
                    'certificate_number' => $trainee->certificate_number,
                    'education' => $trainee->education,
                    'status_kelulusan' => $trainee->status,
                ]
            ];
        } else {
            $responseStatus = 404;
            $responsePayload = [
                'status' => 'invalid',
                'message' => 'Sertifikat tidak terdaftar atau NIK peserta tidak cocok.'
            ];
        }

        // Log the API hit
        ApiLog::create([
            'endpoint' => $request->path(),
            'request_params' => $request->all(),
            'response_status' => $responseStatus,
            'ip_address' => $request->ip(),
        ]);

        return response()->json($responsePayload, $responseStatus)
                         ->header('Access-Control-Allow-Origin', '*');
    }
}
