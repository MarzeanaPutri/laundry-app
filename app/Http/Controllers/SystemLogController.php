<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SystemLog::with('user')->latest('created_at');

        if ($request->filled('action')) $query->where('action', $request->action);
        if ($request->filled('user_id')) $query->where('user_id', $request->user_id);

        $logs = $query->paginate(20)->withQueryString();
        return view('logs.index', compact('logs'));
    }
}
