<template>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Task List</h1>
        <ul class="list-group mb-4">
            <li v-for="task in tasks" :key="task.id" class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ task.title }}</h5>
                    <p class="mb-1">{{ task.description }}, Completed: {{ task.completed }}</p>
                    <small class="text-muted">Assigned to: {{ task.user.name }} {{ task.user.email }}</small>
                </div>
                <div>
                    <button class="btn btn-success btn-sm mr-2" @click="completeTask(task.id, task)">Complete</button>
                    <button class="btn btn-danger btn-sm" @click="deleteTask(task.id)">Delete</button>
                </div>
            </li>
        </ul>
        <form @submit.prevent="addTask" class="card card-body">
            <div class="form-group">
                <input v-model="newTask.title" class="form-control" placeholder="Task Title" required>
            </div>
            <div class="form-group">
                <input v-model="newTask.description" class="form-control" placeholder="Task Description" required>
            </div>
            <div class="form-group">
                <input v-model="newTask.email" class="form-control" placeholder="Assigned User E-mail" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Task</button>
        </form>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    data() {
        return {
            newTask: {
                title: '',
                description: '',
                user: {},
                email: ''
            }
        };
    },
    computed: {
        ...mapState(['tasks']) // Simplificado para mapState
    },
    methods: {
        ...mapActions(['fetchTasks', 'addTask', 'completeTask', 'deleteTask']),
        addTask() {
            if (!this.newTask.title || !this.newTask.description || !this.newTask.email) {
                alert('Both title and description are required');
                return;
            }

            // Se utiliza la acción 'addTask' y luego se limpia el formulario
            this.$store.dispatch('addTask', this.newTask).then(() => {
                this.newTask.title = '';
                this.newTask.description = '';
                this.newTask.email = '';
            }).catch(error => {
                console.error('Error adding task:', error);
            });
        },
        completeTask(taskId) {
            // Se utiliza la acción 'completeTask'
            this.$store.dispatch('completeTask', taskId).catch(error => {
                console.error('Error completing task:', error);
            });
        },
        deleteTask(taskId) {
            // Se utiliza la acción 'deleteTask'
            this.$store.dispatch('deleteTask', taskId).catch(error => {
                console.error('Error deleting task:', error);
            });
        },
        fetchTasks() {
            // Se utiliza la acción 'fetchTasks'
            this.$store.dispatch('fetchTasks').catch(error => {
                console.error('Error fetching tasks:', error);
            });
        }
    },
    mounted() {
        this.fetchTasks();
    }
};
</script>
