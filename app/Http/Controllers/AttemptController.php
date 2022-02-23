<?php

namespace App\Http\Controllers;

use App\Models\BookTest\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttemptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'testId' => 'required',
        ]);
        /** @var Attempt $attempt */
        $attempt = Attempt::create([
            'test_id'    => $request->get('testId'),
            'user_id'    => Auth::id(),
            'start_date' => new \DateTime('now', new \DateTimeZone('Europe/Moscow')),
        ]);

        return response()->json(['attemptId' => $attempt->getId()]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Attempt $attempt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attempt $attempt)
    {
        $attempt->end_date = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $attempt->save();
    }

    public function getActiveAttemptId(Request $request)
    {
        $this->validate($request, [
            'testId' => 'required',
        ]);
        /** @var Attempt $attempt */
        $attempt = Attempt::query()
            ->where('test_id', $request->get('testId'))
            ->where('user_id', Auth::id())
            ->whereNull('end_date')
            ->get()
            ->first();

        return response()->json(['attemptId' => $attempt instanceof Attempt ? $attempt->getId() : 0]);

    }

    public function addAttemptScore(Request $request)
    {
        $this->validate($request, [
            'attemptId' => 'required',
            'point'     => 'required',
        ]);
        /** @var Attempt $attempt */
        $attempt = Attempt::findOrFail($request->get('attemptId'));
        if ($attempt instanceof Attempt)
        {
            $attempt->score = (int)$attempt->getScore() + (int)$request->get('point');
            $attempt->save();
        }
    }

    public function getAttemptScore(Request $request)
    {
        $this->validate($request, [
            'attemptId' => 'required',
        ]);
        /** @var Attempt $attempt */
        $attempt = Attempt::findOrFail($request->get('attemptId'));
        return response()->json(['score' => $attempt instanceof Attempt ? (int)$attempt->getScore() : 0]);
    }


}
