<?php

namespace App\Http\Controllers\API;

use App\Events\CreateUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->departments;
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'data' => $user,
            ], JsonResponse::HTTP_OK);

        } catch (ModelNotFoundException $e){
            return response()->json([
                'status' => JsonResponse::HTTP_FORBIDDEN, // ref_by onFail
                'message' => "Something went wrong, forbidden error",
            ],JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            event(new CreateUserEvent($user));

            DB::commit();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Record created successfully',
            ], JsonResponse::HTTP_OK);

        } catch(ModelNotFoundException $e){
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_FORBIDDEN,
                'message' => "Something went wrong, forbidden error",
            ],JsonResponse::HTTP_FORBIDDEN);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
