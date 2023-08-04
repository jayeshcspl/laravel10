<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Str;

class AvatarController extends Controller
{
    public function update(UpdateAvatarRequest $request) {
        $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
        //$path = $request->file('avatar')->store('avatars', 'public');
        //dd($path);
        if($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }
        auth()->user()->update(['avatar' => $path]);
        return back()->with('message', 'Aavatar is changed.');
    }
    public function generate_avatar(Request $request) {

        // $result = OpenAI::images()->create([
        //     'prompt' => 'Avatar image',
        //     'size'=>"256x256",
        //     'n'=>1
        // ]);
        // $contents = file_get_contents($result->data[0]->url);

        $contents = file_get_contents('https://www.w3schools.com/howto/img_avatar.png');
        $filename = Str::random(24);
        Storage::disk('public')->put("avatars/$filename.jpg", $contents);
        if($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }
        auth()->user()->update(['avatar' => "avatars/$filename.jpg"]);
        return back()->with('message', 'Aavatar is changed.');
    }
}
