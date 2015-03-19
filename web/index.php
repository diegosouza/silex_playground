<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Todo\Silex\Provider\Respect\RespectRelationalServiceProvider;
use Todo\Interactors\TaskListInteractor;
use Todo\Interactors\TaskSaverInteractor;
use Todo\Interactors\TaskRemoverInteractor;
use Todo\Repositories\TaskRepository;
use Todo\Models\Task;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../app.log',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/views'
));

$pdo = new \PDO('sqlite:' . __DIR__ . '/../database.sqlite');
$pdo->exec("create table if not exists tasks(id integer primary key, text text)");

$app->register(new RespectRelationalServiceProvider(), array(
    'respect.pdo.instances' => array($pdo)
));

$app['respect.mapper']->entityNamespace = '\\Todo\\Models';

$app['db'] = $app->share(function($app) {
    return $app['respect.mapper'];
});



$app['task_list_interactor'] = $app->share(function($app) {
    $repository = new TaskRepository($app['respect.mapper']);
    return new TaskListInteractor($repository);
});

$app['task_saver_interactor'] = $app->share(function($app) {
    $repository = new TaskRepository($app['respect.mapper']);
    return new TaskSaverInteractor($repository);
});

$app['task_remover_interactor'] = $app->share(function($app) {
    $repository = new TaskRepository($app['respect.mapper']);
    return new TaskRemoverInteractor($repository);
});

$app->get('/', function() use($app) {
    $request = Request::create('/tasks', 'GET');
    return $app->handle($request, HttpKernelInterface::SUB_REQUEST);
});

$app->get('/tasks', function() use($app) {
    $params = array('tasks' => $app['task_list_interactor']->all());
    return $app['twig']->render('task_list.twig', $params);
});

$app->post('/tasks', function() use($app) {
    $task = new Task($app['request']->get('text'));
    $app['task_saver_interactor']->save($task);

    return $app->redirect('/tasks');
});

$app->delete('/task/{id}', function($id) use($app) {
    $app['task_remover_interactor']->remove($id);

    return $app->redirect('/tasks');
});

Request::enableHttpMethodParameterOverride();
$app->run();

