<?php declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
            // $item->slug = $item->slug 
            // ?? str($item->{self::slugFrom()})
            //     ->append(time())
            //     ->slug();
        });
    }

    protected function makeSlug(): void
    {
        if (!$this->{$this->slugColumn()}) { // если нет колонки или именно слага у обьекта?
            $slug = $this->slugUnique(  // проверяем есть ли такой слаг который ниже сгенерировали
                str($this->{$this->slugFrom()})->slug()->value() // генерируем сам слаг из нужного поля
            );
            $this->{$this->slugColumn()} = $slug; // записываем значение слага в колонку
        }
    }
    
    protected static function slugColumn(): string
    {
        return 'slug';
    }

    protected static function slugFrom(): string
    {
        return 'title';
    }

    private function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExists($slug)) {
            $i++;

            $slug = $originalSlug.'-'.$i;
        }

        return $slug;
    }

    private function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }

    
}