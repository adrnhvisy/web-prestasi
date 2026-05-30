<?php

namespace App\Http\Controllers\Operasional;

use App\Http\Controllers\Controller;
use App\Models\Operasional\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user');

        // Filter pencarian berdasarkan aktivitas atau user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('aktivitas', 'LIKE', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%");
                });
        }

        // Filter berdasarkan modul
        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        $logs = $query->latest()->paginate(15)->withQueryString();
        $listModul = LogAktivitas::select('modul')->distinct()->pluck('modul');

        return view('operasional.log-aktivitas.index', compact('logs', 'listModul'));
    }

    public function show(string $id)
    {
        $log = LogAktivitas::with('user')->findOrFail($id);
        return view('operasional.log-aktivitas.show', compact('log'));
    }
}
