<?php
namespace App\Http\Controllers;
use App\Models\{Borrowing, Collection};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Storage};
use Illuminate\Validation\Rule;

class ProfileController extends Controller {
    public function __construct() { $this->middleware('auth'); }

    public function index() {
        $user = Auth::user();
        $borrowings  = Borrowing::with(['book','review'])->where('user_id',$user->id)->latest()->get();
        $collections = Collection::with('book')->where('user_id',$user->id)->get();
        $reviews     = $user->reviews()->with('book')->latest()->get();
        return view('profile', compact('user','borrowings','collections','reviews'));
    }
    public function update(Request $request) {
        $user = Auth::user();
        $request->validate([
            'username'      => ['required','string','max:50',Rule::unique('users')->ignore($user->id)],
            'email'         => ['required','email',Rule::unique('users')->ignore($user->id)],
            'alamat'        => ['nullable','string','max:255'],
            'profile_photo' => ['nullable','image','max:2048'],
            'password'      => ['nullable','confirmed','min:8'],
        ]);
        $user->username = $request->username;
        $user->email    = $request->email;
        $user->alamat   = $request->alamat;
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = $request->file('profile_photo')->store('profile_photos','public');
        }
        if ($request->filled('password')) $user->password = $request->password;
        $user->save();
        return redirect()->route('profile')->with('success','Profil berhasil diperbarui!');
    }
}
