<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserEnrollment;
use Yajra\DataTables\Facades\DataTables;

class AgentEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $agentCode = $request->get('agent_code', '');
        $agentInfo = null;

        if ($agentCode) {
            $agentInfo = UserEnrollment::select('agent_code', 'agent_name', 'enroller_code')
                ->where('agent_code', $agentCode)
                ->first();
        }

        return view('agent_enrollments.index', compact('agentCode', 'agentInfo'));
    }

    public function getEnrollments(Request $request)
    {
        $agentCode = $request->get('agent_code', '');

        $query = UserEnrollment::where('agent_code', $agentCode);

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return '<a class="view-btn" href="' . route('enrollments.preview', $row->id) . '"><i class="fa-solid fa-eye"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function preview($id)
    {
        $record = UserEnrollment::findOrFail($id);
        return view('agent_enrollments.preview', compact('record'));
    }
}
