<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Creează o nouă instanță a clasei UserAccepted.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Construcția mesajului.
     *
     * @return $this
     */
    public function build()
{
    // Generăm o parolă aleatorie
    $password = Str::random(8); // De exemplu, o parolă de 8 caractere

    // Criptăm parola
    $hashedPassword = Hash::make($password);

    // Salvăm parola criptată în baza de date
    $this->user->password = $hashedPassword;
    $this->user->save();

    // Trimitem emailul cu parola
    return $this->subject('Contul tău a fost aprobat!')
                ->view('emails.user-accepted')
                ->with([
                    'link' => 'https://femm.ro/login',
                    'userName' => $this->user->manager_name,
                    'email' => $this->user->email,
                    'password' => $password
                ]);
}
}
