<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Http\Request;

class Contact extends Model
{
    use HasFactory;

    const STATUS = [ 
        'new' => 'Novo',
        'readed' => 'Lido',
        'resolved' => 'Resolvido'
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'state',
        'city',
        'subject',
        'message',
        'start',
        'archived',
        // 'status',
        // 'readed_by',
        // 'readed_at',
        // 'resolved_by',
        // 'resolved_at',
        // 'email_confirmed_at',
        // 'phone_confirmed_at',
    ];

    public function isReaded(){
        return $this->readed_at != null && in_array($this->status, ['readed', 'resolved']);
    }

    public function isResolved(){
        return $this->resolved_at != null && $this->status === 'resolved';
    }

    public function readedBy(){
        return $this->hasOne(User::class, 'readed_by');
    }

    public function resolvedBy(){
        return $this->hasOne(User::class, 'resolved_by');
    }

    public static function permitNewContactInInterval(string $columnName, string $columnValue, string $interval = "+1 hours") : bool
    {
        $last = self::where($columnName, "'{$columnValue}'")->orderBy('created_at', 'desc')->first();
        if($last) {
            return strtotime($interval, strtotime($last->created_at)) <= strtotime('now');
        }
        return true;
    }

    public static function validateRequest(Request $request, array &$data = ['errors' => null], array $params = [])
    {
        $validations = [
            "email" =>  ($request->email && !self::permitNewContactInInterval('email', $request->email)) , 
            "phone" => $request->phone && !self::permitNewContactInInterval('phone', $request->phone),
        ];

        if (!is_array($data['errors'])) $data['errors'] = [];

        foreach($validations as $key => $value) {
            if($value) {
                $columnName = isset($params[$key]) ? "o mesmo {$params[$key]}" : 'a mesma credencial';
                $data['errors'][$key] =  str_replace(':attribute', $columnName, 'Recebemos um contato com :attribute a pouco tempo.');
            }
        }

        $isValid = !in_array(true, array_values($validations));
        if (!$isValid) $data['errors']['form'] = 'Favor aguardar contato ou tente reenviar a mensagem dentro de alguns minutos.';

        return $isValid;
    }

    public function setStatus(string $status, int $users_id) : self
    {
        $status = strtolower($status);
        if (in_array($status, array_keys(self::STATUS))) {
            $this->status = $status; 
            if (in_array($status, ['readed', 'resolved'])) {
                $statusBy = "{$status}_by";
                $this->$statusBy = $users_id;
                $statusAt = "{$status}_by";
                $this->$statusAt = strtotime(date("Y-m-dH:i:s"));
            }
        }
        return $this;
    }

    public static function setEmailConfirmation(string $id) : bool
    {
        $contact = self::find($id);
        if ($contact instanceof self && !$contact->email_confirmed_at) {
            $contact->email_confirmed_at = date("Y-m-d H:i:s");
           return $contact->save();
        }
        return false;
    }

    public static function setPhoneConfirmation(string $id, int $code = null) : bool
    {
        $contact = self::find($id);
        //To-do add in contacts table the column code and compare $code with a code sent to phone number if is equals
        if ($contact instanceof self&& !$contact->phone_confirmed_at) {
            $contact->phone_confirmed_at = date("Y-m-d H:i:s");
           return $contact->save();
        }
        return false;
    }

    public static function formatBRPhoneNumber(string $phone) : string
    {
        $n = 0;
        return implode('', array_map(function($num) use(&$n) {
            $value = null;
            $caracters = [0 => "(", 2 => ") " ];
            if (in_array($n, array_keys($caracters))) $value .= $caracters[$n];
            $value .= $num;
            $n++;
            return $value;
        }, str_split($phone, 1)));
    }
}
