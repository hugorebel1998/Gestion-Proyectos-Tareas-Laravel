<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    const PRIOPIDADES_TAREA = ['baja', 'media', 'alta'];
    const ESTATUS_TAREA     = ['inicio', 'en_curso', 'pausa', 'completada', 'cancelada'];

    protected $table = 'tareas';

    protected $fillable = [
        'proyecto_id',
        'usuario_id',
        'nombre',
        'descripcion',
        'prioridad',
        'estatus',
        'fecha_inicio',
        'fecha_termino',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    protected $hidden = [
        'updated_at',
    ];

    use HasUlids;

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    protected function descripcion(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value)
        );
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
}
