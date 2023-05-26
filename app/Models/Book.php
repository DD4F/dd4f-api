<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *   description="Book model",
 *   title="Book",
 *   required={},
 *   @OA\Property(type="integer",description="id of Book",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="string",description="name of Book",title="name",property="name"),
 *   @OA\Property(type="string",description="source of Book",title="source",property="source"),
 *   @OA\Property(type="integer",description="owner of Book",title="owner",property="owner"),
 *   @OA\Property(type="integer",description="created_by of Book",title="created_by",property="created_by"),
 *   @OA\Property(type="dateTime",title="created_at",property="created_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 *   @OA\Property(type="dateTime",title="updated_at",property="updated_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 * )
 * 
 * @OA\Schema(
 *   schema="Books",
 *   title="Books",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Book"),
 *   )
 * )
 * 
 * @OA\Schema(
 *   schema="BooksPaginated",
 *   title="Books paginated",
 *   allOf={
 *      @OA\Schema(ref="#/components/schemas/Pagination"),
 *      @OA\Schema(ref="#/components/schemas/Books"),
 *   }
 * )
 * 
 * @OA\Parameter(
 *      parameter="Book--id",
 *      in="path",
 *      name="book_id",
 *      required=true,
 *      description="Id of Book",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
 
class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'source',
        'owner',
        'created_by',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'owner' => 'integer',,
                'created_by' => 'integer',
    ];
}
