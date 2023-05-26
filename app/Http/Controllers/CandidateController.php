<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CandidateController extends Controller
{

    public function __construct(){
        # $this->middleware(['permission:read_candidates'])->only('index');
        # $this->middleware(['permission:create_candidates'])->only('create');
        # $this->middleware(['permission:update_candidates'])->only('edit');
        # $this->middleware(['permission:delete_candidates'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $minutes = 5;
            $candidate = Cache::remember('candidates', $minutes, function () {
                return Candidate::all();
            });
            
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [],
                ],
                'data' => $candidate
            ];

            if(!$candidate){
                $response['data'] = ['No lead found'];
            }
        } catch (\Exception $e) {
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [
                        $e->getMessage()
                    ],
                ]
            ];
            return response()->json($response, 422);
        }

        return response()->json($response,201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            # Validamos la data
            $request['created_by'] = 1;
            $validated = $request->validate([
                'name'      => 'required',
                'source'    => 'required',
                'created_by' => 'required',
            ]);

            $candidate = Candidate::create($request->all());

            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [],
                ],
                'data' => $candidate
            ];

        } catch (\Exception $e) {
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [
                        $e->getMessage()
                    ],
                ]
            ];
            return response()->json($response, 422);
        }

        return response()->json($response,201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $minutes = 5;
            $candidate = Cache::remember('candidate:'.$id, $minutes, function () use ($id) {
                return Candidate::find($id);
            });
            
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [],
                ],
                'data' => $candidate
            ];

            if(!$candidate){
                $response['data'] = ['No lead found'];
            }
        } catch (\Exception $e) {
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [
                        $e->getMessage()
                    ],
                ]
            ];
            return response()->json($response, 422);
        }

        return response()->json($response,201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        //
    }
}
