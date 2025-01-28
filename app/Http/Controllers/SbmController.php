<?php

namespace App\Http\Controllers;

use App\Models\sbmQuery;
use Illuminate\Support\Facades\Http;
use App\Services\Sbm\SbmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\LogService;

class SbmController extends Controller
{

    protected $sbmService;

    public function __construct(SbmService $apiService)
    {
        $this->sbmService = $apiService;
    }

    public function index()
    {
        $this->login();
        $this->sbmService->memberLogin();
        $preInterrogation = $this->fetchData('PreInterrogation', '81A12345');
        $interrogation = $this->fetchData('InterrogationLimited', '81A12345',
            ['RequestTransactionId' => $preInterrogation->original['RequestTransactionId'],
                'QueryTransactionId' => $preInterrogation->original['QueryTransactionId']
            ]
        );

        $InterrogationImage = $this->fetchData('InterrogationImage', '81A12345', [
            'RequestTransactionId' => $interrogation->original['RequestTransactionId'],
            'PackageTransactionId' => $interrogation->original['PackageTransactionId'],
            'ImageSizeType' => 1,
            'ImageType' => 1,
        ]);
        //dd($preInterrogation->original['QueryTransactionId']);
        $image = $InterrogationImage->original['Image'];

        //$pngData = implode(array_map("chr", $image));
        // Diziyi binary string haline getir
        $imageBinary = implode('', array_map('chr', $image));

// Base64'e çevir
        $base64Image = base64_encode($imageBinary);

        return response()->json([
            'data' => 'data:image/png;base64,' . $base64Image,
        ]);
        /*    return response($pngData)
                ->header('Content-Type', 'image/png')
                ->header('Content-Disposition', 'inline; filename="image.png"');*/
    }

    /**
     * Kullanıcı oturumu açar
     */
    public function login()
    {
        try {
            $userKey = "edcc92bb-5e03-4e53-a812-ddfd53289b1b";
            $password = "61d1055e-e053-4e52-98ff-952031108c34";

            $sessionKey = $this->sbmService->login($userKey, $password);

            return response()->json([
                'message' => 'Login successful',
                'session_key' => $sessionKey,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * API'den veri çeker
     */
    public function fetchData($endpoint, $plate, $extraData = [])
    {
        if (empty($plate) || empty($endpoint))
        {
            return response()->json([
                'message' => 'Data fetch failed',
                'error' => "Veriler boş bırakılamaz.",
            ], 400);
        }

        try
        {
            $data = [
                'PlateCityCode' => substr($plate, 0, 2),
                'PlateNo' => substr($plate, 2),
                'QueryType' => '1',
            ];
            if (!empty($extraData)) {
                $data = array_merge($data, $extraData);
            }

            $response = $this->sbmService->postWithSessionKey($endpoint, $data);

            return response()->json($response);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'message' => 'Data fetch failed',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    private function checkPlateHistory($plate)
    {
        $checkHistory = sbmQuery::where('plate', $plate)->orderBy('ended_date', 'desc')->first();
        if ($checkHistory)
        {
            return [
                'status' => 'Has',
                'plate' => $checkHistory->plate,
                'location' => Storage::url($checkHistory->location),
                'date' => \Carbon\Carbon::parse($checkHistory->ended_date)->format('Y-m-d H:i:s'),
                'data' => 'data:image/png;base64,' . base64_encode(Storage::get($checkHistory->location)),
            ];
        }
        return [
            'status' => 'Not',
        ];
    }

    public function plateQuery(Request $request): \Illuminate\Http\JsonResponse
    {
        $checkPlate = $this->checkPlateHistory($request->plate);
        if ($checkPlate['status'] === 'Has')
        {
            return response()->json($checkPlate);
        }

        $plate = $request->plate;
        $this->login();
        $member = $this->sbmService->memberLogin();
        if ($member['status'] === 'error')
        {
            return response()->json($member);
        }

        $preInterrogation = $this->fetchData('PreInterrogation', $plate);

        $interrogation = $this->fetchData('InterrogationLimited', $plate,
            ['RequestTransactionId' => $preInterrogation->original['RequestTransactionId'],
                'QueryTransactionId' => $preInterrogation->original['QueryTransactionId']
            ]
        );

        $InterrogationImage = $this->fetchData('InterrogationImage', $plate, [
            'RequestTransactionId' => $interrogation->original['RequestTransactionId'],
            'PackageTransactionId' => $interrogation->original['PackageTransactionId'],
            'ImageSizeType' => 1,
            'ImageType' => 1,
        ]);

        //dd($preInterrogation->original['QueryTransactionId']);
        $image = $InterrogationImage->original['Image'];

        // Diziyi binary string haline getir
        $imageBinary = implode('', array_map('chr', $image));

        // Base64'e çevir
        $base64Image = base64_encode($imageBinary);
        // Dosyayı storage dizinine kaydet
        $fileName = time() . '-' . $plate . '.png';
        $filePath = 'images/' . $plate . '/' . $fileName;

        // Dosyayı kaydet
        Storage::put($filePath, $imageBinary);

        try {
            sbmQuery::insert([
                'location' => $filePath,
                'user_id' => auth()->id(),
                'plate' => $plate,
                'ended_date' => now(),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'message' => 'Database insert failed',
            ], 500);
        }

        LogService::log(
            'query',
            'sbm',
            'Plaka sorgusu yapıldı',
            null,
            ['plate' => $plate]
        );

        return response()->json([
            'status' => 'first',
            'data' => 'data:image/png;base64,' . $base64Image,
            'location' => Storage::url($filePath),
        ]);
    }
    
    public function oldQuery(Request $request)
    {
            $this->authorize('list', sbmQuery::class);
    
            return $this->sbmService->index($request->all());
        
    }

    public function fetchDataByPlate(Request $request)
    {
        $plate = $request->plate;
        $this->login();
        $member = $this->sbmService->memberLogin();
        if ($member['status'] === 'error')
        {
            return response()->json($member);
        }

        $preInterrogation = $this->fetchData('PreInterrogation', $plate);

        $interrogation = $this->fetchData('InterrogationLimited', $plate,
            ['RequestTransactionId' => $preInterrogation->original['RequestTransactionId'],
                'QueryTransactionId' => $preInterrogation->original['QueryTransactionId']
            ]
        );

        $InterrogationImage = $this->fetchData('InterrogationImage', $plate, [
            'RequestTransactionId' => $interrogation->original['RequestTransactionId'],
            'PackageTransactionId' => $interrogation->original['PackageTransactionId'],
            'ImageSizeType' => 1,
            'ImageType' => 1,
        ]);

        //dd($preInterrogation->original['QueryTransactionId']);
        $image = $InterrogationImage->original['Image'];

        // Diziyi binary string haline getir
        $imageBinary = implode('', array_map('chr', $image));

        // Base64'e çevir
        $base64Image = base64_encode($imageBinary);
        // Dosyayı storage dizinine kaydet
        $fileName = time() . '-' . $plate . '.png';
        $filePath = 'images/' . $plate . '/' . $fileName;

        // Dosyayı kaydet
        Storage::put($filePath, $imageBinary);



        try {
            sbmQuery::insert([
                'location' => $filePath,
                'user_id' => auth()->id(),
                'plate' => $plate,
                'ended_date' => now(),
            ]);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return response()->json([
                'message' => 'Database insert failed',
            ], 500);
        }

        LogService::log(
            'query',
            'sbm',
            'Plaka sorgusu yapıldı',
            null,
            ['plate' => $plate]
        );

        return response()->json([
            'status' => 'last',
            'data' => 'data:image/png;base64,' . $base64Image,
            'date' => date('Y-m-d H:i:s', strtotime('now')),
            'location' => Storage::url($filePath),
        ]);
    }

}
