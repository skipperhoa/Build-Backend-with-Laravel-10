<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
//use App\Events\PluginDownloadProgress;
class DownloadFileController extends Controller
{
    public function download(Request $request)
    {

        // lấy token trên header
        $token = $request->bearerToken();

        // set thư mục để lưu hình ảnh,...
        $folder = public_path('images/' . $request->file_name);

        Http::withToken($token)
            ->withOptions([
                'sink' => $folder,
                'progress' => function ($downloadTotal, $downloadedBytes) {
                    // chúng ta có thể viêt điều kiện event lắng nghe sự kiên
                    //event(new PluginDownloadProgress($downloadTotal, $downloadedBytes));
                }
            ])
            ->timeout(30) // set timeout 30s
            ->get($request->url); // download file


        return response()->json(['message' => 'Tải về hoàn tất!']);
    }
}
