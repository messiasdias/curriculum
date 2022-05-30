<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\Page;
use App\Models\CaseItem;

class PageNavegation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pages_id',
        'items_id',
        'user_device_ip',
        'user_device_uuid',
        'user_device_platform',
        'user_device_type',
        'user_name',
        'user_email',
        'user_phone',
        'user_location_lat',
        'user_location_long',
        'views'
    ];

    public function page(){
        return $this->hasOne(Page::class, 'id', 'pages_id');
    }

    public function caseItem(){
        return $this->hasOne(CaseItem::class, 'id', 'items_id');
    }

    public function solution(){
        return $this->hasOne(Solution::class, 'id', 'items_id');
    }

    public static function getToday(string $uuid, int $pages_id, int $items_id = null) : ?self
    {
        return self::where('user_device_uuid', $uuid)
                    ->where('pages_id', $pages_id)
                    ->where('items_id', $items_id)
                    ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
                    ->first();
    }

    public static function hasToday(string $uuid, int $pages_id, int $items_id = null) : bool
    {
        return self::getToday($uuid, $pages_id, $items_id) !== null;
    }

    public static function getByUUID(string $uuid, int $pages_id, int $items_id = null) : ?self
    {
        return self::where('user_device_uuid', $uuid)
                    ->where('pages_id', $pages_id)
                    ->where('items_id', $items_id)
                    ->first();
    }

    public static function hasUUID(string $uuid, int $pages_id, int $items_id = null) : bool
    {
        return self::getByUUID($uuid, $pages_id, $items_id) !== null;
    }

    public static function generateUUID(int $pages_id, int $items_id = null) : string
    {
        $uuid = Hash::make(random_int(10000000, 99999999) + self::count() + $pages_id + ($items_id ?: 0));
        if(!self::hasUUID($uuid, $pages_id, $items_id)) return $uuid;
        return self::generateUUID($pages_id, $items_id);
    }
}
