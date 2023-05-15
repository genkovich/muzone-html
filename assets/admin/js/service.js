import jQuery from 'jquery';
import toastr from "toastr";
window.$ = window.jQuery = jQuery;



// $(document).ready(function () {
//     const createServiceRoute = window.serviceData.create_route;
//
//     // Add validation to the form
//     $('#add-new-service-form').on('submit', function (event) {
//         event.preventDefault();
//         if (!this.checkValidity()) {
//             event.stopPropagation();
//         } else {
//             // Handle form submission (e.g., via AJAX)
//             addNewService();
//         }
//         this.classList.add('was-validated');
//     });
//
//     function addNewService() {
//         const title = $("#title").val();
//         const price = $("#price").val();
//         const currency = $("#currency").val();
//         const direction = $("#direction").val();
//         const lessonsCount = $("#lessons_count").val();
//         const age = $("#age").val();
//
//         $.ajax({
//             url: createServiceRoute,
//             type: 'POST',
//             data: {
//                 title: title,
//                 price: price,
//                 currency: currency,
//                 direction: direction,
//                 lessons_count: lessonsCount,
//                 age: age
//             },
//             success: function (response) {
//                 if (response.success) {
//                     toastr.success('Нова послуга успішно додана');
//                     location.reload();
//                 } else {
//                     toastr.error('Помилка при збереженні нової послуги');
//                 }
//             },
//             error: function () {
//                 toastr.error('Помилка на боці сервера, спробуйте пізніше або зверніться до адміністратора');
//             }
//         });
//     }
//
// });
