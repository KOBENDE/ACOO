<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\LeaveRequestController;
use App\Notifications\LeaveRequestNotification;

class LeaveRequestController extends Controller
{
   
    public function create()
    {
        return view('create');
    }

//     public function index()
// {
    
//     $demandes = Demande::where('type', 'congé')->get();

//     return view('votre_vue', compact('demandes'));
// }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|string|max:255',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'nullable|date_format:H:i',
            'comment' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpeg,png|max:2048',
            'priority_level' => 'integer|min:0|max:5',
        ]);

        $attachmentPath = $request->hasFile('attachment')
            ? $request->file('attachment')->store('attachments', 'public')
            : null;

        $leaveRequest = LeaveRequest::create([
            'user_id' => Auth::id(),
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
            'comment' => $request->comment,
            'status' => 'pending',
            'attachment' => $attachmentPath,
            'priority_level' => $request->priority_level,
        ]);

        
        Notification::send(User::role('manager')->get(), new LeaveRequestNotification($leaveRequest));

        return redirect()->route('leave_requests.index')->with('success', 'Demande de congé soumise avec succès.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        $this->authorize('view', $leaveRequest);
        return view('leave_requests.show', compact('leaveRequest'));
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        $this->authorize('update', $leaveRequest);

        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'decision_date' => now(),
        ]);

        return redirect()->route('leave_requests.index')->with('success', 'Demande approuvée avec succès.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $this->authorize('update', $leaveRequest);

        $request->validate(['rejection_reason' => 'required|string']);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'decision_date' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->route('leave_requests.index')->with('success', 'Demande rejetée avec succès.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        $this->authorize('delete', $leaveRequest);

        if ($leaveRequest->attachment) {
            Storage::disk('public')->delete($leaveRequest->attachment);
        }

        $leaveRequest->delete();

        return redirect()->route('leave_requests.index')->with('success', 'Demande supprimée avec succès.');
    }
}
