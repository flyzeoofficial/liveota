<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post as PostModel;

class Post extends Component
{
    public $title;
    public $content;
    public $slug;
    public function save()
    {
        $this->validate([
            'title' => 'required|min:3',
            'slug' => 'required|min:3',
            'content' => 'nullable',
        ]);

        PostModel::create([
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ]);

        // reset
        $this->reset(['title', 'content', 'slug']);

        session()->flash('success', 'Post created successfully!');
    }
    public function deletePost($id)
    {
        $post = PostModel::find($id);

        if ($post) {
            $post->delete();
            session()->flash('success', 'Post deleted successfully!');
        }
    }

    public function render()
    {
        $posts = PostModel::latest()->get();
        return view('livewire.post', [
            'posts' => $posts,
        ]);
    }
}
