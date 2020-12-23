<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\InvoiceTiket;
use Illuminate\Support\Facades\Crypt;

class TicketOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(InvoiceTiket $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url_verifikasi = url('tiket/')."/".Crypt::encryptString($this->invoice->it_kode_unik)."/verifikasi";
        return $this->from('pengempu.waterfall@gmail.com')
                ->view('email.tiket-order')->with([
                        'data' => $this->invoice,
                        'url_verifikasi'=>$url_verifikasi]);
    }
}
