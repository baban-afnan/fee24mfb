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
        $enrollmentCount = 0;

        if ($agentCode) {
            $agentInfo = UserEnrollment::select('agent_code', 'agent_name', 'enroller_code')
                ->where('agent_code', $agentCode)
                ->groupBy('agent_code', 'agent_name', 'enroller_code')
                ->first();

            // Get the enrollment count for this agent
            $enrollmentCount = UserEnrollment::where('agent_code', $agentCode)->count();
        }

        return view('agent_enrollments.index', compact('agentCode', 'agentInfo', 'enrollmentCount'));
    }

    public function getEnrollments(Request $request)
    {
        $agentCode = $request->get('agent_code', '');

        $query = UserEnrollment::where('agent_code', $agentCode)
            ->select([
                'id',
                'ticket_number',
                'bvn',
                'bms_import_id',
                'validation_status',
                'validation_message',
                'created_at'
            ]);

        return DataTables::of($query)
            ->addColumn('action', function ($row) {
                return '<a class="btn btn-sm btn-outline-primary view-btn" href="' . route('enrollments.preview', $row->id) . '">
                    <i class="fa-solid fa-eye me-1"></i> View
                </a>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d H:i:s');
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