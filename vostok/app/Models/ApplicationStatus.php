<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ApplicationStatus extends Pivot
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'id' => null,
            'lastname' => 'N/A',
            'firstname' => 'N/A',
            'middlename' => 'N/A',
            'email' => 'N/A',
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function old_status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Status::class, 'old_status_id', 'id');
    }
}
