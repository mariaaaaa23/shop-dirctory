<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        $authorId = auth()->id(); //گرفتن شناسه نویسنده لاگین شده

        //کرفتن کامنت هایی که مربوط به محصولات این نویسنده هست
        $comments = Comment::whereHas('product', function($query) use ($authorId){
            $query->where('user_id', $authorId);
        })->with(['user', 'product'])->latest()->paginate(15);

        return view('author.comments.index', compact('comments'));

    }

    public function destroy(Comment $comment)
    {
        //برای اینکه مطمعن بشین این کامنت ها مربوط به همین محصول است
        if($comment->product->user_id !== auth()->id()){
            abort(403, 'شما اجازه دسترسی به این کامنت را ندارید');
        }

        $comment->delete();
        
        return redirect()->route('author.comments.index')->with('sucess', 'کامنت با موفقیت حذف شد');
    }
}
