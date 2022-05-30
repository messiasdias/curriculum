<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Slider extends Model
{
    use HasFactory;

    //Examples pre fixed,  dont remove
    const SLIDERS = [
        //slider
        [
            'id' => 1,
            'title' => "Agro<br> é Solar",
            'subtitle' => "
                Leve os benefícios<br>
                da energia solar para<br>
                sua propriedade.
            ",
            'images_id' => null,
            'link_url' => null,
            'link_text' => null,
            'broadcast_start' => null,
            'broadcast_end' => null,
            'type' => 'slider',
            'active' => true
        ],
        [
            'id' => 2,
            'title' => "Gere sua<br> própria<br> energia",
            'subtitle' => "Economize até 95%<br> na sua conta de luz",
            'images_id' => null,
            'link_url' => null,
            'link_text' => null,
            'broadcast_start' => null,
            'broadcast_end' => null,
            'type' => 'slider',
            'active' => true
        ],

        //box
        [
            'id' => 3,
            'title' => "95%<br> <span>de economia</span>",
            'subtitle' => null,
            'images_id' => null,
            'link_url' => null,
            'link_text' => "Saiba mais",
            'broadcast_start' => null,
            'broadcast_end' => null,
            'type' => 'box',
            'active' => true
        ],
        [
            'id' => 4,
            'title' => "<span>Retorno em</span><br> até 4 anos",
            'subtitle' => null,
            'images_id' => null,
            'link_url' => null,
            'link_text' => "Saiba mais",
            'broadcast_start' => null,
            'broadcast_end' => null,
            'type' => 'box',
            'active' => true
        ],
        [
            'id' => 5,
            'title' => "25 anos <span>de</span><br> garantia",
            'subtitle' => null,
            'images_id' => null,
            'link_url' => null,
            'link_text' => "Saiba mais",
            'broadcast_start' => null,
            'broadcast_end' => null,
            'type' => 'box',
            'active' => true
        ],
    ];

    const SLIDER_TYPES = [
        "slider" => 'Slider',
        "box" => 'Box'
    ];

    protected $table = 'sliders';

    public $type = 'slider';
    
    protected $fillable = [
        'title', 
        'subtitle', 
        'images_id', 
        'link_url', 
        'link_text', 
        'broadcast_start' ,
        'broadcast_end', 
        'type',
        'active'
    ];

    public function image()
    {
        return $this->hasOne(Image::class, 'id', 'images_id');
    }

    public function getTypeNameAttribute() : string
    {
       return self::SLIDER_TYPES[$this->type];
    }

    /**
    * Scope a query to only include sliders of a given in brodcasting.
    *
    * @param  Builder  $query
    * @return Builder
    */
    public function scopeBroadcasting(Builder $query, string $type = null) : Builder
    {
        $broadcasting = $query->with('image')
            ->where('active', true)
            ->orderBy('broadcast_end', 'asc')
            ->where('active', true)
            ->where('broadcast_start', "<=", date('Y-m-d H:i:s'))
            ->orWhere('broadcast_start', null)
            ->where('broadcast_end', ">=", date('Y-m-d H:i:s'))
            ->orWhere('broadcast_end', null);
            
       return ($type) ? $broadcasting->where('type', $type) : $broadcasting;;
    }

    /**
    * Scope a query to only include all sliders order by broadcast dates.
    *
    * @param  Builder  $query
    * @return Builder
    */
    public function scopeSliders(Builder $query) : Builder
    {
        $query = $query->with('image')
                ->orderBy('broadcast_start', 'desc')
                ->orderBy('broadcast_end', 'asc');

        $query->each(function ($slide) {$slide->append('isAired');});
        return $query;
    }

    /**
    * Scope a query to only include on slider.
    *
    * @param  Builder  $query
    * @return self
    */
    public function scopeSlide(Builder $query, int $id = null) : ?self
    {
        $slide =  $query->with('image')->find($id);
        return $slide ? $slide->append('isAired') : null;
    }


    public function getIsAiredAttribute() : string
    {
        $now = strtotime('now');
        $start = strtotime($this->broadcast_start);
        $end = strtotime($this->broadcast_end);
        $validations = [
            $this->broadcast_start === null && $this->broadcast_end === null,
            $start <= $now && $this->broadcast_end === null,
            $start <= $now && $end >= $now,
        ];
       return in_array(true, $validations);
    }
}
