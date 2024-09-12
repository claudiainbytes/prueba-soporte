<?php

use Illuminate\Database\Seeder;
use App\Models\Task as Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasks = factory(Task::class, 12)->create();
    }
}
