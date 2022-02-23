<?php

namespace App\Http\Controllers;

use App\Book;
use App\Models\BookTest;
use App\Models\BookTest\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tests = BookTest\Test::all();
        /** @var Test $test */
        foreach ($tests as $index => $test)
            $tests[$index]['book'] = $test->getBook();

        return view('book_admin.test.testCreator', ['tests' => json_encode($tests)]);
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
        $this->validate($request, [
            'name'     => 'required',
            'code'     => 'required',
            'book_id'  => 'required',
        ]);
        /** @var Test $test */
        $test = Test::create([
            'name'    => $request->get('name'),
            'code'    => $request->get('code'),
            'book_id' => $request->get('book_id'),
        ]);

        return response()->json(['testId' => $test->getId()]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param Request $request
     */
    public function show(int $id, Request $request)
    {
        $bookId = (int)$request->get('bookId');
        if ($id && $bookId)
        {
            try
            {
                /** @var BookTest\Test $test */
                $test = BookTest\Test::findOrFail($id);
                if ($test->getBook()->id === $bookId)
                    return  view('book.test', ['testId' => $id]);
            }
            catch (\Throwable $exception)
            {
            }
        }

        return redirect()->route('book.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        $steps = [];
        /**
         * @var  BookTest\Step $step
         */
        foreach ($test->getSteps() as $step)
            $steps[] = $step->getInfo()['step'];

        return view('book_admin.test.stepCreator', ['steps' => json_encode($steps), 'test' => $test]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $fields = $test->getFillable();
        foreach ($request->toArray() as $fieldCode => $fieldValue)
        {
            if (in_array($fieldCode, $fields) && $test->{$fieldCode} != $fieldValue)
                $test->{$fieldCode} = $fieldValue;
        }

        return response()->json(['testId' => $test->save() ? $test->getId() : 0]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        return response()->json(['isDeleted' => $test->delete() ? true : false]);
    }

    public function getTest(Request $request)
    {
        $result = [];
        try
        {
            /** @var BookTest\Test $test */
            $test = BookTest\Test::findOrFail($request->get('testId'));
            if (!$test instanceof BookTest\Test)
                throw new \Exception('Test not found');

            $result['id'] = $test->getId();
            /** @var BookTest\Step $firstStep */
            $firstStep = $test->steps()->orderBy('sort')->get()->first();
            if ($firstStep instanceof BookTest\Step)
            {
                $result['stepId'] = $firstStep->getId();
                $result['sort'] = $firstStep->getSort();
            }
        }
        catch (\Throwable $exception)
        {
            $result = [];
        }

        return response()->json($result);
    }

    public function getStep(Request $request)
    {
        $result = [];
        $step = null;
        try
        {
            switch ($request->get('mode'))
            {
                case 'step':
                    if ($request->get('stepId'))
                        $step = BookTest\Step::findOrFail((int)$request->get('stepId'));
                    break;
                case 'sort':
                    if ($request->get('currentSort'))
                        $step = BookTest\Step::getNextStepBySort((int)$request->get('currentSort'), (int)$request->get('testId'));
                        if (!$step instanceof BookTest\Step)
                            $result['noMoreSteps'] = true;
                    break;
                default:
                    break;
            }

            if ($step instanceof BookTest\Step)
            {
                $description =  $step->getDescription();
                $filesQuery = $step->files()->get();
                $files = [];
                if ($filesQuery)
                    /** @var BookTest\File $file */
                    foreach ($filesQuery as $file)
                        switch ($file->getMimeType())
                        {
                            case 'image/jpeg' :
                                $files['images'][] = [
                                    'id'    => $file->getId(),
                                    'path'  => Storage::url($file->getPath())
                                ];
                                break;
                            case 'sound':
                                $files['sounds'][] = 2;
                        }

                /** @var BookTest\Question $question */
                $question = $step->getQuestion();
                $answers = [];
                if ($question instanceof BookTest\Question)
                    $answers = $question->answers()->orderBy('sort')->get()->keyBy('id')->all();

                $result['step'] = [
                    'id'          => $step->getId(),
                    'sort'        => $step->getSort(),
                    'description' => $description instanceof BookTest\Description ? $description :  new \stdClass(),
                    'files'       => $files ? : new \stdClass(),
                    'question'    => $question instanceof BookTest\Question && $answers ? $question : new \stdClass(),
                    'answers'     => $question instanceof BookTest\Question && $answers ? $answers : [],
                ];

            }

        }
        catch (\Throwable $exception)
        {
            $result = [];
        }

        return response()->json($result);
    }

    public function getBook(Request $request)
    {
        $this->validate($request, [
            'testId' => 'required',
            'bookId' => 'required',
        ]);
        /** @var Test $test */
        $test = Test::findOrFail($request->get('testId'));
        $book = $test->getBook();
        return response()->json(['book' => $book instanceof Book ? $book : new \stdClass()]);
    }

}
