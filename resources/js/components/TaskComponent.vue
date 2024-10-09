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
import { ref, onMounted } from 'vue';

export default {
  props: {
    taskList: Object,
    existingTasks: Array,
    isEditing: Boolean,
  },
  setup(props) {
    const tasks = ref([{ name: '' }]); // Inicializa con una nueva tarea
    const existingTasks = ref(props.existingTasks); // Usar la prop existente

    // Función para agregar nueva tarea
    const addTask = () => {
      tasks.value.push({ name: '' });
    };

    // Función para eliminar tarea
    const removeTask = (index) => {
      tasks.value.splice(index, 1);
    };

    // Función para eliminar tarea existente
    const removeExistingTask = async (taskId) => {
      // Muestra un diálogo de confirmación
      const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
      });

      // Si el usuario confirma, proceder a eliminar la tarea
      if (result.isConfirmed) {
        try {
          let response = await axios.delete(`/tasks/${taskId}`);

          // Verifica si la respuesta es exitosa
          if (response.status === 200) {
            await Swal.fire({
              title: 'Éxito!',
              text: response.data.message || 'Tarea eliminada correctamente.',
              icon: 'success',
              confirmButtonText: 'Aceptar',
            });

            // Filtra la tarea eliminada de la lista existente
            existingTasks.value = existingTasks.value.filter(task => task.id !== taskId);
          }
        } catch (error) {
          let errorMessage = error.response?.data?.message || 'Error al eliminar la tarea.';
          await Swal.fire({
            title: 'Error!',
            text: errorMessage,
            icon: 'error',
            confirmButtonText: 'Aceptar',
          });
        }
      }
    };

    // Función para enviar el formulario
    const submitForm = async () => {
      const data = {
        name: props.taskList.name,
        description: props.taskList.description,
        tasks: tasks.value.filter(task => task.name),
      };

      try {
        let response;
        if (props.isEditing) {
          response = await axios.put(`/task-lists/${props.taskList.id}`, data);
        } else {
          response = await axios.post('/task-lists', data);
        }

        await Swal.fire({
          title: 'Éxito!',
          text: response.data.message || 'La lista de tareas se ha guardado correctamente.',
          icon: 'success',
          confirmButtonText: 'Aceptar',
        });

        window.location.href = '/task-lists';
      } catch (error) {
        let errorMessage = error.response?.data?.message || 'Error al guardar la lista de tareas.';
        await Swal.fire({
          title: 'Error!',
          text: errorMessage,
          icon: 'error',
          confirmButtonText: 'Aceptar',
        });
      }
    };

    // Sincroniza existingTasks al montar el componente
    onMounted(() => {
      existingTasks.value = props.existingTasks;
    });

    return {
      tasks,
      existingTasks,
      addTask,
      removeTask,
      removeExistingTask,
      submitForm,
    };
  },
};
</script>
