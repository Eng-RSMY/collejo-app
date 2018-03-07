<?php

namespace Collejo\App\Models;

use Collejo\App\Database\Eloquent\Model;

class Clasis extends Model
{
    protected $table = 'classes';

    protected $fillable = ['grade_id', 'name'];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'id', 'student_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}