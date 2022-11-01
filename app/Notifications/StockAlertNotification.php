<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Purchase;
use App\Models\User;

class StockAlertNotification extends Notification
{
    use Queueable;

    protected $purchase;
    protected $user;

    /* private $data; */

    /**
     * Create a new notification instance.
     *
     * @return void
     */
  /*   public function __construct($data)
    {
        $this->data = $data;
    } */
    public function __construct(Purchase $purchase, User $user)
    {
        $this->purchase = $purchase;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        /* return ['mail','database','broadcast']; */
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url(route('purchases.edit',$this->data->id));
        return (new MailMessage)
                    ->greeting('Bonjour !')
                    ->line('Le produit ci-dessous est en rupture de stock.')
                    ->line("Le nom du produit est ".$this->data->product ." est seulement ".$this->data->quantity." laissé en quantité")
                    ->line("Veuillez mettre à jour la quantité du produit ou effectuer un nouvel achat.")
                    ->action('Voir le produit', $url)
                    ->line('Merci !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
 /*    public function toArray($notifiable)
    {
        return [
            'product_name'=>$this->data->product,
            'quantity'=>$this->data->quantity,
            'image'=>$this->data->image,
        ];
    } */
    
    public function toArray($notifiable)
    {
        return [
            'purchaseId'=>$this->purchase->id,
            'product_name'=>$this->purchase->product,
            'quantity'=>$this->purchase->id,
            'expiry_date'=>$this->purchase->expiry_date,
            'image'=>$this->purchase->image,
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'product_name'=>$this->data->product,
            'quantity'=>$this->data->quantity,
        ]);
    }
}
