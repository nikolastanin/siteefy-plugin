<?php /* Template Name: Homepage Template */
$tasks = get_all_tasks(5);
$solutions = get_all_solutions(5);
$solutions_collection = array();
$tools_collection = array();
$listing_limit = 6;

foreach ($tasks as $task){
    $task_id = $task->ID;
    $tools_by_task_id = get_tools_by_task_id($task_id);
    $tools_collection[$task_id] = array_slice($tools_by_task_id, 0, $listing_limit);
}

foreach ($solutions as $solution){
    $solution_id = $solution->term_id;
    $tools_by_solution_id = get_tools_by_solution_id($solution_id);
    $solutions_collection[$solution_id] = array_slice($tools_by_solution_id, 0, $listing_limit);
}

echo Siteefy::blade()->run('pages.homepage-template', [
    'tasks' => $tasks,
    'solutions'=>$solutions,
    'tools_collection_by_tasks' =>$tools_collection,
    'tools_collection_by_solutions' =>$solutions_collection,
    'recent_tools' => get_all_tools(3, 'DESC'),
]);
?>
