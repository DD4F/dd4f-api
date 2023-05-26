<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *   description="Candidate model",
 *   title="Candidate",
 *   required={},
 *   @OA\Property(type="integer",description="id of Candidate",title="id",property="id",example="1",readOnly="true"),
 *   @OA\Property(type="dateTime",title="created_at",property="created_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 *   @OA\Property(type="dateTime",title="updated_at",property="updated_at",example="2022-07-04T02:41:42.336Z",readOnly="true"),
 * )
 * 
 * @OA\Schema(
 *   schema="Candidates",
 *   title="Candidates",
 *   @OA\Property(title="data",property="data",type="array",
 *     @OA\Items(type="object",ref="#/components/schemas/Candidate"),
 *   )
 * )
 * 
 * @OA\Schema(
 *   schema="CandidatesPaginated",
 *   title="Candidates paginated",
 *   allOf={
 *      @OA\Schema(ref="#/components/schemas/Pagination"),
 *      @OA\Schema(ref="#/components/schemas/Candidates"),
 *   }
 * )
 * 
 * @OA\Parameter(
 *      parameter="Candidate--id",
 *      in="path",
 *      name="__NAME_CLASS_VAR_PARAM_ID__",
 *      required=true,
 *      description="Id of Candidate",
 *      @OA\Schema(
 *          type="integer",
 *          example="1",
 *      )
 * ),
 */
 
class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'source',
        'owner',
        'created_by',
        'created_at',
    ];
    
    protected $casts = [];
}
