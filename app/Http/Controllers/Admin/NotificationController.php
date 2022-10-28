<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(){
        auth()->user()->unreadNotifications->markAsRead();
        $notification = notify('Notifications marquées comme lues');
        return back()->with($notification);
    }

    public function read(){
        auth()->user()->unreadNotifications->markAsRead();
        $notification = notify('Notification marquée comme lue');
        return back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->user()->notifications()->delete();
        $notification = notify('La notification a été supprimée');
        return back()->with($notification);
    }
}
