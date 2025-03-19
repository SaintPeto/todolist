document.addEventListener("DOMContentLoaded", function () {
    loadTasks();

    document.getElementById("taskForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let taskInput = document.getElementById("taskInput").value.trim();
        let categoryInput = document.getElementById("categoryInput").value.trim();

        if (taskInput && categoryInput) {
            let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
            tasks.push({ task: taskInput, category: categoryInput, completed: false });
            localStorage.setItem("tasks", JSON.stringify(tasks));

            // Clear input fields
            document.getElementById("taskInput").value = "";
            document.getElementById("categoryInput").value = "";

            loadTasks();
        }
    });
});

// ✅ Loads tasks from localStorage and displays them correctly
function loadTasks() {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    let taskList = document.getElementById("taskList");
    let completedTasks = document.getElementById("completedTasks");

    // Clear the existing UI before rendering new data
    taskList.innerHTML = "";
    completedTasks.innerHTML = "";

    tasks.forEach((task, index) => {
        let div = document.createElement("div");
        div.classList.add("task-item");

        div.innerHTML = `
            <span class="task-text">${task.task} - <strong>${task.category}</strong></span>
            <span class="button-group">
                ${!task.completed ? `<button class="complete-btn" onclick="completeTask(${index})">✓</button>` : ""}
                <button class="delete-btn" onclick="deleteTask(${index})">X</button>
            </span>
        `;

        // ✅ Append task to the correct section
        if (task.completed) {
            div.classList.add("completed");
            completedTasks.appendChild(div);
        } else {
            taskList.appendChild(div);
        }
    });
}

// ✅ Mark a task as completed
function completeTask(index) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks[index].completed = true;
    localStorage.setItem("tasks", JSON.stringify(tasks));
    loadTasks();
}

// ✅ Delete a task
function deleteTask(index) {
    let tasks = JSON.parse(localStorage.getItem("tasks")) || [];
    tasks.splice(index, 1);
    localStorage.setItem("tasks", JSON.stringify(tasks));
    loadTasks();
}
