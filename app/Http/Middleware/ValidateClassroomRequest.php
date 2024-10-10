<?php

namespace App\Http\Middleware;

use App\Models\Classroom;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateClassroomRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // DEBUGGING
//        $classroom = $request->route('classroom');
//               return response()->json([
//            'Request ID' => $request->route('classroom'),
//            'User ID' => auth()->id(),
//             'Users request' => $request->user()->classrooms,
//                   'Belongs to?' => $request->user()->classrooms->contains($classroom)
//
//        ]);

        $classroom = $request->route('classroom');

        if($classroom instanceof Classroom) {
            if(!$request->user()->classrooms->contains($classroom)) {
                return response()->json(['message' => 'You are not authorized to view this classroom'], 404);
            }
        }

        return $next($request);
    }
}
