<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataForSeoRequest extends Model
{
    protected $table = 'dataforseo_requests';

    protected $fillable = [
        'endpoint', 'payload_hash', 'payload', 'response', 'http_status', 'api_status_code',
        'api_status_message', 'cost', 'status', 'research_run_id',
    ];

    protected $hidden = ['response'];

    protected function casts(): array
    {
        return ['payload' => 'array', 'cost' => 'decimal:4'];
    }

    public function decodedResponse(): ?array
    {
        return $this->response ? json_decode($this->response, true) : null;
    }
}
