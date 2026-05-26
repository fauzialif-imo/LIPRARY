<?php
namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    public function register(): void {}
    public function boot(): void {
        View::composer('layouts.admin', function ($view) {
            try { $proposalPending = \App\Models\BookProposal::pending()->count(); } catch (\Throwable $e) { $proposalPending = 0; }
            try { $myProposalPending = auth()->check() ? \App\Models\BookProposal::where('user_id',auth()->id())->pending()->count() : 0; } catch (\Throwable $e) { $myProposalPending = 0; }
            try { $pendingBorrowCount = \App\Models\Borrowing::whereIn('status',['pending','returning'])->count(); } catch (\Throwable $e) { $pendingBorrowCount = 0; }
            $view->with(compact('proposalPending','myProposalPending','pendingBorrowCount'));
        });
    }
}
