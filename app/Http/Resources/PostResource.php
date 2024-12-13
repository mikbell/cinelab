<?php

namespace App\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
use App\Http\Resources\UserResource;
use App\Http\Resources\TopicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    private bool $withLikePermission = false;

    public function withLikePermission(): self
    {
        $this->withLikePermission = true;

        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'title' => $this->title,
            'content' => $this->content,
            'html' => $this->html,
            'likes_count' => $this->likes_count ? Number::abbreviate($this->likes_count) : 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'routes' => [
                'show' => $this->showRoute(),
                'edit' => $this->editRoute(),
            ],
            'can' => [
                'like' => $this->when($this->withLikePermission, fn() => $request->user()?->can('create', [Like::class, $this->resource])),
                'update' => $request->user()?->can('update', $this->resource),
                'delete' => $request->user()?->can('delete', $this->resource),
            ]
        ];
    }
}
