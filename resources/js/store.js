import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'; // Asegúrate de tener axios instalado

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        tasks: [] // Estado inicial para las tareas
    },
    mutations: {
        ADD_TASK(state, task) {
            state.tasks.push(task);
            state.tasks = state.tasks.reverse();
        },
        UPDATE_TASK(state, updatedTask) {
            const index = state.tasks.findIndex(t => t.id === updatedTask.id);
            if (index !== -1) {
                Vue.set(state.tasks, index, updatedTask);
            }
        },
        DELETE_TASK(state, taskId) {
            state.tasks = state.tasks.filter(t => t.id !== taskId);
        },
        FETCH_TASKS(state, tasks) {
            state.tasks = tasks;
        }
    },
    actions: {
        addTask({ commit }, task) {
            axios.post('/tasks', task)
                .then(response => {
                    commit('ADD_TASK', response.data.task);
                })
                .catch(error => {
                    console.error("Error adding task:", error);
                });
        },
        completeTask({ commit }, taskId) {
            axios.put(`/tasks/${taskId}`)
                .then(response => {
                    commit('UPDATE_TASK', response.data.task);
                })
                .catch(error => {
                    console.error("Error updating task:", error);
                });
        },
        deleteTask({ commit }, taskId) {
            axios.delete(`/tasks/${taskId}`)
                .then(() => {
                    commit('DELETE_TASK', taskId);
                })
                .catch(error => {
                    console.error("Error deleting task:", error);
                });
        },
        fetchTasks({ commit }) {
            axios.get('/tasks')
                .then(response => {
                    commit('FETCH_TASKS', response.data);
                })
                .catch(error => {
                    console.error("Error getting tasks:", error);
                });
        }
    },
    getters: {
        tasks: state => state.tasks
    }
});
