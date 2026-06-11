<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'user_name',
        'action',
        'entity',
        'entity_id',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function record(string $action, string $description, string $entity = null, int $entityId = null): void
    {
        static::create([
            'user_id'    => Auth::id(),
            'user_name'  => Auth::check() ? Auth::user()->name : 'Sistema',
            'action'     => $action,
            'entity'     => $entity,
            'entity_id'  => $entityId,
            'description'=> $description,
            'ip_address' => Request::ip(),
        ]);
    }
}
