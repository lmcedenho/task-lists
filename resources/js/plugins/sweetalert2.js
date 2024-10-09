import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.delete-button');

  deleteButtons.forEach(button => {
      button.addEventListener('click', function (e) {
          e.preventDefault();

          const form = this.closest('.delete-form');

          Swal.fire({
              title: '¿Estás seguro?',
              text: "No podrás revertir esto",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí, eliminar',
              cancelButtonText: 'Cancelar',
          }).then((result) => {
              if (result.isConfirmed) {
                  form.submit();
              }
          });
      });
  });
});

const SweetAlert2 = {
  install(app) {
    app.config.globalProperties.$swal = Swal;
  },
};

export default SweetAlert2;