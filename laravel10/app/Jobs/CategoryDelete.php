<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Category;

class CategoryDelete implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $category;
    /**
     * Create a new job instance.
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $array = [];
        categoryChild($array,$this->category);
        foreach ($array as $value) {
            $category = Category::find($value);
            if ($category) {
                $category->delete();
            }
        }
    }
}
