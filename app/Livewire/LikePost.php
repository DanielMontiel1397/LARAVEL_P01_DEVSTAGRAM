<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikePost extends Component
{

    public $post;
    public $isLike;
    public $likes;

    public function mount($post){
        $this->isLike = $post->checkLike(Auth::user());
        $this->likes = $post->likes->count();
    }

    public function like(){
        if( $this->post->checkLike(Auth::user() ) )
        {
            $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->isLike = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => Auth::user()->id
            ]);
            $this->isLike = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
