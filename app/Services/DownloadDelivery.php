<?php

namespace App\Services;

use App\Models\Download;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DownloadDelivery
{
    public function deliver(int $downloadId, int $userId): Response
    {
        $download = Download::with('productFile')
            ->where('id', $downloadId)
            ->where('user_id', $userId)
            ->firstOr(fn () => throw new NotFoundHttpException);

        if (! $download->canDownload()) {
            throw new AccessDeniedHttpException(__('Лимит скачиваний исчерпан или ссылка истекла.'));
        }

        $file = $download->productFile;

        $download->increment('downloads_count');

        $disk = Storage::disk($file->disk);

        if (! $disk->exists($file->path)) {
            throw new NotFoundHttpException(__('Файл не найден.'));
        }

        return response(
            $disk->get($file->path),
            200,
            [
                'Content-Type' => $file->mime_type ?? 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="'.basename($file->path).'"',
                'Content-Length' => $file->size_bytes ?? $disk->size($file->path),
            ]
        );
    }
}
