<?php
namespace App\Services\Sbm;
use App\Models\sbmQuery;
use App\Http\Resources\sbmQueryResource;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class SbmService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = "https://apitest.sigortam360.com/QueryService.svc/Api/";
    }


    public function index($data)
    {
        $query = sbmQuery::query();
        if (! empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (! empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (! empty($data['sort_by']) && ! empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return sbmQueryResource::collection($query->paginate(10));
    }

       /**
     * Filter resources
     *
     * @return void
     */
    private function filter(Builder &$query, $filters)
    {
        $query->filter(Arr::except($filters, ['role']));

        if (! empty($filters['role'])) {
            $roleFilter = Filterable::parseFilter($filters['role']);
            if (! empty($roleFilter)) {
                if (is_array($roleFilter[2])) {
                    $query->whereIs(...$roleFilter[2]);
                } else {
                    $query->whereIs($roleFilter[2]);
                }
            }
        }

    }


    /**
     * Login isteği yapar ve session key döner
     */
    public function login($userKey, $password)
    {
        $url = $this->baseUrl . "ServiceLogin";

        $requestData = [
            "UserKey" => $userKey,
            "Password" => $password,
        ];

        $response = Http::post($url, $requestData);

        if ($response->successful()) {
            $sessionKey = $response->json()['SessionKey'] ?? null; // Dönen session key
            if ($sessionKey) {
                session(['session_key' => $sessionKey]); // Session'a kaydet
                return $sessionKey;
            }
        }

        // Hata durumunu yönet
        throw new \Exception("Login failed: " . $response->body());
    }

    public function memberLogin()
    {
        $url = $this->baseUrl . "MemberLogin";

        $requestData = [
                'Email' => 'C1858F4DC5FC4075885770E912E27BD4@zirvem.com.tr',
                'Password' => '3Hjvbqbc',
                'SessionKey' => session('session_key')
        ];

        $response = Http::post($url, $requestData);

        if ($response->successful()) {
            $memberId = $response->json()['Member']['MemberId'] ?? null; // Dönen session key
            $memberKey = $response->json()['MemberSecurityKey'] ?? null; // Dönen session key
            if ($memberId && $memberKey) {
                session(['MemberId' => $memberId]); // Session'a kaydet
                session(['MemberSecurityKey' => $memberKey]); // Session'a kaydet
                return  [
                    'status' => 'success',
                    'message' => 'Üye Giriş Başarılı',
                ];
            }
            return
                [
                    'status' => 'error',
                    'message' => 'Giriş Bilgileri Eksik',
                ];
        }

        // Hata durumunu yönet
        return
            [
                'status' => 'error',
                'message' => 'Giriş Başarısız',
            ];
    }

    /**
     * Genel API POST isteği, session key'i parametre olarak gönderir
     */
    public function postWithSessionKey($endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;

        $sessionKey = session('session_key'); // Laravel session'dan al
        $sessionID = session('MemberId'); // Session'a kaydet
        $sessionMemberKey = session('MemberSecurityKey'); // Session'a kaydet
        // Eğer session key yoksa, login yapılması gerektiğini belirtiyoruz
        if (!$sessionKey && !$sessionID && !$sessionMemberKey) {
            throw new \Exception("Session key is missing. Please log in first.");
        }

        $data['SessionKey'] = $sessionKey; // Session key'i POST verisine ekle
        $data['MemberSession'] = ['MemberId' => $sessionID, 'MemberSecurityKey' => $sessionMemberKey]; // Session key'i POST verisine ekle


        $response = Http::post($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        // Hata durumunu yönet
        throw new \Exception("API Request failed: " . $response->body());
    }


}
