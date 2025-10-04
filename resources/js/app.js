import './bootstrap';
import '../css/app.css';
import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
// window.Swal = Swal;


//   window.confirmDialog = Swal.mixin({
//     icon: 'warning',
//     customClass: {
//       confirmButton: "btn btn-danger",
//       cancelButton: "btn btn-secondary tw-mr-2"
//     },
//     reverseButtons: true,
//     showCancelButton: true,
//     cancelButtonText: 'Cancel',
//     confirmButtonText: 'Confirm',
//     buttonsStyling: false
//   });


  window.showAlert = function() {
    Swal.fire({
        title: 'Success!',
        text: 'This is working in Laravel 12 with Vite.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

Alpine.start();