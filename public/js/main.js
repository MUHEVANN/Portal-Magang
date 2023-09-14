
// function inform(param){
//     const Toast = Swal.mixin({
//         toast: true,
//         position: 'bottom-end',
//         showConfirmButton: false,
//         timer: 3000,
//         timerProgressBar: true,
//         didOpen: (toast) => {
//           toast.addEventListener('mouseenter', Swal.stopTimer)
//           toast.addEventListener('mouseleave', Swal.resumeTimer)
//         }
//       })
      
//       Toast.fire({
//         icon: 'success',
//         title: param
//       })
// }

document.addEventListener('alpine:init', () => {
  Alpine.data('home', () => ({

    lowongan: {},
    filterType: false,
    sortedBy: false,
    type: 'terbaru',

    async getSorted(){
      this.lowongan = await (await fetch(`filters/${type}`)).json();
      console.log(this.lowongan);
    }
  }));
})

document.addEventListener('alpine:init', () => {
    Alpine.data('apply', () => ({

      apply: false,
      current_pos: 1,
      output: '',
      fields: [],

      next(){
        this.current_pos++;
      },
      previous() {
        this.current_pos--;
      },

      add_field(){
        this.fields.push('space');
      },

      cek_output(){
        if(this.output == 'kelompok'){
          return true;
        }
         return false;
      },

      remove(param){
        console.log(param);
        this.fields.splice(param, 1);
      }
    }));
})