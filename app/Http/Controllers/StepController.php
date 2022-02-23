<?php

namespace App\Http\Controllers;

use App\Models\BookTest\Answer;
use App\Models\BookTest\Description;
use App\Models\BookTest\Question;
use App\Models\BookTest\Step;
use Illuminate\Http\Request;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stepRequest = $request->get('step');
        if (!$stepRequest['title'] || !$stepRequest['code'] || !$request->get('testId'))
            throw new \Exception('Fields not valid');

        $stepFields = [
            'title'   => $stepRequest['title'],
            'code'    => $stepRequest['code'],
            'test_id' => $request->get('testId')
        ];
        if ($stepRequest['sort'])
            $stepFields['sort'] = $stepRequest['sort'];

        /** @var Step $test */
        $step = Step::create($stepFields);
        if ($step->getId())
        {
            $description = $stepRequest['description'];
            if ($description && $description['text'])
            {
                Description::create([
                    'text'    => $description['text'],
                    'step_id' => $step->getId()
                ]);
            }
            $question = $stepRequest['question'];
            $answers = $stepRequest['answers'];
            if ($question && $answers)
            {
                $questionFields = [
                    'title'   => $question['title'],
                    'step_id' => $step->getId(),
                ];
                /** @var Question $stepQuestion */
                $stepQuestion = Question::create($questionFields);

                foreach ($answers as $answer)
                {
                    $answerFields = [
                        'title'       => $answer['title'],
                        'question_id' => $stepQuestion->getId(),
                    ];
                    if ($answer['sort'])
                        $answerFields['sort'] = $answer['sort'];
                    if ($answer['point'])
                        $answerFields['point'] = $answer['point'];
                    if ($answer['next_step_id'])
                        $answerFields['next_step_id'] = $answer['next_step_id'];

                    Answer::create($answerFields);
                }
            }

        }

        return response()->json(['stepId' => $step->getId()]);
    }

    /**
     * Display the specified resource.
     *
     * @param   Step  $step
     * @return \Illuminate\Http\Response
     */
    public function show(Step $step)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   Step  $step
     * @return \Illuminate\Http\Response
     */
    public function edit(Step $step)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Step $step)
    {
        $stepFields = $step->getFillable();
        foreach ($request->toArray()['step'] as $fieldCode => $fieldValue)
        {
            if (in_array($fieldCode, $stepFields) && $step->{$fieldCode} != $fieldValue)
                $step->{$fieldCode} = $fieldValue;
            if ($fieldCode === 'description')
            {
                $description = Description::findOrFail($fieldValue['id']);
                $descriptionFields = $description->getFillable();
                foreach ($fieldValue as $descriptionFieldCode => $descriptionFieldValue)
                {
                    if (in_array($descriptionFieldCode, $descriptionFields) && $description->{$descriptionFieldCode} != $descriptionFieldValue)
                        $description->{$descriptionFieldCode} = $descriptionFieldValue;
                }
                $description->save();
            }

            if ($fieldCode === 'question')
            {
                $question = Question::findOrFail($fieldValue['id']);
                $questionFields = $question->getFillable();
                foreach ($fieldValue as $questionFieldCode => $questionFieldValue)
                {
                    if (in_array($questionFieldCode, $questionFields) && $question->{$questionFieldCode} != $questionFieldValue)
                        $question->{$questionFieldCode} = $questionFieldValue;
                }
                $question->save();
            }

            if ($fieldCode === 'answers')
            {
                foreach ($fieldValue as $stepAnswer)
                {
                    $answer = Answer::findOrFail($stepAnswer['id']);
                    $answerFields = $answer->getFillable();
                    foreach ($stepAnswer as $answerFieldCode => $answerFieldValue)
                    {
                        if (in_array($answerFieldCode, $answerFields) && $answer->{$answerFieldCode} != $answerFieldValue)
                            $answer->{$answerFieldCode} = $answerFieldValue;
                    }
                    $answer->save();
                }
            }
        }

        return response()->json(['testId' => $step->save() ? $step->getId() : 0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Step  $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step)
    {
        return response()->json(['isDeleted' => $step->delete() ? true : false]);
    }

}
