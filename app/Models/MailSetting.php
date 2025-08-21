<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = [
        'mailer', 'host', 'port', 'encryption', 'username', 'password', 'from_address', 'from_name'
    ];
}
