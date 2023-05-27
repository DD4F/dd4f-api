<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Laratrust;

class CandidateController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:candidates-read'])->only(['index', 'show']);
        $this->middleware(['permission:candidates-create'])->only('store');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $minutes = 1;

            if(auth()->user()->hasRole('agent')){
                $candidates = Cache::remember('agent-candidates', $minutes, function () {
                    return Candidate::whereNull('owner')->get();
                });
            }else{
                $candidates = Cache::remember('candidates', $minutes, function () {
                    return Candidate::all();
                });
            }
            
            $response = [
                'meta' => [
                    'success'   => true,
                    'errors'    => [],
                ],
                'data' => $candidates
            ];

            if(!$candidates){
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

        return response()->json($response,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        auth()->user()->isAbleTo('candidates-create');

        # dd(auth()->user()->isAbleTo('candidates-create'));

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
                return response()->json($response, 404);

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

        return response()->json($response,200);
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
