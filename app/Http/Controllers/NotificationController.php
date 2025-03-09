<?php
// App/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(): RedirectResponse
    {
        $user = Auth::user();
        
        if ($user->is_admin == 0) {
            // Pour un employé normal
            $user->update(['has_response' => 0]);
        } else {
            // Pour un administrateur
            $user->update(['pending_requests' => 0]);
        }
        
        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }
}