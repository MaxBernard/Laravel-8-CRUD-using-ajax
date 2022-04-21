<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
   * Indicates if the resource's collection keys should be preserved.
   *
   * @var bool
   */
  public $preserveKeys = true;

  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    // return parent::toArray($request);
    return [
      'id' => $this->id,
      'author_id' => $this->user_id,
      'year' => $this->year,
      'month' => $this->month,
      'category' => $this->category,
      'tag' => $this->tag,
      'cover_image' => $this->cover_image,
      'title' => $this->title,
      'content' => $this->content,
      'created_at'=> Carbon::parse($this->created_at)->format('D Y-m-d')
    ];
  }
}
