
document.addEventListener('alpine:init', () => {
  Alpine.store('reactive', {
    
    lowongan: '',
    search_type: '',
    lowongan_search: '',
    placeholder: '',
    
    filterInit(){
      this.getSorted();
    },
    
    // return list of job with filter or search
    result: function() {  
      if(this.search_type != ''){
        return this.lowongan_search;
      }
      return this.lowongan;
    },


    // Search Feature
    fetchSearch(param){
      if(param.value == '') this.result();
      this.search_type = param.value;

      let search = []
      this.lowongan.filter(a => {
          if((a.name).toLowerCase().includes(param.value)){
            search.push(a);
          }
          
      })
      this.lowongan_search = search;
    
    },

    // Filter Feature
    async getSorted(param = 'terbaru'){
      await (await fetch(`/filters/${param}`)).json().then(res => {
        this.lowongan = res;
        return res;
      })
    },

    isEmpty(){
      if(this.result() == '' && this.search_type != ''){
        this.placeholder = 'Tidak Ada Hasil!';
        return true;
      }else if( this.result() == '' && this.search_type == ''){
        this.placeholder = 'Loading...';
        return true;
      } else{
        return false;
      }
    }

  })
})


document.addEventListener('alpine:init', () => {
  Alpine.data('home', () => ({

    filterType: false,
    sortedBy: false,
    search:'',
  }));
})


document.addEventListener('alpine:init', () => {
    Alpine.data('apply', () => ({

      apply: false,
      current_pos: 1,
      tipe_magang: '',

      fields: [],
      fields_len: 0,

      // input data leader
      job_lead: '',
      cv_lead: '',
      
      // date start & date end 
      start_date: '',
      end_date: '',


      // validate if it valid email n if file pdf or not

      email_invalid: [false,false,false,false,false],
      cv_invalid: [false,false,false,false,false,false],


      // Multi Step form functionality

      next(){

        // if(this.start_date == '' || this.end_date == ''){
        //   this.showAlert('Tanggal tidak boleh kosong!','');
        //   return;
        // } 
        
        
        if(this.current_pos == 2){
          console.log("result", this.email_invalid, this.cv_invalid);
          
          if(this.job_lead == ''){
            return this.showAlert('Pilih <em>job</em> yang akan dipilih!', this.$event);
          }

          if(this.cv_lead == '' || this.cv_invalid[0]){
            return this.showAlert('CV ketua tidak sesuai, <br> Mohon coba lagi!', this.$event);
          }

          if(this.tipe_magang == ''){
            return this.showAlert('Masukan Tipe Magang yang akan dijalankan!', this.$event);
          }
          
          if(this.tipe_magang == 'kelompok'){

            if(this.fields.length <= 0){
              return this.showAlert("Mohon masukan anggota magang kamu!", this.$event);
            }

            console.log(this.fields);

            for (const field of this.fields) {
              if(field.name == '' || field.email == '' || field.job == '' || field.cv == ''){
                return this.showAlert("Input tidak boleh kosong, <br> Mohon coba lagi!", this.$event);
              }
            }

            if(this.cv_invalid.indexOf(true,1) != -1){
              return this.showAlert("CV tidak valid, <br> Mohon coba lagi!", this.$event);
            }

            if(this.email_invalid.indexOf(true) != -1){
              return this.showAlert("Email tidak valid, <br> Mohon coba lagi!", this.$event);
            }
            
            
            return this.$event.preventDefault();
          }

        }
        if(this.current_pos >= 2){
          return console.log('stuck');
        } else{
          this.current_pos++;
        }
      },

      previous() {
        this.current_pos--;
      },

      add_field(){
        if(this.fields.length >= 5){
          return;
        }
        this.fields_len += 1;
        this.fields.push({
          name: '',
          email: '',
          job: '',
          cv: '',
        });
      },

      cek_output(){
        return (this.tipe_magang == 'kelompok') ? true : false;
      },

      remove(idx){
        console.log(this.fields, idx);
        this.fields.forEach((item, i) => {
          if(i != idx){
            item.cv = '';
          }
        });
        this.fields.splice(idx, 1);
        return;
      },

      getSubmit(){
        console.log(this.cv_lead, this.job_lead);
      },


      validateCV(idx){
        if(this.fields[idx]?.cv == undefined) return;
        return this.processValidateCV(this.fields[idx].cv, ++idx);
      },


      // Process CV Validation
      processValidateCV(param = '',idx = 0){
        console.log('index',idx);
        let temp = (param == '') ? this.cv_lead : param;
        result = temp.split(".");

        if(result[result.length - 1] == 'pdf' && result != ''){
          this.cv_invalid[idx] = false;
          return true;
        } else{
          this.cv_invalid[idx] = true;
          return false;
        }
      },


      validateEmail(idx){
        if(this.fields[idx]?.email == undefined) return;

        let regex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g
        if(regex.test(this.fields[idx].email)){
          this.email_invalid[idx] = false;
          return true;
        } else{
          this.email_invalid[idx] = true;
          return false;
        }
      },


      // card warning
      showAlert(param = 'Terjadi Masalah. <br> Silahkan Coba Lagi!',event, icon = 'error'){
        if(event != '') event.preventDefault();

        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          
          Toast.fire({
            icon: icon,
            title: param
          })
      }
    }));
})


document.addEventListener('alpine:init', () => {
  Alpine.data('auth', () => ({

    FirstPASS:'',
    SecondPASS:'',
    warningMsg: '',

    isVisible1: false,
    toggle1() {
        this.isVisible1 = !this.isVisible1;
    },

    isVisible2: false,
    toggle2() {
        this.isVisible2 = !this.isVisible2;
    },

    match() {
      if(this.FirstPASS != this.SecondPASS){
        this.warningMsg = 'Password tidak sama, silahkan coba lagi!';
        this.$event.preventDefault();
      }
    }
  }));
})
