<template>
  <form @submit.prevent="submitForm" class="p-4 bg-white shadow rounded-md">
    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-800">Nombre de la Lista</label>
      <input v-model="taskList.name" type="text" required class="mt-1 block w-full p-2 border border-gray-400 rounded-md focus:ring focus:ring-blue-400 focus:outline-none" />
    </div>
    <div class="mb-4">
      <label class="block text-sm font-semibold text-gray-800">Descripción</label>
      <textarea v-model="taskList.description" class="mt-1 block w-full p-2 border border-gray-400 rounded-md focus:ring focus:ring-blue-400 focus:outline-none"></textarea>
    </div>

    <h3 class="text-lg font-semibold text-gray-800" v-if="isEditing">Tareas Existentes</h3>
    <div v-if="isEditing && existingTasks.length" v-for="(task, index) in existingTasks" :key="task.id" class="mb-4 flex items-center justify-between">
      <label class="block text-sm font-semibold text-gray-800">{{ task.name }}</label>
      <button type="button" @click="removeExistingTask(task.id)" class="text-red-600 hover:text-red-800">Eliminar Tarea</button>
    </div>
    <div v-if="isEditing && !existingTasks.length" class="mb-4">
      <p>No hay tareas existentes.</p>
    </div>

    <h3 class="text-lg font-semibold text-gray-800 mt-6">Tareas Nuevas</h3>
    <div v-for="(task, index) in tasks" :key="index" class="mb-4">
      <label class="block text-sm font-semibold text-gray-800">Nueva Tarea {{ index + 1 }}</label>
      <input v-model="task.name" type="text" :required="index > 0" class="mt-1 block w-full p-2 border border-gray-400 rounded-md focus:ring focus:ring-blue-400 focus:outline-none" />
      <button type="button" @click="removeTask(index)" class="mt-1 text-red-600 hover:text-red-800">Eliminar Tarea</button>
    </div>
    <button type="button" @click="addTask" class="float-right text-blue px-4 py-2 rounded mb-4">
      Agregar Nueva Tarea
    </button>
    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Guardar Lista
    </button>
  </form>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  props: {
    taskList: Object,
    existingTasks: Array,
    isEditing: Boolean,
  },
  data() {
    return {
      tasks: [{ name: '' }],
    };
  },
  methods: {
    addTask() {
      this.tasks.push({ name: '' });
    },
    removeTask(index) {
      this.tasks.splice(index, 1);
    },
    async removeExistingTask(taskId) {
      try {
        await axios.delete(`/tasks/${taskId}`);
        this.existingTasks = this.existingTasks.filter(task => task.id !== taskId);
      } catch (error) {
        console.error('Error al eliminar la tarea', error);
      }
    },
    async submitForm() {
      const data = {
        name: this.taskList.name,
        description: this.taskList.description,
        tasks: this.tasks.filter(task => task.name), // Filtrar tareas vacías
      };

      try {
        let response;
        if (this.isEditing) {
          response = await axios.put(`/task-lists/${this.taskList.id}`, data);
        } else {
          response = await axios.post('/task-lists', data);
        }

        await this.$swal.fire({
          title: 'Éxito!',
          text: response.data.message || 'La lista de tareas se ha guardado correctamente.',
          icon: 'success',
          confirmButtonText: 'Aceptar',
        });

        window.location.href = '/task-lists';
      } catch (error) {
        const errorMessage = error.response?.data?.message || 'Error al guardar la lista de tareas.';
        await this.$swal.fire({
          title: 'Error!',
          text: errorMessage,
          icon: 'error',
          confirmButtonText: 'Aceptar',
        });
      }
    },
  },
  mounted() {
    this.tasks = this.tasks || [];
  },
};
</script>
