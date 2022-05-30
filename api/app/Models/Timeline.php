<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;
use App\Models\CaseItem;
use App\Models\Categorie;
use App\Models\Solution;
use App\Models\Slider;
use App\Models\Page;
use App\Models\User;
use App\Models\PageNavegation;

class Timeline extends Model
{
    use HasFactory;

    private static function isNew(string $created = null, string $updated = null) : bool
    {
        return strtotime($updated) <= strtotime($created);
    }

    public static function getTimeline(string $start = null, string $end = null, int $lasts = 10) : array
    {
            $timeline = array_merge(
                self::getCases($start, $end, $lasts),
                self::getPages($start, $end, $lasts),
                self::getUsers($start, $end, $lasts),
                self::getSliders($start, $end, $lasts),
                self::getContacts($start, $end, $lasts),
                self::getSolutions($start, $end, $lasts),
                self::getCategories($start, $end, $lasts),
            );

            //order by created_at desc
            usort($timeline, function ($a, $b) {
                $a_value = strtotime($a['updated_at']);
                $b_value = strtotime($b['updated_at']);

                if ($a_value == $b_value) {
                    return 0;
                }
                return ($a_value > $b_value) ? -1 : 1;
            });

            return $timeline;
    }

    public static function getContacts(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($contact) {
            $isNew = self::isNew($contact['created_at'], $contact['updated_at']);
            $title = $isNew ? "Novo Contato Recebido" : "Contato Atualizado";
            $status = Contact::STATUS[$contact['status']];
            $text = $isNew ? 
                "Novo Contato Recebido de <b>{$contact['name']} - {$contact['email']}</b>, status atual <b>{$status}</b>" : 
                "Contato de <b>{$contact['name']}</b> atualizado status atual <b>{$status}</b>";

            return [
                "type" => 'contact',
                "title" => $title ,
                "text" => $text ,
                "created_at" => $contact['created_at'],
                "updated_at" => $contact['updated_at'],
                "is_new" => $isNew,
                "item" => $contact
            ];
        }, Contact::whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getCategories(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($categorie) {
            $isNew = self::isNew($categorie['created_at'], $categorie['updated_at']);
            $title = $isNew ? "Nova item de categoria" : "Item de categoria Atualizado";
            $text = $isNew ? 
                "Nova Categoria de case adicionada <b>{$categorie['name']}</b>" : 
                "Categoria de case <b>{$categorie['name']}</b> atualizada";

            return [
                "type" => 'categorie',
                "title" => $title,
                "text" => $text,
                "created_at" => $categorie['created_at'],
                "updated_at" => $categorie['updated_at'],
                "is_new" => $isNew,
                "item" => $categorie
            ];
        }, Categorie::with('image', 'cases')->whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getCases(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($case) {
            $isNew = self::isNew($case['created_at'], $case['updated_at']);
            $title = $isNew ? "Nova item de Case" : "Item de Case Atualizado";
            $text = $isNew ? 
                "Novo item de Case adicionado <b>{$case['name']}</b>" : 
                "Item de Case <b>{$case['name']}</b> atualizado";

            return [
                "type" => 'case',
                "title" => $title,
                "text" => $text,
                "created_at" => $case['created_at'],
                "updated_at" => $case['updated_at'],
                "is_new" => $isNew,
                "item" => $case
            ];
        }, CaseItem::with('image', 'galery', 'categorie')->whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getSolutions(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($solution) {
            $isNew = self::isNew($solution['created_at'], $solution['updated_at']);
            $title = $isNew ? "Nova item de Solução" : "Item de Solução Atualizado";
            $text = $isNew ? 
                "Novo item de Solução adicionado <b>{$solution['title']}</b>" : 
                "Item de Solução <b>{$solution['title']}</b> atualizado";

            return [
                "type" => 'solution',
                "title" => $title,
                "text" => $text,
                "created_at" => $solution['created_at'],
                "updated_at" => $solution['updated_at'],
                "is_new" => $isNew,
                "item" => $solution
            ];
        }, Solution::with('image')->whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getSliders(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($slide) {
            $isNew = self::isNew($slide['created_at'], $slide['updated_at']);
            $slideTitle = strip_tags($slide['title']);
            $title = $isNew ? "Novo item do Home Slider" : "Item do Slider Atualizado";
            $text = $isNew ? 
                "Novo item do Home Slider adicionado <b>{$slideTitle}</b>" : 
                "Item do Home Slider <b>{$slideTitle}</b> atualizado";

            return [
                "type" => 'slider',
                "title" => $title,
                "text" => $text,
                "created_at" => $slide['created_at'],
                "updated_at" => $slide['updated_at'],
                "is_new" => $isNew,
                "item" => $slide
            ];
        }, Slider::with('image')->whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getPages(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($page) {
            $isNew = self::isNew($page['created_at'], $page['updated_at']);
            $title = $isNew ? "Nova Página" : "Página Atualizada";
            $text = $isNew ? 
                "Nova Página adicionada <b>{$page['name']}</b>" : 
                "Página <b>{$page['name']}</b> atualizada";

            return [
                "type" => 'page',
                "title" => $title,
                "text" => $text,
                "created_at" => $page['created_at'],
                "updated_at" => $page['updated_at'],
                "is_new" => $isNew,
                "item" => $page
            ];
        }, Page::whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getUsers(string $start = null, string $end = null, int $lasts = 200) : array
    {
        return array_map(function ($user) {
            $isNew = self::isNew($user['created_at'], $user['updated_at']);
            $title = $isNew ? "Novo Usuário" : "Usuário Atualizado";
            $text = $isNew ? 
                "Novo Usuário adicionado <b>{$user['name']}</b>" : 
                "Usuário <b>{$user['name']}</b> atualizado";

            return [
                "type" => 'user',
                "text" => $text,
                "title" => $title,
                "created_at" => $user['created_at'],
                "updated_at" => $user['updated_at'],
                "is_new" => $isNew,
                "item" => $user
            ];
        }, User::with('image')->whereBetween('updated_at', [$start, $end])->latest()->take($lasts)->get()->toArray());
    }

    public static function getPageNavegations(string $start = null, string $end = null) : array
    {
        if (!$start) $start = date("Y-m-d 00:00:00");
        if (!$end) $end = date("Y-m-d 23:59:59");

        $pageNavegations = PageNavegation::with('page')->whereBetween('updated_at', [$start, $end]);
        
        $visitor_uuids = $unique_pages = $list = []; 
        $visited_pages = $unique_visitors = 0;

        foreach ($pageNavegations->get()->toArray() as $page) {
            if (!in_array($page['user_device_uuid'], $visitor_uuids)) {
                $visitor_uuids[] = $page['user_device_uuid'];
                $unique_visitors++;
            }

            $pageItem = [$page['pages_id'], $page['items_id']];
            if (!in_array($pageItem, $unique_pages)) {
                $unique_pages[] = $pageItem;
                $visited_pages++;
            }

            $navegation =  'nav'. $page['pages_id'] .'-'. ($page['items_id'] ?: 'items0');

            if (!isset($list[$navegation])) $list[$navegation] = $page;

            $list[$navegation]['desktop'] = $page['user_device_type'] === 'desktop' ? 1 : 0;
            $list[$navegation]['mobile'] = $page['user_device_type'] === 'mobile' ? 1 : 0;
            $list[$navegation]['tablet'] = $page['user_device_type'] === 'tablet' ? 1 : 0;

            $list[$navegation]['ips'] = [];
            $list[$navegation]['ips'][$page['id']] = $page['user_device_ip'];

            $list[$navegation]['locations'] = [];
            $list[$navegation]['locations'][$page['id']] = [
                "lat" => $page['user_location_lat'],
                "long" => $page['user_location_long']
            ];

            $list[$navegation]['platforms'] = [];
            $list[$navegation]['platforms'][$page['id']] = [
                'count' => 1,
                'name' => $page['user_device_platform']
            ];
            $list[$navegation]['platforms_total'][$page['user_device_platform']] = 1;

            $list[$navegation]['vendors'] = [];
            $list[$navegation]['vendors'][$page['id']] = [
                'count' => 1,
                'name' => $page['user_device_vendor']
            ];
            $list[$navegation]['vendors_total'][$page['user_device_vendor']] = 1;
        }

        $vendors_total = $platforms_total = $devices_total = [];
        foreach ($list as $page) {
            foreach ($page['vendors_total'] as $key => $vendor) {
                if (in_array($key, array_keys($vendors_total))) $vendors_total[$key] += $vendor;
                else $vendors_total[$key] = $vendor;
            }
            foreach ($page['platforms_total'] as $key => $platform) {
                if (in_array($key, array_keys($platforms_total))) $platforms_total[$key] += $platform;
                else $platforms_total[$key] = $platform;
            }
            foreach (['desktop', 'mobile', 'tablet'] as $key) {
                if (in_array($key, array_keys($devices_total))) $devices_total[$key] += $page[$key];
                else $devices_total[$key] = $page[$key];
            }
        }

        return [
            'navegations' =>  array_values($list),
            'statistics' => (object) [
                'views_total' => (int) $pageNavegations->sum('views'),
                'pages_total' => $visited_pages,
                'vendors_total' => $vendors_total,
                'platforms_total' => $platforms_total,
                'devices_total' => $devices_total,
                'unique_visitor_total' => $unique_visitors,
                'contacts_total' => Contact::whereBetween('created_at', [$start, $end])->count(),
            ]
        ];
    }

    public function getSlidersBroadcasting(string $start = null, string $end = null) : array
    {
        //
    }
}
