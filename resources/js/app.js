import 'preline';
import 'flowbite';

window.addEventListener('alert', (event)=>{

    let data = event.detail;
    Swal.fire({
        position: data.position,
        icon: data.type,
        title: data.title,
        timer: 2500,
        showConfirmButton: false,

    })
});
