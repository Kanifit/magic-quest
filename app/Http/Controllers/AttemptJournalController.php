<?php

namespace App\Http\Controllers;

use App\Models\BookTest\Attempt;
use App\Models\BookTest\Journal;
use App\Models\BookTest\Step;
use Illuminate\Http\Request;

class AttemptJournalController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'attemptId' => 'required',
            'stepId'    => 'required',
        ]);

        /** @var Journal $attemptJournal */
        $attemptJournal = Journal::create([
            'attempt_id' => $request->get('attemptId'),
            'step_id'    => $request->get('stepId'),
        ]);

        return response()->json(['attemptJournalId' => $attemptJournal->getId()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Journal $journal
     *
     */
    public function update(Request $request, Journal $journal)
    {
        $this->validate($request, [
            'point'     => 'required',
        ]);
        $journal->point = $request->get('point');
        $journal->save();
    }

    public function getLastStep(Request $request)
    {
        $result = [];
        $this->validate($request, [
            'attemptId' => 'required',
        ]);
        /** @var Journal $stepAttempt */
        $stepAttempt = Journal::query()
            ->where('attempt_id', $request->get('attemptId'))
            ->orderBy('id', 'desc')
            ->get()
            ->first();
        if ($stepAttempt instanceof Journal)
        {
            if ($stepAttempt->getPoint())
                $result['stepId'] = 0;
            else
            {
                $step = $stepAttempt->getStep();
                if ($step instanceof Step)
                    $result = [
                        'stepId' => $step->getId(),
                        'sort'   => $step->getSort()
                    ];

            }
        }
        else
        {
            $attempt = Attempt::findOrFail($request->get('attemptId'));
            if ($attempt instanceof Attempt)
            {
                $test = $attempt->getTest();
                $firstStep = $test->steps()->orderBy('sort')->get()->first();
                if ($firstStep instanceof Step)
                {
                    $result = [
                        'stepId' => $firstStep->getId(),
                        'sort'   => $firstStep->getSort()
                    ];
                }
            }
        }


        return response()->json($result);

    }

    public function getStepAttempt(Request $request)
    {
        $this->validate($request, [
            'attemptId' => 'required',
            'stepId'    => 'required',
        ]);

        /** @var Journal $stepAttempt */
        $stepAttempt = Journal::query()
            ->where('attempt_id', $request->get('attemptId'))
            ->where('step_id', $request->get('stepId'))
            ->get()
            ->first();

        return response()->json(['attemptJournalId' => $stepAttempt instanceof Journal ? $stepAttempt->getId() : 0]);
    }

}
