<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WorkComments extends Component
{
    public Work $work;
    public string $newComment = '';
    public ?int $replyingTo = null;
    public string $replyText = '';

    public function mount(Work $work)
    {
        $this->work = $work;
    }

    public function postComment()
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $this->validate([
            'newComment' => 'required|string|max:2000',
        ]);

        Comment::create([
            'work_id' => $this->work->id,
            'user_id' => Auth::id(),
            'parent_id' => null,
            'content' => $this->newComment,
        ]);

        $this->newComment = '';
    }

    public function startReply($commentId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }
        $this->replyingTo = $commentId;
        $this->replyText = '';
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
        $this->replyText = '';
    }

    public function postReply($parentId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $this->validate([
            'replyText' => 'required|string|max:2000',
        ]);

        Comment::create([
            'work_id' => $this->work->id,
            'user_id' => Auth::id(),
            'parent_id' => $parentId,
            'content' => $this->replyText,
        ]);

        $this->replyingTo = null;
        $this->replyText = '';
    }

    public function toggleLike($commentId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $existing = CommentLike::where('comment_id', $commentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            CommentLike::create([
                'comment_id' => $commentId,
                'user_id' => Auth::id(),
            ]);
        }
    }
    public function deleteComment($commentId)
    {
        if (!Auth::check()) {
            $this->dispatch('show-login-prompt');
            return;
        }

        $comment = Comment::findOrFail($commentId);

        $isCommentOwner = $comment->user_id === Auth::id();
        $isWorkOwner = $this->work->user_id === Auth::id();

        if (!$isCommentOwner && !$isWorkOwner) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        if ($comment->parent_id === null) {
            Comment::where('parent_id', $comment->id)->delete();
        }

        CommentLike::where('comment_id', $comment->id)->delete();
        $comment->delete();
    }

    public function render()
    {
        $comments = $this->work->comments()
            ->whereNull('parent_id')
            ->with(['user.creatorProfile', 'replies.user.creatorProfile'])
            ->withCount('likes')
            ->latest()
            ->get();

        return view('livewire.work-comments', [
            'comments' => $comments,
            'currentUserId' => Auth::id(),
            'allowComments' => $this->work->allow_comments,
        ]);
    }
}