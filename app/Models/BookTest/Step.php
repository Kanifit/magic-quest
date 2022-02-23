<?php

namespace App\Models\BookTest;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Step extends Model
{
    protected $fillable = [
        'id',
        'title',
        'code',
        'test_id',
        'sort',
    ];

    public function getId() : int
    {
        return $this->id;
    }

    public function test()
    {
        return $this->belongsTo('App\Models\BookTest\Test');
    }

    public function getTest()
    {
        return $this->test;
    }

    public function question()
    {
        return $this->hasOne('App\Models\BookTest\Question');
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function description()
    {
        return $this->hasOne('App\Models\BookTest\Description');
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function files()
    {
        return $this->hasMany('App\Models\BookTest\File');
    }

    public function getFiles()
    {
        return $this->files;
    }

    public function journal()
    {
        return $this->hasMany('App\Models\BookTest\Journal');
    }

    public function getAttemptJournal()
    {
        return $this->journals;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getCode() : string
    {
        return $this->code;
    }

    public function getSort() : int
    {
        return $this->sort;
    }

    public static function getNextStepBySort(int $sort, int $testId) : ?Step
    {
        $step = Step::query()
            ->where('sort', '>', $sort)
            ->where('test_id', $testId)
            ->orderBy('sort')
            ->get()
            ->first();

        return $step instanceof Step ? $step : null;

    }

    public function getInfo() : array
    {
        $result = [];
        try
        {
            $description =  $this->getDescription();
            $filesQuery = $this->files()->get();
            $files = [];
            if ($filesQuery)
                /** @var File $file */
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

            /** @var Question $question */
            $question = $this->getQuestion();
            $answers = [];
            if ($question instanceof Question)
                $answers = $question->answers()->orderBy('sort')->get()->keyBy('id')->all();

            $result['step'] = [
                'id'          => $this->getId(),
                'title'       => $this->getTitle(),
                'code'        => $this->getCode(),
                'sort'        => $this->getSort(),
                'description' => $description instanceof Description ? $description :  new \stdClass(),
                'files'       => $files ? : [],
                'question'    => $question instanceof Question && $answers ? $question : new \stdClass(),
                'answers'     => $question instanceof Question && $answers ? $answers : [],
            ];
        }
        catch (\Throwable $exception)
        {
            $result = [];
        }
        return $result;
    }
}
