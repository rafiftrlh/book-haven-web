<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications; // Mengambil notifikasi pengguna yang sedang login

        return view('roles.customer.index', ['notifications' => $notifications]);
    }

    public function notificationUser($id)
    {
        $notifications = Notification::where('user_id', $id);

        return response()->json([
            'notification' => $notifications
        ]);
    }

    // Contoh controller untuk mengambil notifikasi pengguna
    public function UnreadNotif()
    {
        $user = Auth::user()->id;
        $notificationsUnread = Notification::where('user_id', $user)->where('status', 'Unread')->get();

        return response()->json($notificationsUnread);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->delete();
            return redirect()->back()->with('success', 'Notification deleted successfully.');
        }

        return redirect()->back()->with('error', 'Failed to delete notification.');
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);

        if ($notification) {
            $notification->status = 'Read';
            $notification->save();
            return redirect()->back()->with('success', 'Notification marked as read.');
        }

        return redirect()->back()->with('error', 'Failed to mark notification as read.');
    }
}
