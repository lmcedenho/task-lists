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

    <h3 class="text-lg font-semibold text-gray-800">Tareas Existentes</h3>
    <div v-for="(task, index) in existingTasks" :key="index" class="mb-4">
      <label class="block text-sm font-semibold text-gray-800">Tarea {{ index + 1 }}</label>
      <input type="text" :value="task.name" readonly class="mt-1 block w-full p-2 border border-gray-300 rounded-md bg-gray-200 cursor-not-allowed" />
    </div>

    <h3 class="text-lg font-semibold text-gray-800 mt-6">Tareas Nuevas</h3>
    <div v-for="(task, index) in tasks" :key="index" class="mb-4">
      <label class="block text-sm font-semibold text-gray-800">Nueva Tarea {{ index + 1 }}</label>
      <input v-model="task.name" type="text" required class="mt-1 block w-full p-2 border border-gray-400 rounded-md focus:ring focus:ring-blue-400 focus:outline-none" />
      <button type="button" @click="removeTask(index)" class="mt-1 text-red-600 hover:text-red-800">Eliminar Tarea</button>
    </div>
    <button type="button" @click="addTask" class="mb-4 bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded focus:outline-none focus:ring focus:ring-blue-400">
      Agregar Nueva Tarea
    </button>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
      Guardar Lista
    </button>
  </form>
</template>

<script>
export default {
  props: {
    taskList: Object,
    existingTasks: Array,
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
    async submitForm() {
      const data = {
        name: this.taskList.name,
        description: this.taskList.description,
        tasks: this.tasks,
      };
      try {
        await axios.put(`/task-lists/${this.taskList.id}`, data);
        window.location.href = '/task-lists';
      } catch (error) {
        console.error('Error al guardar la lista de tareas', error);
      }
    },
  },
  mounted() {
    this.tasks = this.tasks || [];
  },
};
</script>
