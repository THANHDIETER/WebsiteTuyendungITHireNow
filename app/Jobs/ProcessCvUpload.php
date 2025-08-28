<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessCvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tempPath;       // ví dụ: "tmp/abc.pdf"
    protected $applicationId;

    public function __construct($tempPath, $applicationId)
    {
        $this->tempPath = $tempPath;
        $this->applicationId = $applicationId;
    }

    public function handle()
    {
        $sourcePath = storage_path('app/' . $this->tempPath);

        if (!file_exists($sourcePath)) {
            Log::error("CV temp file not found: " . $sourcePath);
            return;
        }

        $finalPath = 'cvs/' . uniqid() . '_' . basename($this->tempPath);

        try {
            // Copy nội dung từ file tạm sang disk public
            Storage::disk('public')->put($finalPath, file_get_contents($sourcePath));

            // Xóa file tạm
            @unlink($sourcePath);

            // Update JobApplication với đường dẫn final
            JobApplication::where('id', $this->applicationId)
                ->update(['image' => $finalPath]);

            Log::info("CV uploaded & DB updated", [
                'application_id' => $this->applicationId,
                'image' => $finalPath
            ]);
        } catch (\Throwable $e) {
            Log::error("ProcessCvUpload failed", [
                'application_id' => $this->applicationId,
                'error' => $e->getMessage()
            ]);
        }
    }
}
