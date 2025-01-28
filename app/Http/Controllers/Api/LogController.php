<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SystemLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::with('user')
            ->orderBy('created_at', 'desc');

        if ($request->has('filters')) {
            // Filtreleme işlemleri
            foreach ($request->filters as $filter) {
                $query->where($filter['field'], $filter['operator'], $filter['value']);
            }
        }

        return response()->json($query->paginate(15));
    }
} 