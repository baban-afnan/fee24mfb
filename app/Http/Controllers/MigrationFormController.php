<?php

namespace App\Http\Controllers;

use App\Models\MigrationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MigrationFormController extends Controller
{
    public function store(Request $request)
    {
        // Check if user already submitted form
        $existingForm = MigrationForm::where('user_id', Auth::id())->latest()->first();

        if ($existingForm) {
            if ($existingForm->status === 'pending') {
                return back()->with('error', 'Your form is under review.');
            }
            if ($existingForm->status === 'resolved') {
                return back()->with('error', 'You are already an agent.');
            }
        }

        // Validate form
        $validated = $request->validate([
            'business_name'    => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'business_email'   => 'required|email|max:255',
            'state'            => 'required|string|max:100',
            'lga'              => 'required|string|max:100',
            'address'          => 'required|string|max:255',
            'nearest_bustop'   => 'required|string|max:255',
            'office_image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nepa_bill'        => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
            'cac_upload'       => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Generate reference number
        $validated['reference'] = 'MIG-' . strtoupper(uniqid());

        // Save uploaded files
        if ($request->hasFile('office_image')) {
            $validated['office_image'] = $request->file('office_image')->store('migration_files', 'public');
        }
        if ($request->hasFile('nepa_bill')) {
            $validated['nepa_bill'] = $request->file('nepa_bill')->store('migration_files', 'public');
        }
        if ($request->hasFile('cac_upload')) {
            $validated['cac_upload'] = $request->file('cac_upload')->store('migration_files', 'public');
        }

        // Attach user ID
        $validated['user_id'] = Auth::id();

        // Default status when submitting
        $validated['status'] = 'pending';

        // Store in DB
        MigrationForm::create($validated);

        return back()->with('success', 'Migration form submitted successfully! Your reference: ' . $validated['reference']);
    }
}
