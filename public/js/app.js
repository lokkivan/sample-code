$(document).ready(function() {
    const $app = $('#schedule-app');

    if ($app.length) {
        const $currentDay = $app.find('#current-day');
        const fetchTaskUrl = $app.find('#get-url').val();
        const config = JSON.parse($app.find('.schedule-config').val());
        const $taskTemplate = $app.find('#task-template');
        const $tasksList = $app.find('#tasks-list');
        const $createTaskForm = $app.find('#create-new-task').find('.form');
        const removeUrl = $app.find('#remove-url').val();
        const $daysButtons = $app.find('#days-of-week').find('.day');
        const updateUrl = $app.find('#update-url').val();
        let tasksByDayOfWeek = [];

        // FETCH TASKS
        $.get(fetchTaskUrl, function (response) {
            if (response.success === true) {
                tasksByDayOfWeek = parseTasksByDayOfWeek(response.data);
                setNewDay(
                    $currentDay,
                    1,
                    tasksByDayOfWeek,
                    $taskTemplate,
                    $tasksList,
                    config
                );
                updateTasksCounters(tasksByDayOfWeek, $daysButtons);
            }
        });

        // CLICK ON DAY BUTTON
        $app.find('.day').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            const $this = $(this);
            setNewDay(
                $currentDay,
                parseInt($this.data('day-value')),
                tasksByDayOfWeek,
                $taskTemplate,
                $tasksList,
                config
            );
        });

        // CLICK ON ADD NEW TASK BUTTON
        $app.find('#create-new-task').find('.submit-button').click(function (event) {
            event.preventDefault();
            event.stopPropagation();

            const id = parseInt($app.find('#create-new-task').find('.task-id').val());
            const time = $app.find('#time').val();
            const element = $app.find('#element').val();
            const temperature = $app.find('#temperature').val();
            const state = $app.find('#state-on').prop('checked') === true ? 1 : 0;
            const url = $app.find('.url').val();
            const day = $currentDay.data('day-integer');

            if (isNaN(id) || id === undefined) {
                // SEND POST
                $.post(url, {
                    'time': time,
                    'element': element,
                    'temperature': temperature,
                    'state': state,
                    'day': day
                }, function (response) {
                    if (response.success === true) {
                        $app.find('.success').removeClass('hidden');
                        addNewTask(response.data, config, $taskTemplate.clone(), $tasksList);
                        tasksByDayOfWeek[day].push({
                            day_of_week: day,
                            facility_id: response.data.facility_id,
                            id: response.data.id,
                            run: state,
                            start_time: time,
                            var_name: element,
                            var_value: temperature
                        });
                        updateTasksCounters(tasksByDayOfWeek, $daysButtons)
                    }
                })
            } else {
                // SEND PUT (POST, BUT ON UPDATE ROUTE =])
                $.post(updateUrl, {
                    'id': id,
                    'time': time,
                    'element': element,
                    'temperature': temperature,
                    'state': state,
                    'day': day
                }, function (response) {
                    if (response.success === true) {
                        $app.find('.success').removeClass('hidden');

                        // REMOVE OLD TASK
                        const $task = $app.find('.task').find("[value='" + id + "']").parent('.task');
                        tasksByDayOfWeek = removeTaskFromSortedTasks(getTask($task, tasksByDayOfWeek), tasksByDayOfWeek);
                        $task.remove();

                        addNewTask(response.data, config, $taskTemplate.clone(), $tasksList);
                        tasksByDayOfWeek[day].push({
                            day_of_week: day,
                            facility_id: response.data.facility_id,
                            id: response.data.id,
                            run: state,
                            start_time: time,
                            var_name: element,
                            var_value: temperature
                        });
                        updateTasksCounters(tasksByDayOfWeek, $daysButtons)
                    }
                })
            }
        });

        // SHOW / HIDE TASK FORM
        $app.find('#control-button').click(function () {
            const $createNewTask = $app.find('#create-new-task');
            const $this = $(this);

            if ($createNewTask.css('display') === 'none') {
                $app.find('.success').addClass('hidden');
                $createNewTask.css('display', 'block');
                $this.text('Скрыть задачу');
            } else {
                $createNewTask.css('display', 'none');
                $this.text('Добавить/Показать задачу');
            }
        });

        // CLICK ON EDIT BUTTON
        $app.on('click', '.control-edit', function () {
            const $task = $(this).parent('.task-control').parent('.task');
            const task = getTask($task, tasksByDayOfWeek);
            const $newTaskBlock = $app.find('#create-new-task');

            $createTaskForm.find('.task-id').val(task.id);
            $createTaskForm.find('#time').val(task.start_time);
            $createTaskForm.find('#element').val(task.var_name);
            $createTaskForm.find('#temperature').val(task.var_value);

            if (task.run === 1) {
                $createTaskForm.find('#state-on').prop('checked', true);
                $createTaskForm.find('#state-off').prop('checked', false);
            } else {
                $createTaskForm.find('#state-on').prop('checked', false);
                $createTaskForm.find('#state-off').prop('checked', true);
            }

            $createTaskForm.find('#state').val(task.run);
            $createTaskForm.find('.submit-button').text('Сохранить');

            if ($newTaskBlock.css('display') === 'none') {
                $newTaskBlock.css('display', 'block');
            }

            $app.find('#control-button').text('Скрыть задачу');
        });

        // CLICK ON REMOVE BUTTON
        $app.on('click', '.control-remove', function () {
            const $task = $(this).parent('.task-control').parent('.task');
            const task = getTask($task, tasksByDayOfWeek);

            removeTask(task, $task, removeUrl);
            tasksByDayOfWeek = removeTaskFromSortedTasks(task, tasksByDayOfWeek);
            updateTasksCounters(tasksByDayOfWeek, $daysButtons);
        });

        // CLEAR FORM
        $app.find('.clear-form-button').click(function () {
            $createTaskForm.find('.task-id').val(null);
            $createTaskForm.find('#time').val('00:00');
            $createTaskForm.find('#temperature').val(0);
            $createTaskForm.find('#state-on').prop('checked', true);
            $createTaskForm.find('#state-off').prop('checked', false);
            $createTaskForm.find('.submit-button').text('Добавить');
        });
    }
});

function setNewDay($currentDay, day, tasksByDayOfWeek, $taskTemplate, $tasksList, config) {
    $currentDay.data('day-integer', day);

    switch (day) {
        case 1: {
            $currentDay.text('Понедельник');
            break;
        }
        case 2: {
            $currentDay.text('Вторник');
            break;
        }
        case 3: {
            $currentDay.text('Среда');
            break;
        }
        case 4: {
            $currentDay.text('Четверг');
            break;
        }
        case 5: {
            $currentDay.text('Пятница');
            break;
        }
        case 6: {
            $currentDay.text('Суббота');
            break;
        }
        case 7: {
            $currentDay.text('Воскресенье');
            break;
        }
        default: {
            break;
        }
    }

    $tasksList.find('tr').remove();

    const currentTasks = tasksByDayOfWeek[day];

    for (let iter = 0; iter < currentTasks.length; iter++) {
        addNewTask(currentTasks[iter], config, $taskTemplate.clone(), $tasksList);
    }
}

function parseTasksByDayOfWeek(tasks) {
    const sortedTasks = {};

    for (let iter = 1; iter <= 7; iter++) {
        sortedTasks[iter] = [];
    }

    for (let iter = 0; iter < tasks.length; iter++) {
        const task = tasks[iter];

        if (task.start_time.length > 5) {
            let time = task.start_time + "";
            task.start_time = time.substring(0, 5);
        }

        sortedTasks[tasks[iter]['day_of_week']].push(task);
    }

    return sortedTasks;
}

function addNewTask(taskJson, config, $newTask, $tasksList) {
    if (taskJson !== undefined && taskJson !== null) {
        $newTask.find('.task-id').val(taskJson.id);
        $newTask.find('.task-time').text(taskJson.start_time);
        $newTask.find('.task-element').text(config[taskJson.var_name]);
        $newTask.find('.task-temperature').text(taskJson.var_value);
        $newTask.find('.task-state').text(parseInt(taskJson.run) === 1 ? 'Вкл' : 'Выкл');

        if (taskJson.last_run === undefined) {
            $newTask.find('.task-last-run').text('Никогда');
        } else {
            $newTask.find('.task-last-run').text(taskJson.last_run === null ? 'Никогда' : taskJson.last_run);
        }

        $newTask.removeAttr('id');
        $newTask.removeClass('hidden');

        $tasksList.append($newTask);
    }
}

function getTask($task, tasksByDayOfWeek) {
    const id = parseInt($task.find('.task-id').val());

    for(let day = 1; day <= 7; day++) {
        const currentTasks = tasksByDayOfWeek[day];

        if (currentTasks.length > 0) {
            for (let iter = 0; iter < currentTasks.length; iter++) {
                const task = currentTasks[iter];

                if (task.id === id) {
                    return task;
                }
            }
        }
    }

    return null;
}

function removeTask(task, $task, removeUrl) {
    $task.remove();

    $.post(removeUrl, {
        id: task.id,
    });
}

function removeTaskFromSortedTasks(taskForRemove, tasksByDayOfWeek) {
    for(let day = 1; day <= 7; day++) {
        const currentTasks = tasksByDayOfWeek[day];

        if (currentTasks.length > 0) {
            for (let iter = 0; iter < currentTasks.length; iter++) {
                const task = currentTasks[iter];

                if (task.id === taskForRemove.id) {
                    tasksByDayOfWeek[day].splice([iter], 1);

                    return tasksByDayOfWeek;
                }
            }
        }
    }

    return tasksByDayOfWeek;
}

function updateTasksCounters(tasksByDayOfWeek, $daysButtons) {
    for (let iter = 0; iter < $daysButtons.length; iter++) {
        const $currentButton = $($daysButtons[iter]);
        const day = parseInt($currentButton.data('day-value'));
        const tasksLength = tasksByDayOfWeek[day].length;

        if (tasksLength !== 0) {
            $currentButton.find('.tasks-count').text(tasksLength);
        } else {
            $currentButton.find('.tasks-count').text('');
        }
    }
}