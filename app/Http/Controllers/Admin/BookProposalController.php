<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Book, BookProposal, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookProposalController extends Controller {
    public function index(Request $request) {
        $user = Auth::user();
        $query = BookProposal::with(['user','category','reviewer'])->latest();
        if ($user->role === 'petugas') $query->where('user_id',$user->id);
        if ($request->status && in_array($request->status,['pending','approved','rejected'])) $query->where('status',$request->status);
        if ($request->search) $query->where(fn($q)=>$q->where('title','like',"%{$request->search}%")->orWhere('author','like',"%{$request->search}%"));
        $proposals = $query->paginate(15)->withQueryString();
        $statsQuery = BookProposal::query();
        if ($user->role==='petugas') $statsQuery->where('user_id',$user->id);
        $stats = ['pending'=>(clone $statsQuery)->where('status','pending')->count(),'approved'=>(clone $statsQuery)->where('status','approved')->count(),'rejected'=>(clone $statsQuery)->where('status','rejected')->count()];
        $stats['total'] = $stats['pending']+$stats['approved']+$stats['rejected'];
        $categories = Category::active()->orderBy('name')->get();
        $isAdmin = $user->role === 'admin';
        return view('admin.proposals.index', compact('proposals','stats','categories','isAdmin'));
    }
    public function create() {
        $categories = Category::active()->orderBy('name')->get();
        return view('admin.proposals.create', compact('categories'));
    }
    public function store(Request $request) {
        $data = $request->validate(['title'=>'required|string|max:255','author'=>'required|string|max:255','publisher'=>'nullable|string|max:255','publish_year'=>'nullable|integer|min:1900|max:'.(date('Y')+1),'category_id'=>'required|exists:categories,id','isbn'=>'nullable|string|max:20','synopsis'=>'nullable|string','reason'=>'required|string|min:10|max:1000','cover'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $data['user_id'] = Auth::id(); $data['status'] = 'pending';
        if ($request->hasFile('cover')) $data['cover'] = $request->file('cover')->store('proposal-covers','public');
        BookProposal::create($data);
        return redirect()->route('admin.books.proposals.index')->with('success','Usulan buku berhasil dikirim!');
    }
    public function show(BookProposal $proposal) { $proposal->load(['user','category','reviewer']); return back(); }
    public function approve(Request $request, BookProposal $proposal) {
        abort_if($proposal->status!=='pending', 422, 'Sudah diproses.');
        $request->validate(['admin_note'=>'nullable|string|max:500','stock'=>'required|integer|min:1']);
        Book::create(['category_id'=>$proposal->category_id,'title'=>$proposal->title,'author'=>$proposal->author,'publisher'=>$proposal->publisher??'-','isbn'=>$proposal->isbn,'synopsis'=>$proposal->synopsis,'cover'=>$proposal->cover,'stock'=>$request->stock,'publish_date'=>$proposal->publish_year?"{$proposal->publish_year}-01-01":null]);
        $proposal->update(['status'=>'approved','reviewed_by'=>Auth::id(),'admin_note'=>$request->admin_note,'reviewed_at'=>now()]);
        return back()->with('success',"Usulan \"{$proposal->title}\" disetujui dan buku ditambahkan!");
    }
    public function reject(Request $request, BookProposal $proposal) {
        abort_if($proposal->status!=='pending', 422, 'Sudah diproses.');
        $request->validate(['admin_note'=>'required|string|min:5|max:500']);
        $proposal->update(['status'=>'rejected','reviewed_by'=>Auth::id(),'admin_note'=>$request->admin_note,'reviewed_at'=>now()]);
        return back()->with('success',"Usulan \"{$proposal->title}\" ditolak.");
    }
    public function destroy(BookProposal $proposal) {
        abort_if($proposal->user_id!==Auth::id(), 403, 'Bukan usulanmu.');
        abort_if($proposal->status!=='pending', 422, 'Hanya pending yang bisa ditarik.');
        $proposal->delete();
        return back()->with('success','Usulan berhasil ditarik.');
    }
}
