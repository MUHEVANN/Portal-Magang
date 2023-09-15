
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
  Alpine.store('ajax', {
    
    lowongan: '',
    type: '',

    init(){
      this.getSorted();
    },


    async getSorted(param = 'terbaru'){
      await (await fetch(`filters/${param}`)).json().then(res => {
        this.lowongan = res;
        console.log('get result', this.type, res)
        return res;
      })
    }
  })
})


document.addEventListener('alpine:init', () => {
  Alpine.data('home', () => ({

    filterType: false,
    sortedBy: false,
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