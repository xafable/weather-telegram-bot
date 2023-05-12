<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Laravel\Scout\Searchable;

class City extends Model
{
    use HasFactory,Searchable;

    #[SearchUsingPrefix(['title_ru','title_ua','title_en'])]
    public function toSearchableArray(): array
    {

        return [
            'id' => $this->id,
            'title_ua'=>$this->title_ua,
            'title_en'=>$this->title_en,
            'title_ru'=>$this->title_ru,
            'lon'=>$this->lon,
            'lat'=>$this->lat,
        ];
    }
}
