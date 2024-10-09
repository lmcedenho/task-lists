import Swal from 'sweetalert2';

const SweetAlert2 = {
  install(app) {
    app.config.globalProperties.$swal = Swal;
  },
};

export default SweetAlert2;